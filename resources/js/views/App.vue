<template>
  <v-app id="inspire">

    <navigation-bar v-if="$store.getters.loggedIn"></navigation-bar>

    <v-content>
      <v-container fluid>
          <v-row class="fill-height">
              <v-col>
                  <transition name="fade">
                      <router-view></router-view>
                  </transition>
              </v-col>
          </v-row>
      </v-container>
    </v-content>

    <footer-layout></footer-layout>

  </v-app>

</template>

<script>
  export default {
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
    }),
    created () {
      this.$vuetify.theme.dark = true
    },

  }
</script>
