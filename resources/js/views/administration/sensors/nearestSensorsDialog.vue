<template>
    <div>
        <v-overlay :value="isLoading">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

        <v-row justify="center">
            <v-dialog v-model="dialog" :dark="true" persistent max-width="600px" @keydown.esc="closeDialog()">

                <v-card>
                    <v-card-title>
                        <span class="headline">Sensores más cercanos</span>
                        <v-spacer></v-spacer>
                        <v-radio-group v-model="limitQuantity">
                            <v-radio
                                key="5"
                                label="Mostrar 5 registros"
                                value="5"
                            ></v-radio>
                            <v-radio
                                key="10"
                                label="Mostrar 10 registros"
                                value="10"
                            ></v-radio>
                        </v-radio-group>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            
                                
                            <v-row no-gutters>
                                    
                                <v-card v-for="sensor in nearestSensors" :key="sensor.id" class="ma-3" raised elevation="24">

                                    <v-card-title> {{ sensor.name }} </v-card-title>

                                    <v-card-text>
                                        
                                            <v-col>
                                                <p><strong >Ubicación (X, Y): ({{ sensor.x_pos }}, {{ sensor.y_pos }})</strong></p>
                                                <p><strong >Distancia (Unidades): {{ sensor.distance | round }}</strong></p>
                                            </v-col>
                                        
                                    </v-card-text>

                                </v-card>
                                        
                            </v-row>
                                    
                                
                            
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn @click="closeDialog" color="primary">Cerrar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
    export default {
        props: ['selectedSensor'],
        mounted() {
            this.getNearestSensors()
        },
        data: function() {
            return {
                dialog: true,
                limitQuantity: "5",
                isLoading: true,
                nearestSensors: {}
            }
        },
        methods: {
            closeDialog: function() {
                this.$emit("close-dialog");
            },
            getNearestSensors: function() {
                let me = this

                let url = '/api/Administration/sensors/' + me.selectedSensor.id + '/nearestSensors/' + me.limitQuantity;

                axios.get(url , {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('access_token')
                    }
                })
                .then(function(response) {

                    me.nearestSensors = response.data

                }).catch(function (res) {

                    switch(res.response.status) {
                        case 422:
                            me.$handleErrors(res.response.data.errors)
                            break
                        case 404:
                            me.message('error', 'Oops! Ha ocurrido un error de sistema. (404)')
                            break
                        case 401:
                            me.message('error', 'Usted no está autorizado a ver los sensores.')
                            break
                        default:
                            me.message('error', 'Oops! Ha ocurrido un error de sistema. (' + res.response.status + ')')
                            break
                    }

                })
                .finally(function() {

                    me.isLoading = false

                });
            }
        },
        watch: {
            limitQuantity: function(newVal) {
                this.isLoading = true

                this.getNearestSensors()
            }
        }
    }
</script>
