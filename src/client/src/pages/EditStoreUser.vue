<template>
  <main-layout>
    <div v-if="this.userNotFound" style="width: 100vw">
      <h2 style="text-align: center">Usuário não encontrado</h2>
    </div>
    <div class="container" v-if="this.userData">
      <h2>Editando usuário {{ this.userData.username }}</h2>

      <form v-if="this.storeList.length > 0" @submit.prevent="submitForm">
        <div class="row">
          <div class="input-field col s12">
            <select style="display: block" v-model="formData.store_id">
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
            <input v-model="formData.first_name" type="text" id="first_name" />
            <label class="active" for="first_name">Nome</label>
          </div>
          <div class="input-field col s6">
            <input v-model="formData.last_name" type="text" id="last_name" />
            <label class="active" for="last_name">Sobrenome</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s8">
            <input v-model="formData.email" type="email" id="email" />
            <label class="active" for="email">Email</label>
          </div>
          <div class="input-field col s4">
            <the-mask
              :mask="['(##) ####-####', '(##) #####-####']"
              v-model="formData.phone"
              id="phone"
            />
            <label class="active" for="phone">Telefone</label>
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
              v-model="formData.birth_date"
              @change="calculateAge"
            />
            <label class="active" for="birth_date">Data de Nascimento</label>
          </div>

          <div class="current-age col s4" v-if="formData.birth_date">
            <span class="">{{ formData.current_age }} anos</span>
          </div>
        </div>

        <div class="row">
          <div class="file-field input-field col s12">
            <div class="btn">
              <span>Upload</span>
              <input type="file" @change="setFile" accept="image/*" />
            </div>
            <div class="file-path-wrapper">
              <input
                class="file-path validate"
                type="text"
                placeholder="Upload de imagem"
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
            Salvar
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
  name: "EditStoreUser",
  components: {
    MainLayout,
    TheMask,
  },
  data() {
    return {
      formData: {
        user_id: "",
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
      userData: null,
      userNotFound: null,
    };
  },
  methods: {
    async submitForm() {
      const edited = await this.store.editStoreUser(this.formData);

      if (edited) {
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
    if (this.store.stores.length < 1) {
      await this.store.setStores();
    }

    const userId = this.store.userStoreToBeEdited;

    const data = this.store.getStoreUserDataById(userId);

    if (!data) {
      this.userNotFound = true;
      return;
    }

    const storeList = await getStoreList();

    this.storeList = storeList;
    this.userData = data.userData;

    this.formData = {
      user_id: data.userData.id,
      first_name: data.userData.first_name,
      last_name: data.userData.last_name,
      email: data.userData.email,
      phone: data.userData.phone,
      store_id: data.storeId,
    };
  },
};
</script>
  
  <style scoped>
.container {
  max-width: 500px;
  margin-top: 5em;
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