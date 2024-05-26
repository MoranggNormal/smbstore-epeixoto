<template>
  <main-layout>
    <div class="container">
      <div class="top-links">
        <v-link href="/novaloja" class="">Registrar nova loja</v-link>
        <v-link href="/novousuario" class="">Registrar usuario</v-link>
      </div>

      <div class="">
        Ordenar por (Lojas):
        <div class="ordered">
          <p>
            <label>
              <input
                type="radio"
                name="ordered"
                @input="orderUsersBy('storeName')"
              />
              <span>(Loja) Nome</span>
            </label>
          </p>
          <p>
            <label>
              <input
                type="radio"
                name="ordered"
                @input="orderUsersBy('storeId')"
              />
              <span>(Loja) Ordem de cadastro</span>
            </label>
          </p>
        </div>
      </div>

      <div class="">
        Ordenar por (Usuarios):
        <div class="ordered">
          <p>
            <label>
              <input
                type="radio"
                name="ordered"
                @input="orderUsersBy('userId')"
              />
              <span>(Usuarios) Ordem de cadastro</span>
            </label>
          </p>
          <p>
            <label>
              <input
                type="radio"
                name="ordered"
                @input="orderUsersBy('userName')"
              />
              <span>(Usuarios) Nome</span>
            </label>
          </p>
          <p>
            <label>
              <input
                type="radio"
                name="ordered"
                @input="orderUsersBy('userBirthdate')"
              />
              <span>(Usuarios) Data de nascimento - Crescente</span>
            </label>
          </p>
        </div>
      </div>

      <nav class="nav-extended">
        <div class="nav-content">
          <ul class="tabs">
            <li class="tab">
              <input
                v-model="search.name"
                placeholder="Buscar por nome"
                @input="withFilter"
              />
            </li>
            <li class="tab">
              <input
                v-model="search.email"
                placeholder="Buscar por email"
                @input="withFilter"
              />
            </li>
          </ul>
        </div>
      </nav>

      <nav
        class="nav-extended"
        style="background-color: white; padding-top: 1em"
      >
        <div class="nav-content row">
          <ul class="tabs col s12">
            <li class="text-black">
              <label for="startDate">
                Data minima
                <input
                  type="date"
                  id="startDate"
                  name="startDate"
                  required
                  v-model="search.startDate"
                  @input="withFilter"
                />
              </label>
            </li>
          </ul>
          <ul class="tabs col s12">
            <li class="text-black">
              <label for="endDate">
                Data maxima
                <input
                  type="date"
                  id="endDate"
                  name="endDate"
                  required
                  v-model="search.endDate"
                  @input="withFilter"
                />
              </label>
            </li>
          </ul>
        </div>
      </nav>

      <div v-if="filteredStores.length < 1">
        <h2>Não foram encontrados lojas ou usuários.</h2>
        <p>Para começar, cadastre uma loja com no mínimo um usuário.</p>
      </div>

      <div v-if="filteredStores.length > 0">
        <section
          class="store-list row"
          v-for="store in filteredStores"
          :key="store.id"
        >
          <h5>{{ store.name }} - ID:{{ store.id }}</h5>
          <article>
            <div
              class="col l5 card-panel"
              v-for="user in store.users"
              :key="user.id"
            >
              <button
                v-if="auth.user.isAdmin"
                @click="editUser(user.id)"
                class="btn-small tiny edit"
              >
                <i class="material-icons">edit</i>
              </button>

              <button
                v-if="auth.user.isAdmin"
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
                        ? SERVER_HOST + user.profile_image
                        : IMAGE_NOT_FOUND_URL
                    "
                    alt=""
                    class="responsive-img"
                    style="width: 96px; height: 96px; object-fit: cover"
                  />
                </div>
                <div class="col s9">
                  <div class="capitalize">
                    {{ user.username }} - ID:{{ user.id }}
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
import { useAuth } from "@/useAuth";
import { useStores } from "../useStores";

