const getters = {
  auth: state => state.auth,
  isLogged: (state) => {
    return state.auth.logged;
  },
  loarder: state => state.loarder,
  snackbar: state => state.snackbar
};

export default getters;
