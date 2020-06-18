<template>
    <div>
        <v-row justify="center">
            <v-dialog v-model="dialog" :dark="true" fullscreen persistent max-width="600px">

                <v-card>
                    <v-card-title>
                        <span class="headline">Editar Usuario</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>

                                <v-col cols="12">
                                    <v-text-field label="Apellido y Nombre*" required v-model="user.name"></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field label="Nombre de Usuario*" required v-model="user.username"></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field label="Email*" required v-model="user.email"></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field label="Contraseña*" required v-model="user.password"></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field label="Repita la contraseña*" required v-model="user.repeat_password"></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-select v-model="value" :items="items" attach chips label="Perfiles" multiple></v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="success" @click="closeDialog()">Cancelar</v-btn>
                        <v-btn color="warning" @click="updateUser()">Actualizar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
export default {
    props: {
        userObject: {
            type: Object,
            required: true
        }
    },
    mounted() {
        this.user = this.userObject
        this.user.password_repeat = ""
        
    },
    data: () =>  {
        return {
            user: {},
            isLoading: false,
            dialog: true
        }
    },
    methods: {
        updateUser: function() {
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

                me.message('success', 'Perfil actualizado con éxito!')

                me.getProfiles()
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
        closeDialog: function() {
            this.$emit('cancelUpdate')
        }
    }
}
</script>
