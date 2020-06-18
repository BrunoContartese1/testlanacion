<template>

    <v-layout justify-center v-if="isLoading">
        <v-progress-circular indeterminate></v-progress-circular>
    </v-layout>

    <div v-else>

        <v-row auto-grow>
            <v-col cols="12" md="12" sm="12">
                <v-card outlined>

                    <v-card-title>Permisos del perfil: {{ profile.name }}</v-card-title>

                    <v-card-text>

                        <template v-for="group in permissionsGroups">

                            <v-card raised elevation="24">

                                <v-card-title>Módulo: {{ group.name }}</v-card-title>

                                <v-card-text>

                                    <template v-for="permission in group.permissions">

                                            <v-row class="light--text">

                                                <v-col>

                                                    <v-checkbox v-model="profilePermissions" :label="permission.show_name" :value="permission.name"></v-checkbox>

                                                </v-col>

                                            </v-row>

                                    </template>

                                </v-card-text>

                            </v-card>

                        </template>

                    </v-card-text>

                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    mounted() {
        let me = this

        this.getAllPermissions()

        this.getProfile()

    },
    data: function() {
            return {
                isLoading: true,
                permissionsGroups: {},
                profile: {},
                profilePermissions: {},
                profileLoaded: false
            }
        },
    methods: {
        getProfile() {
            let me = this
            me.isLoading = true
            axios.get('/api/Administration/Profiles/' + me.$route.params.id, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem('access_token')
                }
            })
            .then(function(response) {

                me.profile = response.data.data
                me.profilePermissions = me.profile.permissions


            }).catch(function (errors) {

                console.log(errors);

            })
            .finally(function() {
                me.isLoading = false
                me.dataLoaded = true
            });
        },

        getAllPermissions() {
            let me = this

            axios.get('/api/Administration/profiles/permissionGroups', {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem('access_token')
                }
            })
            .then(function(response) {

                me.permissionsGroups = response.data.data


            }).catch(function (errors) {

                switch(res.response.status) {
                    case 422:
                        me.$handleErrors(res.response.data.errors)
                        break
                    case 404:
                        me.message('error', 'Oops! Ha ocurrido un error al actualizar los permisos.')
                        break
                    case 401:
                        me.message('error', 'Usted no está autorizado a actualizar los permisos.')
                        break
                    default:
                        me.message('error', 'Oops! Ha ocurrido un error al actualizar los permisos.')
                        break
                }

            })
            .finally(function() {
                me.isLoading = false
            });
        },
        updatePermissions() {
            let me = this

            axios.post('/api/Administration/profiles/' + me.$route.params.id + '/updatePermissions', {
                permissions: me.profilePermissions
            },
            {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem('access_token')
                }
            })
            .then(function(response) {

                me.message('success', 'Permisos actualizados con éxito.')


            }).catch(function (res) {

                switch(res.response.status) {
                    case 422:
                        me.$handleErrors(res.response.data.errors)
                        break
                    case 404:
                        me.message('error', 'Oops! Ha ocurrido un error al actualizar los permisos.')
                        break
                    case 401:
                        me.message('error', 'Usted no está autorizado a actualizar los permisos.')
                        break
                    default:
                        me.message('error', 'Oops! Ha ocurrido un error al actualizar los permisos.')
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
        profilePermissions: {
            deep: true,
            handler: function() {
                if(this.dataLoaded) {
                    this.updatePermissions()
                }
                
            }
        }
    }

}
</script>
