<template>
<v-card-text>
    <v-container 
      class="container fluid p-fixed" 
      fluid 
      align-center 
      fill-height
    >
      <v-layout align-center column justify-center>
        <v-card width="490" style="border-radius:50px">
            <v-card-text>
              <v-form>
                <v-container fluid>
                  <v-row justify="space-around">
                    <h1 style="color: #000">Cadastrar Novo Estabelecimento</h1>
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
                    <v-col cols="6">
                      <v-btn
                        class="btn-confirm"
                        :disabled="btnFrom"
                        :loading="form.processing"
                        @click.stop="onRegisterEstabelecimento()"
                        block
                      >Registrar</v-btn>
                    </v-col>
                  </v-row>
                </v-container>
              </v-form>
            </v-card-text>
          </v-card>
      </v-layout>
    </v-container>
</v-card-text>
</template>

<script>
import { mask } from "vue-the-mask";

export default {
  name: "Estabelecimento",
  directives: {
    mask
  },
  data() {
    return {
      form: {
        processing: false,
        btnDisable: true
      },
      masks: {
        cep: "#####-###",
      },
      payload: {
        endereco: "",
        bairro: "",
        numero: "",
        complemento: "",
        cep: ""
      },
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
    }
  },
  methods: {
    async onRegisterEstabelecimento() {
      this.setProgress(true);
      await this.$serviceRegister
        .registerEstabeletimento(this.payload)
        .then(async res => {
          this.$load.snackbar(res.data.message);
          this.$router.push("dashboard");
        })
        .catch(err => {
          this.setProgress(false);
          this.$load.snackbar(err.response.data.message);
        })
    },
    setProgress(status) {
      this.form.processing = status;
    }
  },
  computed: {
    mobile() {
      return this.$vuetify.breakpoint.name === "xs" ? true : false;
    },
    btnFrom() {
      if (
        this.payload.endereco &&
        this.payload.bairro &&
        this.payload.numero &&
        this.payload.cep
      ){
        return false;
      }
      return true;
    }
  }
}
</script>