import { defineStore } from "pinia";

import { deleteStoreUser, initialize } from "../services/stores";

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

    async deleteStoreUser(userId) {
      try {
        await deleteStoreUser(userId);

        this.stores = this.stores.map((store) => {
          return store.users.filter((id) => id != userId);
        });

        return true;
      } catch (error) {
        this.hasFetchError = true;
      }
    },
  },
});
