<template>
    <div>
        <v-row justify="center">
            <v-dialog v-model="dialog" :dark="true" persistent max-width="600px" @keydown.esc="closeDialog()">

                <v-card>
                    <v-card-title>
                        <span class="headline">Nuevo Usuario</span>
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
                                    <v-text-field @click:append="showPassword = !showPassword" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" hint="Al menos 8 caracteres" counter label="Contraseña*" required v-model="user.password"></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field @click:append="showPassword = !showPassword" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" hint="Al menos 8 caracteres" counter label="Repita la contraseña*" required v-model="user.repeat_password"></v-text-field>
                                </v-col>



                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="success" @click="closeDialog()">Cancelar</v-btn>
                        <v-btn color="warning" @click="storeUser()">Crear</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
export default {
    data: () =>  {
        return {
            user: {
                name: "",
                username: "",
                email: "",
                password: "",
                repeat_password: ""
            },
            dialog: true,
            showPassword: false
        }
    },
    methods: {
        closeDialog: function() {
            this.$emit('closeDialog')
        },
        storeUser: function() {
            this.$emit('store-user', this.user)
        }
    }
}
</script>
