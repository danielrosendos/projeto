<template>
  <v-card-text>
    <v-container 
      class="container fluid p-fixed" 
      fluid 
      align-center 
      fill-height
    >
      <v-layout align-center column justify-center>
        <v-card width="70%" style="border-radius:50px">
          <v-card-text>
            <v-col cols="12">
              <v-row justify="space-around" style="margin-bottom: 50px">
                <h1>Estabelecimentos Cadastrados Deste Usuário</h1>
              </v-row>
              <v-col 
                cols="12"
                style="cursor:pointer"
                v-for="(estabelecimento) in estabelecimentos"
                :key="estabelecimento.id"
                @click="editEstabelecimento(estabelecimento)"
              >
                <v-card style="border-radius:50px" color="#D3EBC8">
                  <v-card-text>
                    <h4>
                      Nome: {{estabelecimento.nome_estabelecimento}} /
                      Endereco: {{estabelecimento.endereco}} /
                      Bairro: {{estabelecimento.bairro}} /
                      Número: {{estabelecimento.numero}} /
                      Complemento: {{estabelecimento.complemento}} /
                      CEP: {{estabelecimento.cep}}
                    </h4>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-col>
          </v-card-text>
        </v-card>
        <v-dialog
          v-model="modal"
          width="500"
        >
          <v-card>
            <v-card-title style="background-color: #D3EBC8;">
              Estabelecimento: {{payload.nome_estabelecimento}}
              <v-spacer/>
              <v-btn class="btn-confirm"
                style="background: red !important"
                @click.stop="deletarEstabelecimento(payload.id)"
                text>
                Deletar
              </v-btn>
            </v-card-title>

            <v-card-text style="justify-content: center; display: flex">
              <v-col cols="10" style="margin-top: 50px">
                <v-text-field 
                  class="inputforms" 
                  v-model="payload.nome_estabelecimento"
                  :rules="nomeEstabelecimentoRules"
                  outlined label="Nome do Estabelecimento">
                </v-text-field>
                <v-text-field 
                  class="inputforms" 
                  v-model="payload.endereco"
                  :rules="enderecoRules"
                  outlined label="Endereco">
                </v-text-field>
                <v-text-field 
                  class="inputforms"
                  :rules="bairroRules"
                  v-model="payload.bairro"
                  outlined label="Bairro">
                </v-text-field>
                <v-text-field 
                  class="inputforms" 
                  :rules="numeroRules"
                  v-model="payload.numero"
                  outlined label="Número">
                </v-text-field>
                <v-text-field 
                  class="inputforms"
                  v-model="payload.complemento"
                  outlined label="Complemento">
                </v-text-field>
                <v-text-field
                  class="inputforms"
                  return-masked-value
                  v-mask="masks.cep"
                  v-model="payload.cep"
                  :rules="cepRules"
                  outlined label="CEP">
                </v-text-field>
              </v-col>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
              <v-btn
                class="btn-confirm"
                style="background: gray !important"
                text
                @click="cancelEdit()"
              >
                Cancelar
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn
                text
                @click="updateLocale()"
              >
                Atualizar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-layout>
    </v-container>
  </v-card-text>
</template>

<script>
import { mask } from "vue-the-mask";

export default {
  directives: {
    mask
  },
  data() {
    return {
      estabelecimentos: [],
      locale: "",
      masks: {
        cep: "#####-###",
      },
      payload: {
        id: "",
        nome_estabelecimento: "",
        endereco: "",
        bairro: "",
        numero: "",
        complemento: "",
        cep: ""
      },
      modal: false,
      cepRules: [
        cepStr => !!cepStr || "Cep é obrigatório"
      ],
      enderecoRules: [
        enderecoStr => !!enderecoStr || "Endereço é obrigatório"
      ],
      bairroRules: [
        bairroStr => !!bairroStr || "Bairro é obrigatório"
      ],
      nomeEstabelecimentoRules: [
        nomeEstabelecimentoStr => !!nomeEstabelecimentoStr || "Nome do Estabelecimento é obrigatório"
      ],
      numeroRules: [
        numeroStr => !!numeroStr || "Número é obrigatório"
      ]
    };
  },
  async mounted() {
    this.getEstabelecimentosCadastrados();
  },
  methods: {
    async getEstabelecimentosCadastrados() {
      await this.$serviceDashboard
        .getEstabelecimentosCadastrados()
        .then(async res => {
          this.$load.snackbar(res.data.message);
          this.estabelecimentos = res.data.data.estabelecimentos;
        }).catch(err => {
          this.$load.snackbar(err.response.data.message ?? err.response.data.status);
        });
    },
    async updateLocale() {
      await this.$serviceDashboard
        .atualizarEstabelecimento(this.payload)
        .then(async res => {
          this.$load.snackbar(res.data.message);
          this.estabelecimentos = res.data.data.estabelecimentos;
          this.modal = false;
          this.getEstabelecimentosCadastrados();
        }).catch(err => {
          this.$load.snackbar(err.response.data.message ?? err.response.data.status);
        });
    },
    async deletarEstabelecimento(id) {
      await this.$serviceDashboard
        .deletarEstabelecimento(id)
        .then(async res => {
          this.$load.snackbar(res.data.message);
          this.estabelecimentos = res.data.data.estabelecimentos;
          this.modal = false;
          this.getEstabelecimentosCadastrados();
        }).catch(err => {
          this.$load.snackbar(err.response.data.message ?? err.response.data.status);
        });
    },
    cadastrarEstabelecimento() {
      this.$router.push('cadastrarEstabelecimento');
    },
    editEstabelecimento(estabelecimento) {

      this.payload.id = estabelecimento.id;
      this.payload.nome_estabelecimento = estabelecimento.nome_estabelecimento;
      this.payload.endereco = estabelecimento.endereco;
      this.payload.bairro = estabelecimento.bairro;
      this.payload.numero = estabelecimento.numero;
      this.payload.complemento = estabelecimento.complemento;
      this.payload.cep = estabelecimento.cep;

      this.modal = true;
    },
    cancelEdit() {
        this.payload.id = "";
      this.payload.nome_estabelecimento = "";
      this.payload.endereco = "";
      this.payload.bairro = "";
      this.payload.numero = "";
      this.payload.complemento = "";
      this.payload.cep = "";

      this.modal = false;
    }
  },
  computed: {
    mobile() {
      return this.$vuetify.breakpoint.name === "xs" ? true : false;
    }
  }
};
</script>