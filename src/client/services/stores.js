import axios from "axios";

export async function initialize() {
  return await axios
    .get("/store")
    .then((response) => {
      return response.data;
    })
    .catch((error) => {
      if (error.response && error.response.data) {
        throw new Error(error.response.data.message);
      } else {
        throw new Error(error.message);
      }
    });
}

export async function deleteStoreUser(userId) {
  const data = new FormData();

  data.append("userId", userId);

  return await axios
    .post("/store/delete_store_user", data)
    .then((response) => {
      return response.data;
    })
    .catch((error) => {
      if (error.response && error.response.data) {
        throw new Error(error.response.data.message);
      } else {
        throw new Error(error.message);
      }
    });
}
