import Vue from "vue";
import VueAxios from "vue-axios";
import axios from "axios";
import VueCookies from "vue-cookies";
import { createPinia, PiniaVuePlugin } from "pinia";

import { useAuth } from "./useAuth";
import { API_URL } from "../api";

import routes from "./route";

axios.defaults.baseURL = API_URL;
axios.defaults.withCredentials = true;

Vue.use(VueAxios, axios);
Vue.use(VueCookies);
Vue.use(PiniaVuePlugin);

Vue.config.productionTip = false;

Vue.prototype.$pushLocation = function (location = "/") {
  const cookie = this.$cookies.get("ci_session");

  if (cookie) {
    this.$root.currentRoute = location;
    window.history.pushState(null, "", location);
  }
};

const pinia = createPinia();

const app = new Vue({
  pinia,
  el: "#app",
  data() {
    return {
      store: useAuth(),
      currentRoute: window.location.pathname,
    };
  },
  computed: {
    ViewComponent() {
      const matchingView = routes[this.currentRoute];
      if (matchingView) {
        return () => import(`./pages/${matchingView}.vue`);
      } else {
        return () => import("./pages/NotFoundPage.vue");
      }
    },
  },
  created() {
    const cookie = this.$cookies.get("ci_session");

    if (cookie) {
      this.store.setSessionUser();
    }
  },
  render(h) {
    return h(this.ViewComponent);
  },
});

window.addEventListener("popstate", () => {
  app.currentRoute = window.location.pathname;
});
