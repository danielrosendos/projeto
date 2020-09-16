<template>
  <v-dialog v-model="stateToast.visible">
    <center>
      <v-progress-circular :size="50" color="primary" indeterminate></v-progress-circular>
    </center>
  </v-dialog>
</template>


<script>
export default {
  computed: {
    stateToast() {
      return this.$store.getters.loarder;
    }
  }
};
</script>
