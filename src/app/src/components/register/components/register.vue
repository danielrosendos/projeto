<template>
  <section>
    <v-card width="490" style="border-radius:50px">
       <v-card-text>
         <v-form>
           <v-container fluid>
            <v-row justify="space-around">
              <h1 style="color: #000">Cadastrar Usuário</h1>
              <v-col cols="10" style="margin-top: 50px">
                <v-text-field 
                  class="inputforms" 
                  v-model="payload.primeiro_nome"
                  :rules="primeiroNomeRules"
                  outlined label="Nome">
                </v-text-field>
                <v-text-field 
                  class="inputforms" 
                  v-model="payload.ultimo_nome"
                  :rules="ultimoNomeRules"
                  outlined label="Sobrenome">
                </v-text-field>
                <v-text-field 
                  class="inputforms" 
                  v-mask="masks.cpf"
                  :rules="cpfRules"
                  v-model="payload.cpf"
                  outlined label="CPF">
                </v-text-field>
                <v-text-field 
                  class="inputforms" 
                  :rules="emailRules"
                  v-model="payload.email"
                  outlined label="E-mail">
                </v-text-field>
                <v-text-field 
                  class="inputforms"
                  v-model="confirmemail"
                  :rules="confirmEmailRules"
                  outlined label="Confirmação E-mail">
                </v-text-field>
                <v-text-field 
                  class="inputforms" 
                  v-model="payload.password"
                  password
                  :rules="paswordRules"
                  :append-icon="show ? icons.eyeOn : icons.eyeOff"
                  @click:append="show = !show"
                  :type="show ? 'text' : 'password'"
                  outlined label="Senha">
                </v-text-field>
                <v-text-field 
                  class="inputforms" 
                  password
                  type="password"
                  v-model="confirmpassword"
                  :rules="confirmPassRules"
                  outlined label="Confirmação de Senha">
                </v-text-field>
                <v-text-field
                  class="inputforms"
                  return-masked-value
                  v-mask="masks.cep"
                  v-model="payload.cep"
                  :rules="cepRules"
                  outlined label="CEP">
                </v-text-field>
                <v-text-field 
                  class="inputforms" 
                  v-model="payload.endereco"
                  :rules="enderecoRules"
                  outlined label="Endereço">
                </v-text-field>
                <v-text-field 
                  class="inputforms" 
                  v-model="payload.bairro"
                  :rules="bairroRules"
                  outlined label="Bairro">
                </v-text-field>
                <v-text-field 
                  class="inputforms" 
                  v-model="payload.numero"
                  :rules="numeroRules"
                  outlined label="Número">
                </v-text-field>
                <v-text-field
                  class="inputforms" 
                  v-model="payload.complemento"
                  outlined label="Complemento">
                </v-text-field>
              </v-col>
              <v-col cols="6">
                <v-btn
                  class="btn-confirm"
                  :disabled="btnFrom"
                  :loading="form.processing"
                  @click.stop="onRegisterUser()"
                  block
                >Registrar</v-btn>
              </v-col>
            </v-row>
           </v-container>
         </v-form>
       </v-card-text>
    </v-card>
  </section>
</template>

<script>
import { mask } from "vue-the-mask";
import helpers from "@/libraries/helpers";
import { mdiEyeOff, mdiEye } from "@mdi/js";

export default {
  name: "Register",
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
        cpf: "###.###.###-##"
      },
      payload: {
        primeiro_nome: "",
        ultimo_nome: "",
        cpf: "",
        password: "",
        endereco: "",
        bairro: "",
        numero: "",
        complemento: "",
        cep: "",
        email: ""
      },
      show: false,
      icons: {
        eyeOff: mdiEyeOff,
        eyeOn: mdiEye
      },
      confirmpassword: "",
      confirmemail: "",
      primeiroNomeRules: [
        primeiroNome => !!primeiroNome || "Nome é Obrigatório"
      ],
      ultimoNomeRules: [
        ultimoNome => !!ultimoNome || "Sobrenome é Obrigatório"
      ],
      cpfRules: [
        cpfStr => !!cpfStr || "CPF é Obrigatório",
      ],
      emailRules: [
        emailStr => !!emailStr || "Email é Obrigatório",
        emailStr => helpers.isEmail(emailStr) || "Não é um email válido",
      ],
      confirmEmailRules: [
        emailConfirm => emailConfirm === this.payload.email || "E-mail não conferem" 
      ],
      paswordRules: [
        passRule => !!passRule || "Senha é Obrigatório" 
      ],
      confirmPassRules: [
        confirmPass => confirmPass === this.payload.password || "Senhas não Conferem"
      ],
      cepRules: [
        cepStr => !!cepStr || "Cep é obrigatório"
      ],
      enderecoRules: [
        enderecoStr => !!enderecoStr || "Endereço é obrigatório"
      ],
      bairroRules: [
        bairroStr => !!bairroStr || "Bairro é obrigatório"
      ],
      numeroRules: [
        numeroStr => !!numeroStr || "Número é obrigatório"
      ]
    }
  },
  methods: {
    async onRegisterUser() {
      this.setProgress(true);
      await this.$serviceRegister
        .register(this.payload)
        .then(async res => {
          this.$load.snackbar(res.data.message);
          this.$router.push("login");
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
        this.payload.password === this.confirmpassword &&
        this.payload.email === this.confirmemail &&
        this.payload.primeiro_nome &&
        this.payload.ultimo_nome &&
        this.payload.cpf &&
        this.payload.password &&
        this.payload.email &&
        this.payload.endereco &&
        this.payload.bairro &&
        this.payload.numero
      ){
        return false;
      }
      return true;
    }
  }
}
</script>