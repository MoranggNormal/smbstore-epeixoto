import axios from "axios";
const FormData = require("form-data");

/**
 * Logs the user into the system using the provided email and password.
 *
 * @param {string} email - The user's email address.
 * @param {string} password - The user's password.
 *
 * @returns {Promise<Object>} - A promise that resolves to the user's data upon successful login.
 * @throws {Error} - If the login request fails, an error with the appropriate message is thrown.
 */
export async function login(email, password) {
  let data = new FormData();

  data.append("email", email);
  data.append("password", password);

  return await axios
    .post("/auth", data)
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
 * Retrieves the user data associated with the current session.
 *
 * @returns {Promise<Object>} - A promise that resolves to the user's data upon successful request.
 * @throws {Error} - If the request fails, an error with the appropriate message is thrown.
 */
export function getSessionUserData() {
  return axios
    .get("/auth/checkSession")
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
 * Logs the user out of the system.
 *
 * @returns {Promise<Object>} - A promise that resolves to the user's data upon successful logout.
 * @throws {Error} - If the logout request fails, an error with the appropriate message is thrown.
 */
export function logout() {
  return axios
    .get("/auth/logout")
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
