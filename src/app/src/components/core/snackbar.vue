<template>
  <v-snackbar
    v-model="stateToast.visible"
    :color="stateToast.color"
    :timeout="timeout"
  >{{ stateToast.content }}</v-snackbar>
</template>

<script>
export default {
  data() {
    return {
      timeout: 6000
    };
  },
  computed: {
    stateToast() {
      return this.$store.getters.snackbar;
    }
  }
};
</script> 