<template>
    <div>
        <v-row justify="center">
            <v-dialog v-model="dialog" :dark="true" persistent max-width="600px" @keydown.esc="closeDialog()">

                <v-card>
                    <v-card-title>
                        <span class="headline">Nuevo sensor</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>

                                <v-col cols="12">
                                    <v-text-field label="Nombre del sensor *" v-model="sensor.name"></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field label="Posición X ( Unidades ) *" required v-model="sensor.x_pos"></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field label="Posición Y ( Unidades ) *" required v-model="sensor.y_pos"></v-text-field>
                                </v-col>

                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="success" @click="closeDialog()">Cancelar</v-btn>
                        <v-btn color="warning" @click="createSensor()">Crear</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                dialog: true,
                sensor: {
                    name: "Sensor NN",
                    x_pos: "",
                    y_pos: ""
                },
            }
        },
        methods: {
            closeDialog: function() {
                this.$emit("close-dialog");
            },
            createSensor: function() {
                this.$emit('create-sensor', this.sensor)
            }
        }
    }
</script>
