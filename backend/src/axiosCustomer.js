import axios from "axios";
import store from "./store";
import router from "./router/index.js";
const axiosCustomer = axios.create({
  baseURL: `http://localhost:8000/api`
})

axiosCustomer.interceptors.request.use(config => {
  config.headers.Authorization = `Bearer ${store.state.customer.token}`
  return config;
})
axiosCustomer.interceptors.response.use(response => {
  return response;
}, error => {
  if (error.response.status === 401) {
    store.commit('setTokenCustomer', null)
    router.push({name: 'login'})
  }
  throw error;
})

export default axiosCustomer;