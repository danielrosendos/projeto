import Vue from 'vue';
import App from './App.vue';
import vuetify from './plugins/vuetify';
import store from './store/index';
import router from './router';
import axios from 'axios';

Vue.config.productionTip = false;

require('@/components');
require('@/services');
require('@/config');
require('@/libraries');
require('@/bootstrap')

Vue.prototype.$axios = axios;

new Vue({
  vuetify,
  store,
  router,
  components: { App },
  render: h => h(App)
}).$mount('#app');
