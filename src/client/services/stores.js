import axios from "axios";

/**
 * Initializes the application by fetching the store data.
 *
 * @returns {Promise<Object>} - A promise that resolves to the server response data containing the list of stores.
 *
 * @throws {Error} - If the server returns an error response, the error message will be thrown.
 */
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

/**
 * Retrieves a list of stores.
 *
 * @returns {Promise<Object>} - A promise that resolves to the server response data containing the list of stores.
 *
 * @throws {Error} - If the server returns an error response, the error message will be thrown.
 */
export async function getStoreList() {
  return await axios
    .get("/store/get_stores")
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

/**
 * Registers a new user on a specific store.
 *
 * @param {Object} user - The user object containing the necessary information.
 * @param {string} user.first_name - The first name of the user.
 * @param {string} user.last_name - The last name of the user.
 * @param {string} user.email - The email of the user.
 * @param {string} user.phone - The phone number of the user.
 * @param {string} user.birth_date - The birth date of the user.
 * @param {File} user.profile_image - The profile image of the user.
 * @param {number} user.store_id - The ID of the store where the user will be registered.
 *
 * @returns {Promise<Object>} - A promise that resolves to the server response data.
 *
 * @throws {Error} - If the server returns an error response, the error message will be thrown.
 */
export async function registerUserOnStore({
  first_name,
  last_name,
  email,
  phone,
  birth_date,
  profile_image,
  store_id,
}) {
  let data = new FormData();

  data.append("first_name", first_name);
  data.append("last_name", last_name);
  data.append("email", email);
  data.append("phone", phone);
  data.append("birth_date", birth_date);
  data.append("profile_image", profile_image);
  data.append("store_id", store_id);

  return await axios
    .post("/store/create_user", data)
    .then((response) => {
      return response.data;
    })
    .catch((error) => {
      if (error.response && error.response.data) {
        throw new Error(error.response.data);
      } else {
        console.log(error.message);
        throw new Error(error.message);
      }
    });
}

/**
 * Edits a user's information on a specific store.
 *
 * @param {string} user_id - The ID of the user to be edited on the store.
 * @param {string} first_name - The new first name of the user.
 * @param {string} last_name - The new last name of the user.
 * @param {string} email - The new email of the user.
 * @param {string} phone - The new phone number of the user.
 * @param {string} birth_date - The new birth date of the user.
 * @param {File} profile_image - The new profile image of the user.
 * @param {number} store_id - The ID of the store where the user is registered.
 *
 * @returns {Promise<Object>} - A promise that resolves to the server response data.
 *
 * @throws {Error} - If the server returns an error response, the error message will be thrown.
 */
export async function editStoreUser({
  user_id,
  first_name,
  last_name,
  email,
  phone,
  birth_date,
  profile_image,
  store_id,
}) {
  let data = new FormData();

  data.append("user_id", user_id);
  data.append("first_name", first_name);
  data.append("last_name", last_name);
  data.append("email", email);
  data.append("phone", phone);
  data.append("birth_date", birth_date);
  data.append("profile_image", profile_image);
  data.append("store_id", store_id);

  return await axios
    .post("/store/edit_user", data)
    .then((response) => {
      return response.data;
    })
    .catch((error) => {
      if (error.response && error.response.data) {
        throw new Error(error.response.data);
      } else {
        console.log(error.message);
        throw new Error(error.message);
      }
    });
}

/**
 * Deletes a user from a specific store.
 *
 * @param {string} userId - The ID of the user to be deleted from the store.
 *
 * @returns {Promise<Object>} - A promise that resolves to the server response data.
 *
 * @throws {Error} - If the server returns an error response, the error message will be thrown.
 */
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
