import Vue from 'vue';
import Vuex from 'vuex';
import state from './state';
import getters from './getters';
import actions from './actions';
import mutations from './mutations';
import VuexPersist from 'vuex-persist';
import { storeKeys } from '../config';

Vue.use(Vuex);

const vuexLocalStorage = new VuexPersist({
  key: storeKeys.auth,
  storage: window.localStorage,
});

const store = new Vuex.Store({
  strict: true,
  state,
  getters,
  actions,
  mutations,
  plugins: [vuexLocalStorage.plugin]
});

export default store;
