<template>
  <main-layout>
    <div class="container">
      <h2>Registrar nova loja</h2>
      <form @submit.prevent="submitForm">
        <div class="row">
          <div class="input-field col s12">
            <input
              v-model="formData.store_name"
              type="text"
              id="store_name"
              required
            />
            <label for="store_name">Nome da loja</label>
          </div>
        </div>

        <span class="form-error-message" v-if="store.hasFetchError">
          Algum problema aconteceu!
        </span>

        <div class="row">
          <button
            class="register-btn btn waves-effect waves-light col s12"
            type="submit"
          >
            Criar
          </button>
        </div>
      </form>
    </div>
  </main-layout>
</template>
  
  <script>
import MainLayout from "@/layouts/MainLayout.vue";
import { useStores } from "../useStores";

export default {
  name: "RegisterStore",
  components: {
    MainLayout,
  },
  data() {
    return {
      formData: {
        store_name: null,
      },
      store: useStores(),
    };
  },
  methods: {
    async submitForm() {
      const edited = await this.store.registerStore(this.formData);

      if (edited) {
        this.$pushLocation();
      }
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

.register-btn {
  width: 100%;
}
</style>