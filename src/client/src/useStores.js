import { defineStore } from "pinia";

import {
  registerUserOnStore,
  deleteStoreUser,
  initialize,
  editStoreUser,
} from "../services/stores";

export const useStores = defineStore("stores", {
  state: () => ({
    stores: [],
    userStoreToBeEdited: null,
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

    async setUserStoreToBeEdited(userId) {
      if (userId) {
        this.userStoreToBeEdited = userId;
      }
    },

    async editStoreUser(state) {
      try {
        await editStoreUser({ ...state });

        this.userStoreToBeEdited = null;
        return true;
      } catch (error) {
        this.hasFetchError = true;
      }
    },

    async deleteStoreUser(userId) {
      try {
        await deleteStoreUser(userId);

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

    getStoreUserDataById(userId) {
      const userData = this.stores.filter((store) => {
        return store.users.find((user) => user.id == userId);
      });

      if (userData.length > 0) {
        return {
          storeId: userData[0].id,
          userData: userData[0].users[0],
        };
      }
    },
  },
});
