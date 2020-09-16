const actions = {
  userSignIn({ commit }, payload) {
    commit('USER_SIGN_IN', payload);
  },
  userSignOut({ commit }) {
    commit('USER_SIGN_OUT');
  },
  setLoader({ commit }, payload) {
    commit('SET_LOADER', payload);
  },
  setSnackbar({ commit }, payload) {
    commit('SET_SNACKBAR', payload);
  },
  setFormCandidatePessoal({ commit }, payload) {
    commit('SET_FORM_CANDIDATE_PESSOAL', payload);
  },
  setFormCandidateContato({ commit }, payload) {
    commit('SET_FORM_CANDIDATE_CONTATO', payload);
  },
  setFilterPreferences({ commit }, payload) {
    commit('SET_FILTER_PREFERENCES', payload);
  }
};

export default actions;
