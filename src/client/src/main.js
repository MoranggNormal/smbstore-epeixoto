import Vue from "vue";
import App from "./App.vue";
import VueAxios from "vue-axios";
import axios from "axios";
import VueCookies from "vue-cookies";
import { createPinia, PiniaVuePlugin } from "pinia";

import { useAuth } from "./useAuth";
import { API_URL } from "../api";

Vue.use(VueAxios, axios);
Vue.use(VueCookies);

Vue.use(PiniaVuePlugin);
const pinia = createPinia();

axios.defaults.baseURL = API_URL;
axios.defaults.withCredentials = true;

Vue.config.productionTip = false;

new Vue({
  pinia,

  data() {
    return {
      store: useAuth(),
    };
  },
  created() {
    const cookie = this.$cookies.get("ci_session");

    if (cookie) {
      this.store.setSessionUser();
    }
  },
  render: (h) => h(App),
}).$mount("#app");
