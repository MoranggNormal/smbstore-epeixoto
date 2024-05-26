import { defineStore } from "pinia";

import {
  registerUserOnStore,
  deleteStoreUser,
  initialize,
} from "../services/stores";

export const useStores = defineStore("stores", {
  state: () => ({
    stores: [],
    hasFetchError: false,
  }),

  actions: {
    async setStores() {
      try {
        const response = await initialize();
        this.stores = response;

        return true;
      } catch (error) {
        this.hasFetchError = true;
      }
    },

    async registerUserOnStore(state) {
      try {
        await registerUserOnStore({ ...state });

        return true;
      } catch (error) {
        this.hasFetchError = true;
      }
    },

    async deleteStoreUser(userId) {
      try {
        await deleteStoreUser(userId);

        if (this.stores.length === 1) {
          this.stores = [];
          return true;
        }

        this.stores = this.stores.map((store) => {
          return {
            ...store,
            users: store.users.filter((user) => user.id !== userId),
          };
        });

        return true;
      } catch (error) {
        this.hasFetchError = true;
      }
    },
  },
});
