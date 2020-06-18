<template>



    <v-layout justify-center v-if="isLoading">
        <v-progress-circular indeterminate></v-progress-circular>
    </v-layout>

    <div v-else>

        <v-row>
            <v-col cols="12" md="12" sm="12">

                <v-card outlined>
                    <v-card-title v-if="update">Actualizar perfil</v-card-title>
                    <v-card-title v-else>Crear perfil</v-card-title>

                    <v-card-text>
                        <v-col cols="12" md="12" sm="12">

                            <v-text-field
                                label="ID"
                                placeholder="ID"
                                outlined
                                v-if="update"
                                v-model="selectedProfile.id"
                                readonly
                            ></v-text-field>

                            <v-text-field
                                label="Nombre del perfil"
                                placeholder="Nombre del perfil"
                                outlined
                                v-model="selectedProfile.name"
                            ></v-text-field>

                        </v-col>

                    </v-card-text>

                    <v-card-actions>
                        <v-btn color="purple" v-if="update" @click="updateProfile()">Actualizar Perfil</v-btn>
                        <v-btn color="purple" v-if="update" @click="cancelUpdate()">Cancelar</v-btn>
                        <v-btn color="purple" v-if="!update" @click="createProfile()">Crear Perfil</v-btn>
                    </v-card-actions>

                </v-card>

            </v-col>
        </v-row>

         <v-row auto-grow>
            <v-col cols="12" md="12" sm="12">
                <v-card outlined>
                    <v-toolbar flat>
                        <v-toolbar-title class="grey--text">Listado de perfiles</v-toolbar-title>

                        <v-spacer></v-spacer>

                        <v-btn icon>
                            <v-icon>mdi-magnify</v-icon>
                        </v-btn>
                        <v-text-field
                            v-model="searchFields.name"
                            v-on:change="searchProfiles()"
                        ></v-text-field>
                    </v-toolbar>
                    <v-card-title></v-card-title>
                    <v-card-text>
                            <template v-for="profile in profiles">
                                <v-row>
                                    <v-col cols="12" md="12" sm="12">
                                        <v-card raised elevation="24">
                                            <v-card-title>{{ profile.name }}</v-card-title>
                                            <v-card-text>
                                                <p><strong >Fecha de creación: {{ profile.created_at | formatDate }}</strong></p>
                                                <p><strong >Fecha de actualización: {{ profile.updated_at | formatDate }}</strong></p>
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="#dc3545" @click="askForDelete(profile)"><strong class="text-">Eliminar Perfil</strong></v-btn>
                                                <v-btn class="warning" @click="editProfile(profile)">Editar Perfil</v-btn>
                                                <v-btn class="purple" :to="'/Administration/Profile/'+profile.id+'/permissions'">Editar Permisos</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </template>
                    </v-card-text>

                    <v-pagination
                        v-model="currentPage"
                        :length="lastPage"
                    ></v-pagination>
                </v-card>
            </v-col>
        </v-row>

    </div>
</template>

<script>

    import axios from 'axios';

    export default {
        mounted () {
             this.getProfiles()
        },
        data: function() {
            return {
                isLoading: true,
                update: false,
                profiles: {},
                selectedProfile: {},
                lastPage: 1,
                currentPage: 1,
                searchFields: {
                    name: ''
                }
            }

        },
        methods: {
            getProfiles: function() {

                let me = this

                axios.get('/api/Administration/Profiles?page=' + me.currentPage, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('access_token')
                    }
                })
                .then(function(response) {

                    me.profiles = response.data.data
                    me.lastPage = response.data.lastPage;

                }).catch(function (errors) {

                    console.log(errors);

                });

                this.isLoading = false

            },
            searchProfiles: function() {
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
                }, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('access_token')
                    }
                })
                    .then(function(response) {

                        me.profiles = response.data.data
                        me.lastPage = response.data.lastPage;

                    }).catch(function (res) {

                        me.isLoading = false

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

                    });

                this.isLoading = false

            },
            editProfile: function(profile) {
                this.update = true
                this.selectedProfile = {
                    id: profile.id,
                    name: profile.name
                }
            },
            editPermissions: function(profile) {
                console.log(profile.permissions);
            },
            updateProfile: function() {
                let me = this

                me.isLoading = true

                axios.put('/api/Administration/Profiles/' + me.selectedProfile.id, {
                    name: me.selectedProfile.name,
                }, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('access_token')
                    }
                })
                .then(function() {
                    me.selectedProfile = {}

                    me.update = false

                    me.message('success', 'Perfil actualizado con éxito!')

                    me.getProfiles()
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
            cancelUpdate: function() {
                this.selectedProfile = {},
                this.update = false
            },
            createProfile: function() {
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
