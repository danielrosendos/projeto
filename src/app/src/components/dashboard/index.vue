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
              <v-row>
                <v-col cols="9">
                  <v-text-field
                    class="inputforms" 
                    prepend-inner-icon="mdi-map-marker"
                    v-model="locale"
                    @keyup.enter="searchLocal()"
                    outlined label="Pesquisar Estabelecimentos">
                  </v-text-field>
                </v-col>
                <v-col cols="3">
                  <v-btn 
                    class="btn-confirm" 
                    style="height: 56px !important;" 
                    block
                    @click.stop="cadastrarEstabelecimento()"
                  >
                    Adicionar estabelecimento
                  </v-btn>
                </v-col>
              </v-row>
              <v-col 
                cols="12" 
                v-for="(estabelecimento) in estabelecimentos"
                :key="estabelecimento.id"
              >
                <v-card style="border-radius:50px" color="#D3EBC8">
                  <v-card-text>
                    <h4>Nome: {{estabelecimento.nome_estabelecimento}} /
                    Endereco: {{estabelecimento.endereco}} /
                    Bairro: {{estabelecimento.bairro}} /
                    Número: {{estabelecimento.numero}} /
                    Complemento: {{estabelecimento.complemento}} /
                    CEP: {{estabelecimento.cep}}</h4>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-col>
          </v-card-text>
        </v-card>
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
      locale: ""
    };
  },
  async mounted() {
    this.getEstabelecimentos();
  },
  methods: {
    async getEstabelecimentos() {
      await this.$serviceDashboard
        .getEstabelecimentos()
        .then(async res => {
          this.$load.snackbar(res.data.message);
          this.estabelecimentos = res.data.data.estabelecimentos;
        }).catch(err => {
          this.estabelecimentos = [];
          this.$load.snackbar(err.response.data.message ?? err.response.data.status);
        });
    },
    async searchLocal() {
      await this.$serviceDashboard
        .getEstabelecimentosPorLocalidade(this.locale)
        .then(async res => {
          this.$load.snackbar(res.data.message);
          this.estabelecimentos = res.data.data.estabelecimentos;
        }).catch(err => {
          this.estabelecimentos = [];
          this.$load.snackbar(err.response.data.message ?? err.response.data.status);
        });
    },
    cadastrarEstabelecimento() {
      this.$router.push('cadastrarEstabelecimento');
    }
  },
  computed: {
    mobile() {
      return this.$vuetify.breakpoint.name === "xs" ? true : false;
    }
  }
};
</script>