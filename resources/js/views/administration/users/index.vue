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

                        <v-btn icon>
                            <v-icon>mdi-magnify</v-icon>
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

        <edit-user-dialog v-if="updateDialog" v-bind:userObject="selectedUser" v-on:cancelUpdate="cancelUpdate()"></edit-user-dialog>

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
                    me.lastPage = response.data.lastPage;

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
            searchUsers: function() {
                let me = this
                if(this.searchFields.name !== '') {
                    me.search()
                } else {
                    me.getProfiles()
                }
            },
            search: function() {

                let me = this
                this.currentPage = 1
                axios.post('/api/Administration/Profiles/Search', {
                        searchFields: me.searchFields
                    },
                    {
                        headers: {
                            Authorization: "Bearer " + localStorage.getItem('access_token')
                        }
                    })
                    .then(function(response) {

                        me.profiles = response.data.data
                        me.lastPage = response.data.lastPage;

                    })
                    .catch(function (res) {

                        switch(res.response.status) {
                            case 422:
                                me.$handleErrors(res.response.data.errors)
                                break
                            case 404:
                                me.message('error', 'Oops! Ha ocurrido un error al buscar el perfil.')
                                break
                            case 401:
                                me.message('error', 'Usted no está autorizado a ver perfiles.')
                                break
                            default:
                                me.message('error', 'Oops! Ha ocurrido un error al buscar el perfil.')
                                break
                        }

                    })
                    .finally(function() {
                        me.isLoading = false
                    });

            },
            createUser: function() {
                let me = this

                me.isLoading = true

                axios.post('/api/Administration/Profiles', {
                    name: me.selectedProfile.name,
                }, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('access_token')
                    }
                })
                .then(function() {
                    me.selectedProfile = {}

                    me.getProfiles()

                    me.message('success', 'Perfil creado con éxito!')

                }).catch(function(res) {

                    switch(res.response.status) {
                        case 422:
                            me.$handleErrors(res.response.data.errors)
                            break
                        case 404:
                            me.message('error', 'Oops! Ha ocurrido un error al crear el perfil.')
                            break
                        case 401:
                            me.message('error', 'Usted no está autorizado a crear perfiles.')
                            break
                        default:
                            me.message('error', 'Oops! Ha ocurrido un error al crear el perfil.')
                            break
                    }
                })
                .finally(function() {
                    me.isLoading = false
                });
            },
            askForDelete: function(profile) {
                let me = this
                let options = {
                    okText: 'Aceptar',
                    cancelText: 'Cancelar',
                    animation: 'zoom',
                    clicksCount: 2
                }

                this.$dialog
                    .confirm('¿Está seguro de que desea eliminar el perfil?', options)
                    .then(function(dialog) {
                         me.deleteProfile(profile.id)
                    })
                    .catch(function() {

                    });
            },
            deleteProfile: function(profileId) {
                let me = this

                me.isLoading = true

                axios.delete('/api/Administration/Profiles/' + profileId, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('access_token')
                    }
                })
                .then(function() {

                    me.getProfiles()

                    me.message('success', 'Perfil eliminado con éxito!')

                }).catch(function(res) {

                    me.isLoading = false

                    switch(res.response.status) {
                        case 422:
                            me.$handleErrors(res.response.data.errors)
                            break
                        case 404:
                            me.message('error', 'Oops! Ha ocurrido un error al crear el perfil.')
                            break
                        case 401:
                            me.message('error', 'Usted no está autorizado a crear perfiles.')
                            break
                        default:
                            me.message('error', 'Oops! Ha ocurrido un error al crear el perfil.')
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

                console.log(this.selectedUser)
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
