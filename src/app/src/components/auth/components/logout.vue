<template>
  <v-card>
    <v-toolbar color="primary" dark>Sair do app</v-toolbar>
    <v-card-text>
      <center>
        <div class="p-large">
          <h2>Tem certeza que deseja sair do app?</h2>
        </div>
      </center>
    </v-card-text>
    <v-card-actions>
      <v-btn color="primary" text @click="logoutCancel()">Cancelar</v-btn>
      <v-spacer />
      <v-btn color="primary" @click="onHandleLogout()">Sair</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  methods: {
    async onHandleLogout() {
      await this.$serviceAuth.logout().then(() => {}).catch(()=> {});
      this.$load.loadOpen();
      await this.$load.snackbar("Deslogado com sucesso");
      this.$store.dispatch("userSignOut");
      localStorage.clear();
      this.logoutCancel();
      this.$load.loadDismiss();
      this.$router.push("/");
    },
    logoutCancel() {
      this.$emit("logoutCancel");
    }
  }
};
</script>