import store from '@/store';
import sleep from './sleep';

const loader = {

  async snackbar(message = '', color = 'primary') {
    if (message === '@ERROR') {
      message = "Tivemos um erro interno! Por favor tente novamente mais tarde :)";
      color = 'error';
    }
    store.dispatch('setSnackbar', { color: color, visible: true, content: message });
    await sleep.time(4000);
    store.dispatch('setSnackbar', { color: color, visible: false, content: message });
  },

  snackbarError(err) {
    console.log(err);
    this.snackbar("@ERROR");
  },

  async load(time = 1000) {
    this.loadAction('', true);
    await sleep.time(time);
    this.loadAction('', false);
  },

  async loadOpen() { this.loadAction('primary', true); },

  async loadDismiss() { this.loadAction('', false); },

  loadAction(color = 'primary', visible) { store.dispatch('setLoader', { color: color, visible: visible }); },

};

export default loader;  