<template>
  <div>
    <v-container 
      class="container fluid p-fixed" 
      fluid 
      align-center 
      fill-height
    >
      <v-layout align-center column justify-center>
        <app-login />
      </v-layout>
    </v-container>
  </div>
</template>

<script>
export default {
  computed: {
    stateAuth() {
      return this.$store.getters.auth;
    }
  }
};
</script>
