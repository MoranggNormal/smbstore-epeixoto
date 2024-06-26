import { defineStore } from "pinia";

import { login, getSessionUserData, register, logout } from "../services/auth";

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
        this.user = response;
        this.authenticated = true;

        return true;
      } catch (error) {
        this.authenticated = false;
        this.authError = {
          hasAuthError: true,
          message: error.message,
        };
      }
    },

    async registerUser(state) {
      try {
        const response = await register({ ...state });

        this.user = response;
        this.authenticated = true;

        return true;
      } catch (error) {
        this.authenticated = false;
        this.authError = {
          hasAuthError: true,
          message: error.message,
        };
      }
    },

    async setSessionUser() {
      try {
        const response = await getSessionUserData();
        this.user = response.userData;
        this.authenticated = true;
      } catch (error) {
        this.authenticated = false;
      }
    },

    async logout() {
      try {
        await logout();

        this.user = {};
        this.authenticated = false;
        return true;
      } catch (error) {
        this.authenticated = false;
        this.authError = {
          hasAuthError: true,
          message: error.message,
        };
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
