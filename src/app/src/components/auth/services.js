import { config, axios } from '@/config';
import store from '@/store';

const serviceAuth = {

  async login(payload) {
    return axios.post(`${config.api.url}api/authuser`, payload);
  },

  async logout(payload) {
    return axios.post(`${config.api.url}logout`, payload);
  },

  async logStoreDispache(response) {
    const { data } = response;
    store.dispatch("userSignIn", {
      data,
      logged: true
    });
  }

};

export default serviceAuth;
