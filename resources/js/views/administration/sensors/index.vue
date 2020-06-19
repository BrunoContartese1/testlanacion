<template>
    <div>
        <v-overlay :value="isLoading">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

         <v-row auto-grow>
            <v-col cols="12">
                <v-card outlined>
                    <v-toolbar flat>
                        <v-toolbar-title class="grey--text">Listado de sensores</v-toolbar-title>

                         <v-spacer></v-spacer>

                        <v-btn>
                            <v-btn color="primary" @click="newDialog = true"><v-icon>mdi-plus</v-icon></v-btn>
                        </v-btn>

                    </v-toolbar>

                        <v-card-text>
                            <template v-for="sensor in sensors" >

                                <v-row :key="sensor.id">
                                    <v-col cols="12">
                                        <v-container>
                                            <v-card raised elevation="24">
                                                <v-card-title>{{ sensor.name }}</v-card-title>
                                                <v-card-text>
                                                    <v-row>
                                                        <v-col>
                                                            <p><strong >Posición X: {{ sensor.x_pos }}</strong></p>
                                                            <p><strong >Posición Y: {{ sensor.y_pos }}</strong></p>
                                                        </v-col>
                                                    </v-row>
                                                </v-card-text>

                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn color="#dc3545" @click="askForDelete(sensor)"><strong class="text-">Eliminar Sensor</strong></v-btn>
                                                    <v-btn class="warning" @click="editSensor(sensor)">Editar Sensor</v-btn>
                                                </v-card-actions>

                                            </v-card>
                                        </v-container>
                                    </v-col>
                                </v-row>

                            </template>
                        </v-card-text>

                        <v-pagination v-model="currentPage" :length="lastPage"></v-pagination>

                        <new-sensor-dialog v-if="newDialog" v-on:close-dialog="newDialog = false" @create-sensor="createSensor"></new-sensor-dialog>

                        <edit-sensor-dialog v-if="updateDialog" v-on:close-dialog="updateDialog = false" @update-sensor="updateSensor" :selectedSensor="selectedSensor"></edit-sensor-dialog>

                </v-card>
            </v-col>
        </v-row>

    </div>
</template>

<script>
export default {
    mounted() {
        this.getSensors()
    },
    data: function() {
            return {
                isLoading: true,
                newDialog: false,
                updateDialog: false,
                sensors: {},
                selectedSensor: {},
                lastPage: 1,
                currentPage: 1
            }

        },
    methods: {
        getSensors: function() {
            let me = this

            axios.get('/api/Administration/sensors?page=' + me.currentPage, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem('access_token')
                }
            })
            .then(function(response) {

                me.sensors = response.data.data
                me.lastPage = response.data.last_page;

                if(me.currentPage > me.lastPage) {
                    me.currentPage = me.lastPage
                }

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
        },
        message: function(className, message) {
            Vue.toasted.show(message, {
                className: className,
                position: 'top-right',
                duration: 5000
            })
        },
        askForDelete: function(sensor) {
            let me = this

            let options = {
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'zoom',
                clicksCount: 2
            }

            this.$dialog
                .confirm('¿Está seguro de que desea eliminar el sensor?', options)
                .then(function(dialog) {
                    me.deleteSensor(sensor.id)
                })
                .catch(function() {
                    console.log("No confirmado")
                })
        },
        deleteSensor: function(sensorId) {
            let me = this

            me.isLoading = true

            axios.delete('/api/Administration/sensors/' + sensorId, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem('access_token')
                }
            })
            .then(function() {

                me.getSensors()

                me.message('success', 'Sensor eliminado con éxito!')

            }).catch(function(res) {

                me.isLoading = false

                switch(res.response.status) {
                    case 422:
                        me.$handleErrors(res.response.data.errors)
                        break
                    case 404:
                        me.message('error', 'Oops! Ha ocurrido un error al crear el sensor.')
                        break
                    case 401:
                        me.message('error', 'Usted no está autorizado a eliminar sensores.')
                        break
                    default:
                        me.message('error', 'Oops! Ha ocurrido un error al crear el sensor.')
                        break
                }

            });
        },
        createSensor: function(sensor) {
            let me = this
            this.isLoading = true

            axios.post('/api/Administration/sensors', {
                name: sensor.name,
                x_pos: sensor.x_pos,
                y_pos: sensor.y_pos
            } ,{
                headers: {
                    Authorization: "Bearer " + localStorage.getItem('access_token')
                }
            })
            .then(function(response) {

                me.message('success', 'Sensor creado con éxito')

                me.getSensors()

                me.newDialog = false

            }).catch(function (res) {

                switch(res.response.status) {
                    case 422:
                        me.$handleErrors(res.response.data.errors)
                        break
                    case 404:
                        me.message('error', 'Oops! Ha ocurrido un error de sistema. (404)')
                        break
                    case 401:
                        me.message('error', 'Usted no está autorizado a crear sensores.')
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
        editSensor: function(sensor) {
            this.selectedSensor = sensor

            this.updateDialog = true
        },
        updateSensor: function(sensor) {

            let me = this
            this.isLoading = true

            axios.put('/api/Administration/sensors/' + sensor.id, {
                name: sensor.name,
                x_pos: sensor.x_pos,
                y_pos: sensor.y_pos
            } ,{
                headers: {
                    Authorization: "Bearer " + localStorage.getItem('access_token')
                }
            })
            .then(function(response) {

                me.message('success', 'Sensor actualizado con éxito')

                me.getSensors()

                me.updateDialog = false

            }).catch(function (res) {

                switch(res.response.status) {
                    case 422:
                        me.$handleErrors(res.response.data.errors)
                        break
                    case 404:
                        me.message('error', 'Oops! Ha ocurrido un error de sistema. (404)')
                        break
                    case 401:
                        me.message('error', 'Usted no está autorizado a actualizar sensores.')
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
        currentPage: function(val) {
            this.isLoading = true
            this.getSensors()
        }
    }
}
</script>
