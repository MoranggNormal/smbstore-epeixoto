<template>
  <div class="">
    <nav class="bg-primary z-depth-0">
      <div class="container nav-wrapper">
        <v-link href="/" class="brand-logo hide-on-med-and-down nav-item"
          >SMB Store - Euller Peixoto
        </v-link>
        <ul class="right hide-on-med">
          <li class="nav-item">
            <v-link href="/">Inicio</v-link>
          </li>
          <li class="nav-item" v-if="!auth.authenticated">
            <v-link href="/login">Login</v-link>
          </li>
          <li class="nav-item" v-if="!auth.authenticated">
            <v-link href="/cadastro">Cadastro</v-link>
          </li>

          <li v-if="auth.authenticated">
            <v-link href="/conta">
              <div class="valign-wrapper">
                <img
                  :src="['http://localhost/' + auth.user.profile_image]"
                  alt=""
                  class="profile-pic circle responsive-img hide-on-med-and-down"
                />
                <span>{{ auth.user.username }}</span>
              </div>
            </v-link>
          </li>

          <li v-if="auth.authenticated" class="nav-item">
            <button @click="logout" class="btn waves-effect waves-light">
              Sair
            </button>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
import { useAuth } from "../useAuth";
import VLink from "@/components/VLink.vue";

export default {
  name: "AppHeader",
  components: {
    VLink,
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
    logout() {
      const has_logged_out = this.auth.logout();

      if (has_logged_out) {
        this.$pushLocation();
      }
    },
  },
};
</script>

<style scoped>
.profile-pic {
  width: 32px;
  height: 32px;
  margin-right: 10px;
  object-fit: cover;
}

.nav-item {
  color: white;
  font-weight: 700;
  font-family: monospace;
  margin: 0 1em;
}

.nav-item:hover {
  opacity: 0.8;
}
</style>
