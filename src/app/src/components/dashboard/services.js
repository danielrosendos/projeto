import { config, axios } from '@/config';

const serviceDashboard = {
  async getEstabelecimentos() {
    return axios.get(`${config.api.url}api/listartodosestabelecimentos`);
  },
  async getEstabelecimentosCadastrados() {
    return axios.get(`${config.api.url}api/listarestabelecimentos`);
  },
  async atualizarEstabelecimento(payload) {
    return axios.put(`${config.api.url}api/atualizarestabelecimento`, payload);
  },
  async deletarEstabelecimento(id) {
    return axios.delete(`${config.api.url}api/deletarestabelecimento?id_estabelecimento=${id}`);
  },
  async getEstabelecimentosPorLocalidade(localidade) {
    return axios.get(`${config.api.url}api/listsearchestabelecimento?endereco==${localidade}`);
  }
};

export default serviceDashboard;
