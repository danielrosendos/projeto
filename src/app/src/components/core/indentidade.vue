<template>
  <div>
    <div @click.stop="changeDashboard()">
      <img :src="logo" width="218" height="50" v-if="!full" />
    </div>
    <div v-if="full">
      <img :src="logo" width="479" height="200" v-if="branco === true" />
      <img :src="logo" width="479" height="200" v-if="!branco" />
    </div>
  </div>
</template>
<script>
export default {
  props: {
    full: Boolean,
    branco: Boolean
  },
  methods: {
    changeDashboard() {
      this.$router.push('dashboard')
    }
  },
  computed: {
    logo () {
      return "/assets/images/logo.svg"
    }
  }
};
</script>