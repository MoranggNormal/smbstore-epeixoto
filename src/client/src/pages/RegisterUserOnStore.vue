<template>
  <main-layout>
    <div class="container">
      <h2>Cadastro de Usuário</h2>
      <form v-if="this.storeList.length > 0" @submit.prevent="submitForm">
        <div class="row">
          <div class="input-field col s12">
            <select style="display: block" v-model="formData.store_id" required>
              <option value="" disabled selected>Selecione uma loja</option>
              <option
                v-for="store in this.storeList"
                :key="store.id"
                :value="store.id"
              >
                {{ store.name }}
              </option>
            </select>
          </div>
        </div>

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
              <input type="file" @change="setFile" accept="image/*" required />
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
import { useStores } from "@/useStores";

import MainLayout from "@/layouts/MainLayout.vue";
import { TheMask } from "vue-the-mask";

import { getStoreList } from "../../services/stores";

export default {
  name: "RegisterUserOnStore",
  components: {
    MainLayout,
    TheMask,
  },
  data() {
    return {
      formData: {
        first_name: "",
        last_name: "",
        email: "",
        phone: "",
        birth_date: "",
        profile_image: null,
        current_age: "",
        store_id: "",
      },
      storeList: [],
      auth: useAuth(),
      store: useStores(),
    };
  },
  methods: {
    async submitForm() {
      console.log(this.formData);
      const created = await this.store.registerUserOnStore(this.formData);

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
  async mounted() {
    const data = await getStoreList();
    this.storeList = data;
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