import { axios } from '@/config';

const coreServices = {
  async searchAddress(cep){
    return axios.get(`https://viacep.com.br/ws/${cep}/json/`);
  } 
}

export default coreServices;