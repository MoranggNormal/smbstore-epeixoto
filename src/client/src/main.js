import Vue from "vue";
import App from "./App.vue";
import VueAxios from "vue-axios";
import axios from "axios";

import 'materialize-css/dist/css/materialize.min.css';
import 'materialize-css/dist/js/materialize.min.js';

import { API_URL } from "../api";

Vue.config.productionTip = false;
Vue.use(VueAxios, axios);

axios.defaults.baseURL = API_URL;

new Vue({
  render: (h) => h(App),
}).$mount("#app");
