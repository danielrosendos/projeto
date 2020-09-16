import vue from 'vue';
import inscription from './indentidade';
import fullLoader from './full-loader';
import snackbar from './snackbar';
import buffer from './buffer';

vue.component('app-indentidade', inscription);
vue.component('app-full-loader', fullLoader);
vue.component('app-snackbar', snackbar);
vue.component('app-buffer', buffer)
