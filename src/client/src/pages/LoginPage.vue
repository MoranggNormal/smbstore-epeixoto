<template>
  <main-layout>
    <div class="container">
      <h2>Bem-vindo</h2>
      <h6>Insira seus dados para continuar</h6>
      <div class="row">
        <form class="col s12" @submit.prevent="submitForm">
          <div class="row">
            <div class="input-field col s12">
              <input
                id="email"
                type="email"
                v-model="formData.email"
                class="validate"
                required
              />
              <label for="email">E-mail</label>
            </div>
            <div class="input-field col s12">
              <input
                id="password"
                type="password"
                v-model="formData.password"
                class="validate"
                required
              />
              <label for="password">Senha</label>
            </div>
            <span class="form-error-message" v-if="auth.authError.hasAuthError">
              {{ auth.authError.message }}
            </span>
            <div class="col s12">
              <button type="submit" class="btn waves-effect waves-light">
                Entrar
              </button>
            </div>

            <div class="col s12">
              <v-link
                href="/cadastro"
                class="btn register-link"
              >
                Não possui uma conta? Clique aqui para criar
              </v-link>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main-layout>
</template>

<script>
import { useAuth } from "@/useAuth";

import MainLayout from "@/layouts/MainLayout.vue";
import VLink from "@/components/VLink.vue";

export default {
  name: "LoginPage",
  components: {
    MainLayout,
    VLink
  },

  data() {
    return {
      formData: {
        email: "",
        password: "",
      },
      auth: useAuth(),
    };
  },
  methods: {
    async submitForm() {
      const logged = await this.auth.setUser(this.formData);

      if (logged) {
        this.$pushLocation();
      }
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 500px;
  margin-top: 10em;
  text-align: center;
}

.container button[type="submit"] {
  width: 100%;
}

.container .register-link{
  margin-top: 1em;
}
</style>