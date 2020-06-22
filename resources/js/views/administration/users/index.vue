<template>

    <div>
        <v-overlay :value="isLoading">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

        <v-row auto-grow>
            <v-col cols="12">
                <v-card outlined>
                    <v-toolbar flat>
                        <v-toolbar-title class="grey--text">Listado de usuarios</v-toolbar-title>

                        <v-spacer></v-spacer>

                        <v-btn>
                            <v-btn color="primary" @click="newDialog = true"><v-icon>mdi-plus</v-icon></v-btn>
                        </v-btn>

                    </v-toolbar>

                        <v-card-text>
                            <template v-for="user in users">

                                <v-row>
                                    <v-col cols="12">
                                        <v-container>
                                            <v-card raised elevation="24">
                                                <v-card-title>{{ user.name }}</v-card-title>
                                                <v-card-text>
                                                    <v-row>
                                                        <v-col cols="6">
                                                            <v-avatar class="ma-3" size="125" tile>
                                                                <v-img :src="user.profile_image_url" dark="true" ></v-img>
                                                            </v-avatar>
                                                        </v-col>
                                                        <v-col cols="6">
                                                            <p><strong >Nombre de usuario: {{ user.username }}</strong></p>
                                                            <p><strong >Email: {{ user.email }}</strong></p>
                                                            <v-chip v-for="profile in user.roles" color="blue" :key="profile.id">
                                                                {{ profile.name }}
                                                            </v-chip>
                                                        </v-col>
                                                    </v-row>
                                                </v-card-text>

                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn color="#dc3545"><strong class="text-">Eliminar Usuario</strong></v-btn>
                                                    <v-btn class="warning" @click="editUser(user)">Editar Usuario</v-btn>
                                                </v-card-actions>

                                            </v-card>
                                        </v-container>
                                    </v-col>
                                </v-row>

                            </template>
                        </v-card-text>

                        <v-pagination v-model="currentPage" :length="lastPage"></v-pagination>


                </v-card>
            </v-col>
        </v-row>






        <!-- Dialog for updating the user"-->

        <edit-user-dialog v-if="updateDialog" v-bind:userObject="selectedUser" v-on:cancelUpdate="cancelUpdate()"@update-user="updateUser"></edit-user-dialog>
        <new-user-dialog v-if="newDialog" v-on:closeDialog="newDialog = false" @store-user="storeUser"></new-user-dialog>

    </div>

</template>

<script>

    import axios from 'axios';

    export default {
        mounted () {
            this.getUsers()
        },
        data: function() {
            return {
                isLoading: true,
                updateDialog: false,
                newDialog: false,
                users: {},
                selectedUser: {},
                lastPage: 1,
                currentPage: 1,
                searchFields: {
                    name: ''
                }
            }

        },
        methods: {
            getUsers: function() {

                let me = this

                axios.get('/api/Administration/users?page=' + me.currentPage, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('access_token')
                    }
                })
                .then(function(response) {

                    me.users = response.data.data
                    me.lastPage = response.data.last_page;

                }).catch(function (res) {

                    switch(res.response.status) {
                        case 422:
                            me.$handleErrors(res.response.data.errors)
                            break
                        case 404:
                            me.message('error', 'Oops! Ha ocurrido un error de sistema. (404)')
                            break
                        case 401:
                            me.message('error', 'Usted no está autorizado a ver usuarios.')
                            break
                        default:
                            me.message('error', 'Oops! Ha ocurrido un error de sistema. (' + res.response.status + ')')
                            break
                    }

                })
                .finally(function() {

                    me.isLoading = false

                });


            },
            storeUser: function(user) {
                let me = this

                me.isLoading = true

                axios.post('/api/Administration/users', user, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('access_token')
                    }
                })
                .then(function() {
                    me.newDialog = false
                    me.message('success', 'Usuario creado con éxito!')
                    me.getUsers();

                }).catch(function(res) {

                    switch(res.response.status) {
                        case 422:
                            me.$handleErrors(res.response.data.errors)
                            break
                        case 404:
                            me.message('error', 'Oops! Ha ocurrido un error al crear el usuario.')
                            break
                        case 401:
                            me.message('error', 'Usted no está autorizado a crear usuarios.')
                            break
                        default:
                            me.message('error', 'Oops! Ha ocurrido un error de sistema.')
                            break
                    }
                })
                .finally(function() {
                    me.isLoading = false
                });
            },
            updateUser: function(user) {
                let me = this

                me.isLoading = true

                axios.put('/api/Administration/users/' + user.id, {
                    name: user.name,
                    username: user.username,
                    email: user.email,
                    password: user.password,
                    repeat_password: user.repeat_password,
                }, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('access_token')
                    }
                })
                .then(function() {

                    me.updateDialog = false
                    me.message('success', 'Usuario actualizado con éxito!')
                    me.getUsers();

                }).catch(function(res) {

                    switch(res.response.status) {
                        case 422:
                            me.$handleErrors(res.response.data.errors)
                            break
                        case 404:
                            me.message('error', 'Oops! Ha ocurrido un error al actualizar el usuario.')
                            break
                        case 401:
                            me.message('error', 'Usted no está autorizado a actualizar usuarios.')
                            break
                        default:
                            me.message('error', 'Oops! Ha ocurrido un error de sistema.')
                            break
                    }

                })
                .finally(function() {
                    me.isLoading = false
                });

            },
            askForDelete: function(user) {
                let me = this
                let options = {
                    okText: 'Aceptar',
                    cancelText: 'Cancelar',
                    animation: 'zoom',
                    clicksCount: 2
                }

                this.$dialog
                    .confirm('¿Está seguro de que desea eliminar el usuario?', options)
                    .then(function(dialog) {
                         me.deleteUser(user.id)
                    })
                    .catch(function() {

                    });
            },
            deleteUser: function(userId) {
                let me = this

                me.isLoading = true

                axios.delete('/api/Administration/users/' + userId, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('access_token')
                    }
                })
                .then(function() {

                    me.getUsers()

                    me.message('success', 'Usuario eliminado con éxito!')

                }).catch(function(res) {

                    me.isLoading = false

                    switch(res.response.status) {
                        case 422:
                            me.$handleErrors(res.response.data.errors)
                            break
                        case 404:
                            me.message('error', 'Oops! Ha ocurrido un error al eliminar el usuario.')
                            break
                        case 401:
                            me.message('error', 'Usted no está autorizado a eliminar usuarios.')
                            break
                        default:
                            me.message('error', 'Oops! Ha ocurrido un error de sistema.')
                            break
                    }

                });
            },
            message: function(className, message) {
                Vue.toasted.show(message, {
                    className: className,
                    position: 'top-right',
                    duration: 5000
                })
            },
            editUser: function(user) {
                this.selectedUser = user

                this.updateDialog = true
            },
            cancelUpdate: function() {
                this.updateDialog = false
            }
        },
        watch: {
            currentPage: function(val) {
                this.isLoading = true
                this.getProfiles()
            }
        }
    }
</script>
