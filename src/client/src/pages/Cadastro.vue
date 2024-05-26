<template>
  <main-layout>
    <div class="container">
      <h2>Cadastro de Usuário</h2>
      <form @submit.prevent="submitForm">
        <div class="row">
          <div class="input-field col s6">
            <input
              v-model="formData.first_name"
              type="text"
              id="first_name"
              required
            />
            <label for="first_name">Nome</label>
          </div>
          <div class="input-field col s6">
            <input
              v-model="formData.last_name"
              type="text"
              id="last_name"
              required
            />
            <label for="last_name">Sobrenome</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s8">
            <input v-model="formData.email" type="email" id="email" required />
            <label for="email">Email</label>
          </div>
          <div class="input-field col s4">
            <the-mask
              :mask="['(##) ####-####', '(##) #####-####']"
              v-model="formData.phone"
              id="phone"
              required
            />
            <label for="phone">Telefone</label>
          </div>
        </div>

        <div class="row">
          <div
            :class="['input-field', formData.birth_date ? 'col s8' : 'col s12']"
          >
            <input
              type="date"
              id="birth_date"
              name="birth_date"
              required
              v-model="formData.birth_date"
              @change="calculateAge"
            />
            <label for="birth_date">Data de Nascimento</label>
          </div>

          <div class="current-age col s4" v-if="formData.birth_date">
            <span class="">{{ formData.current_age }} anos</span>
          </div>
        </div>

        <div class="row">
          <div class="file-field input-field col s12">
            <div class="btn">
              <span>Upload</span>
              <input type="file" @change="setFile" required/>
            </div>
            <div class="file-path-wrapper">
              <input
                class="file-path validate"
                type="text"
                placeholder="Upload de imagem"
                required
              />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s6">
            <input
              v-model="formData.password"
              type="password"
              id="password"
              required
            />
            <label for="password">Senha</label>
          </div>
          <div class="input-field col s6">
            <input
              v-model="formData.passconf"
              type="password"
              id="passconf"
              required
            />
            <label for="passconf">Confirme sua senha</label>
          </div>
        </div>

        <span class="form-error-message" v-if="auth.authError.hasAuthError">
          <pre>{{ stripHtml(auth.authError.message) }}</pre>
        </span>

        <div class="row">
          <button
            class="register-btn btn waves-effect waves-light col s12"
            type="submit"
          >
            Cadastrar
          </button>
        </div>
      </form>
    </div>
  </main-layout>
</template>
  
  <script>
import { useAuth } from "@/useAuth";

import MainLayout from "@/layouts/MainLayout.vue";
import { TheMask } from "vue-the-mask";

export default {
  name: "RegisterPage",
  components: {
    MainLayout,
    TheMask,
  },
  data() {
    return {
      formData: {
        email: "",
        password: "",
        passconf: "",
        first_name: "",
        last_name: "",
        phone: "",
        birth_date: "",
        current_age: "",
        profile_image: null,
      },
      auth: useAuth(),
    };
  },
  methods: {
    async submitForm() {
      const created = await this.auth.registerUser(this.formData);

      if (created) {
        this.$pushLocation();
      }
    },
    calculateAge() {
      const birthDate = new Date(this.formData.birth_date);
      const diff = Date.now() - birthDate.getTime();
      const age = new Date(diff).getUTCFullYear() - 1970;

      this.formData.current_age = age;
    },
    setFile(event) {
      this.formData.profile_image = event.target.files[0];
    },
    stripHtml(html) {
      let tmp = document.createElement("div");
      tmp.innerHTML = html;
      return tmp.textContent || tmp.innerText || "";
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 500px;
  margin-top: 10em;
}

.current-age {
  display: grid;
  align-items: center;
  justify-items: center;
}

.current-age span {
  margin-top: 2.4rem;
  font-size: 1.3rem;
}

.register-btn {
  width: 100%;
}
</style>