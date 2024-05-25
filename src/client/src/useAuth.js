import { defineStore } from "pinia";

import { login, getSessionUserData } from "../services/auth";

export const useAuth = defineStore("auth", {
  state: () => ({
    user: {},
    authenticated: false,
    authError: {
      hasAuthError: false,
      message: "",
    },
  }),

  actions: {
    async setUser(state) {
      try {
        const response = await login(state.email, state.password);
        console.log(response);
        this.user = response;
        this.authenticated = true;
      } catch (error) {
        this.authenticated = false;
        this.authError = {
          hasAuthError: true,
          message: error.message,
        };
      }
    },

    setSessionUser: async function () {
      try {
        const response = await getSessionUserData();
        this.user = response.userData;
        this.authenticated = true;
      } catch (error) {
        this.authenticated = false;
      }
    },

    getUser() {
      return this.user;
    },

    isAuthenticated() {
      return this.authenticated;
    },

    getAuthError() {
      return this.authError;
    },
  },
});
