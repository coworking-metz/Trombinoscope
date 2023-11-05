// apiMixin.js
import { ref } from "vue";

/**
 * API hooks
 * @return {Object} The API hooks
 */
export function useApi() {
  const isLoading = ref(false);

  /**
   * Makes a POST request to the specified URI
   * @param {string} uri - The URI to make the request to
   * @param {Object} [payload=null] - The payload to send with the request
   * @param {Object} [options={}] - Additional request options
   * @return {Promise} The server response
   */
  async function post(uri, payload = null, options = {}) {
    options.method = "POST";
    return await query(uri, payload, options).then((response) =>
      response.json()
    );
  }

  /**
   * Makes a GET request to the specified URI
   * @param {string} uri - The URI to make the request to
   * @param {Object} [payload=null] - The payload to send with the request
   * @param {Object} [options={}] - Additional request options
   * @return {Promise} The server response
   */
  async function get(uri, payload = null, options = {}) {
    options.method = "GET";
    if (payload)
      uri += `?${objectToQueryString(payload)}`;
    return await query(uri, null, options).then((response) => response.json());
  }

  /**
   * Makes a DELETE request to the specified URI
   * @param {string} uri - The URI to make the request to
   * @param {Object} [payload=null] - The payload to send with the request
   * @param {Object} [options={}] - Additional request options
   * @return {Promise} The server response
   */
  async function del(uri, payload = null, options = {}) {
    options.method = "DELETE";
    return await query(uri, payload, options).then((response) =>
      response.json()
    );
  }

  /**
   * Makes a request to the specified URI
   * @param {string} uri - The URI to make the request to
   * @param {Object} [payload=null] - The payload to send with the request
   * @param {Object} [options={}] - Additional request options
   * @return {Promise} The server response
   */
  async function query(uri, payload = null, options = {}) {
    try {
      isLoading.value = true;

      options.redirect = "follow";
      options.headers = options.headers || {};
      options.headers["Content-Type"] = "application/json";
      if (payload) {
        options.body = payload;
      }

      let url = uri;
      if (!uri.includes("http")) {
        options.headers.Authorization = import.meta.env.VITE_APP_AUTH_TOKEN;
        url = import.meta.env.VITE_WP_API_ROOT + uri;
      }
      options.body = JSON.stringify(options.body);
      const response = await fetch(url, options);
      return response;
    } catch (error) {
      console.error("API Error:", error);
      throw new Error("API Error");
    } finally {
      isLoading.value = false;
    }
  }
  /**
   * Converts an object into a URL query string
   * @param {Object} obj - The object to convert
   * @return {string} The URL query string
   */
  function objectToQueryString(obj) {
    const params = new URLSearchParams();

    for (const key in obj) {
      if (obj.hasOwnProperty(key)) {
        params.append(key, obj[key]);
      }
    }
    return params.toString();
  }
  return {
    isLoading,
    get,
    post,
    del,
    query,
  };
}
