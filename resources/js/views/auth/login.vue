<template>


  <div>

    <div class="container">
      <div class="column is-4 is-offset-4">
        <div class="box">
          <h1 class="title">Iniciar Sesión</h1>
          <div class="notification is-danger" v-if="error">
            <p>{{error}}</p>
          </div>

            <div class="field">
              <div class="control">
                <input type="text" class="input" placeholder="Nombre de usuario" v-model="username" @keydown.enter="login" required/>
              </div>
            </div>
            <div class="field">
              <div class="control">
                <input type="password" placeholder="Contraseña" class="input" v-model="password" @keydown.enter="login" required/>
              </div>
            </div>

            <v-btn
                color = "purple"
                :loading = "isLoading"
                block
                @click = "login"

            >
            Iniciar sesión
            </v-btn>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: null,
      password: null,
      error: null,
      isLoading: false,
    };
  },
  methods: {
    login() {
        this.isLoading = true;
        let me = this;
        this.$store
            .dispatch("retrieveToken", {
                username: this.username,
                password: this.password
            })
            .then(response => {
                this.$router.push({ name: "Home" });
            })
            .catch(error => {
                me = this
                if(error.response.status == 422) {
                    me.$handleErrors(error.response.data.errors)
                } else {
                    this.error = error.response.data;
                }

            })
            .finally(() => {
                me.isLoading = false;
            })
    }
  }
};
</script>
