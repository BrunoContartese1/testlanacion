<template>
    <div>
        <v-app-bar app clipped-left>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Test La Nación</v-toolbar-title>
        </v-app-bar>

        <v-navigation-drawer v-model="drawer" app clipped>

            <v-list dense dark>

                <v-list-item v-for="item in items" :key="item.title" link :to="item.to">
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>

                </v-list-item>

                <v-list-group  color="blue darken-1">

                    <template v-slot:activator>
                        <v-list-item-icon>
                            <v-icon>mdi-cog</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Administración</v-list-item-title>
                        </v-list-item-content>

                    </template>

                    <v-list-item sub-group v-for="(item, i) in administration" :key="i" link :to="item.to">

                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-title>{{ item.title }}</v-list-item-title>

                    </v-list-item>

                </v-list-group>

            </v-list>



            <template v-slot:append>
                <div class="pa-2">
                    <v-btn block to='/logout'>Cerrar sesión</v-btn>
                </div>
            </template>

        </v-navigation-drawer>
    </div>



</template>
<script>
export default {
    data: () => ({
        items: [
          { title: 'Principal', icon: 'mdi-view-dashboard', to:"/" },
          { title: 'Sensores', icon: 'mdi-google-maps', to:"/Administration/Sensors" },
      ],
      administration: [
          { title: 'Usuarios', icon: 'mdi-badge-account', to:"/administration/users" },
          { title: 'Perfiles', icon: 'mdi-lock', to:"/Administration/Profiles" },
      ],
      drawer: null
    })
}
</script>
