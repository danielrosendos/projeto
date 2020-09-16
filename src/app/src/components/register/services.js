import { config, axios } from '@/config';

const serviceRegister = {

  async register(payload) {
    return axios.post(`${config.api.url}api/registeruser`, payload);
  },

  async registerEstabeletimento(payload) {
    return axios.post(`${config.api.url}api/cadastrarnovoestabelecimento`, payload);
  },

}

export default serviceRegister;