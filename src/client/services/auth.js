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

export async function register({
  first_name,
  last_name,
  email,
  phone,
  birth_date,
  password,
  passconf,
  profile_image,
}) {
  let data = new FormData();

  data.append("first_name", first_name);
  data.append("last_name", last_name);
  data.append("email", email);
  data.append("phone", phone);
  data.append("birth_date", birth_date);
  data.append("password", password);
  data.append("passconf", passconf);
  data.append("profile_image", profile_image);

  return await axios
    .post("/user/register", data)
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
