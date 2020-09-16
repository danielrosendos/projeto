<template>
  <section>
    <v-card width="490" style="border-radius:50px">
      <v-card-text>
        <form>
          <center>
            <app-indentidade :full="true" />
          </center>
          <v-container fluid>
            <v-row justify="space-around">
              <v-col cols="12">
                <v-text-field 
                  class="inputforms" 
                  outlined label="E-mail" 
                  v-model="form.model.email">
                </v-text-field>
                <v-text-field
                  class="inputforms"
                  outlined
                  label="Senha"
                  v-model="form.model.password"
                  :append-icon="show ? icons.eyeOn : icons.eyeOff"
                  @click:append="show = !show"
                  :type="show ? 'text' : 'password'"
                  @keyup.enter="onSignIn()"
                />
              </v-col>
              <v-col cols="4">
                <v-btn
                  class="btn-confirm"
                  :loading="form.processing"
                  @click.stop="onSignIn()"
                  block
                >Acessar</v-btn>
                
                <v-row justify="center" class="create-account">
                  <a 
                    @click.stop="onRegisterUser()" 
                    style="color:#4652BC;"
                  >
                    Criar Conta
                  </a>
                </v-row>
              </v-col>
            </v-row>
          </v-container>
        </form>
      </v-card-text>
    </v-card>
  </section>
</template>

<script>
import { mask } from "vue-the-mask";
import { mdiEyeOff, mdiEye } from "@mdi/js";
import { axios } from '@/config';

export default {
  name: "Login",
  directives: {
    mask
  },
  data() {
    return {
      form: {
        model: {
          email: "",
          password: ""
        },
        processing: false
      },
      show: false,
      icons: {
        eyeOff: mdiEyeOff,
        eyeOn: mdiEye
      }
    };
  },
  methods: {
    async onSignIn() {
      this.setProgress(true);
      await this.$serviceAuth
        .login(this.form.model)
        .then(async res => {
          this.$load.snackbar(res.data.message);
          await this.$serviceAuth.logStoreDispache(res.data);
          axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.data.access_token}`;
          this.$router.push("dashboard");
        })
        .catch(err => {
          this.setProgress(false);
          this.$load.snackbar(err.response.data.message);
        });
    },
    onRegisterUser() {
      this.$router.push("register");
    },
    setProgress(status) {
      this.form.processing = status;
    }
  }
};
</script>
