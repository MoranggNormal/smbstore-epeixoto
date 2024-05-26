<template>
  <main-layout>
    <div class="container">
      <nav class="nav-extended bg-primary-light">
        <div class="nav-content">
          <ul class="tabs tabs-transparent">
            <li class="tab"><a href="#test1">Test 1</a></li>
            <li class="tab"><a class="active" href="#test2">Test 2</a></li>
            <li class="tab"><a href="#test4">Test 4</a></li>
          </ul>
        </div>
      </nav>

      <div v-if="store.stores.length > 0">
        <section
          class="store-list row"
          v-for="store in store.stores"
          :key="store.id"
        >
          <h5>
            {{ store.name }}
          </h5>
          <article>
            <div
              class="col s5 card-panel"
              v-for="user in store.users"
              :key="user.id"
            >
              <button class="btn-small tiny edit">
                <i class="material-icons">edit</i>
              </button>
              <button
                class="btn-small tiny delete"
                @click="deleteUser(user.id)"
              >
                <i class="material-icons">delete</i>
              </button>

              <div class="row valign-wrapper">
                <div class="col s3">
                  <img
                    :src="
                      user.profile_image
                        ? 'http://localhost/' + user.profile_image
                        : 'https://placehold.co/96x96?text=Imagem+não+encontrada'
                    "
                    alt=""
                    class="responsive-img"
                    style="width: 96px; height: 96px; object-fit: cover"
                  />
                </div>
                <div class="col s9">
                  <div class="capitalize">
                    {{ user.username }}
                  </div>
                  <div>
                    Tel.:
                    {{ user.phone }}
                  </div>
                  <div>
                    E-mail:
                    {{ user.email }}
                  </div>
                  <div>Data de nascimento: {{ user.birth_date }}</div>
                </div>
              </div>
            </div>
          </article>
        </section>
      </div>
    </div>
  </main-layout>
</template>

<script>
import { useStores } from "../useStores";

import MainLayout from "@/layouts/MainLayout.vue";

export default {
  name: "HomePage",
  components: {
    MainLayout,
  },
  data() {
    return {
      store: useStores(),
      currentRoute: window.location.pathname,
    };
  },
  methods: {
    deleteUser(userId) {
      this.store.deleteStoreUser(userId);
    },
  },
  created() {
    this.store.setStores();
  },
};
</script>

<style scoped>
.container {
  margin-top: 3em;
  display: flex;
  flex-flow: column;
  justify-content: center;
}

.container .store-list {
  padding: 1em 0;
}

.container .store-list .card-panel {
  margin: 0 1em;
  position: relative;
}

.container .store-list .card-panel > .edit {
  position: absolute;
  top: 0%;
  right: 4em;
}

.container .store-list .card-panel > .delete {
  position: absolute;
  top: 0;
  right: 0;
}

.container .store-list .card-panel > .valign-wrapper {
  margin: 0;
  padding: 0.5em 0.5em;
}

.container .store-list .card-panel img {
  border-radius: 2%;
}

.container h5 {
  text-align: left;
  text-transform: uppercase;
  width: 100%;
  margin-left: 2em;
}
</style>