import MainLayout from "@/layouts/MainLayout.vue";
import VLink from "@/components/VLink.vue";

import { SERVER_HOST, IMAGE_NOT_FOUND_URL } from "../../constants";

export default {
  name: "HomePage",
  components: {
    MainLayout,
    VLink,
  },
  data() {
    return {
      store: useStores(),
      auth: useAuth(),
      search: {
        name: "",
        email: "",
        startDate: "",
        endDate: "",
      },
      filteredStores: [],
      SERVER_HOST,
      IMAGE_NOT_FOUND_URL,
    };
  },
  methods: {
    async deleteUser(userId) {
      await this.store.deleteStoreUser(userId);

      this.filteredStores = this.store.stores;
    },
    editUser(userId) {
      this.store.setUserStoreToBeEdited(userId);
      this.$pushLocation("/editarUsuario");
    },
    orderUsersBy(type) {
      switch (type) {
        case "storeName":
          this.filteredStores = this.filteredStores.sort((a, b) =>
            a.name.localeCompare(b.name)
          );
          break;
        case "storeId":
          this.filteredStores = this.filteredStores.sort((a, b) => a.id - b.id);
          break;
        case "userId":
          this.filteredStores = this.filteredStores.map((store) => {
            return {
              ...store,
              users: store.users.sort((a, b) => a.id - b.id),
            };
          });
          break;
        case "userName":
          this.filteredStores = this.filteredStores.map((store) => {
            return {
              ...store,
              users: store.users.sort((a, b) =>
                a.username.localeCompare(b.username)
              ),
            };
          });
          break;
        case "userBirthdate":
          this.filteredStores = this.filteredStores.map((store) => {
            return {
              ...store,
              users: store.users.sort(
                (a, b) => new Date(a.birth_date) - new Date(b.birth_date)
              ),
            };
          });
          break;
        default:
          break;
      }
    },
    withFilter() {
      if (
        this.search.name ||
        this.search.email ||
        this.search.startDate ||
        this.search.endDate
      ) {
        const searchName = this.search.name.toLowerCase();
        const searchEmail = this.search.email.toLowerCase();
        const searchStartDate = this.search.startDate;
        const searchEndDate = this.search.endDate;

        this.filteredStores = this.store.stores
          .map((store) => {
            if (
              store.users.some((user) =>
                user.email.toLowerCase().includes(searchEmail)
              )
            ) {
              const filteredUsers = store.users.filter((user) => {
                const nameMatch = user.username
                  .toLowerCase()
                  .includes(searchName);
                const emailMatch = user.email
                  .toLowerCase()
                  .includes(searchEmail);

                const startDateMatch = searchStartDate
                  ? new Date(user.birth_date) >= new Date(searchStartDate)
                  : true;

                const endDateMatch = searchEndDate
                  ? new Date(user.birth_date) <= new Date(searchEndDate)
                  : true;

                return (
                  nameMatch && emailMatch && startDateMatch && endDateMatch
                );
              });

              return {
                ...store,
                users: filteredUsers,
              };
            } else {
              return {
                ...store,
                users: [],
              };
            }
          })
          .filter((store) => store.users.length > 0);

        return;
      }

      this.filteredStores = this.store.stores;
    },
  },
  async created() {
    await this.store.setStores();

    this.filteredStores = this.store.stores;
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

.container .top-links {
  margin-bottom: 1em;
  display: flex;
  gap: 2em;
}

.container .store-list {
  padding: 1em 0;
}

.container .store-list .card-panel {
  margin: 1em;
  position: relative;
}

.container .store-list .card-panel > .edit {
  position: absolute;
  top: 0.5em;
  right: 5em;
}

.container .store-list .card-panel > .delete {
  position: absolute;
  top: 0.5em;
  right: 0.5em;
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

ul.tabs .tab {
  margin: 0 1em;
}

ul.tabs .tab input::placeholder {
  color: black;
}

.container .ordered {
  display: flex;
  flex-flow: row;
  gap: 1em;
}
</style>