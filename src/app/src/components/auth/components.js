import vue from 'vue';

import auth from './index';
import login from './components/login';
import logout from './components/logout';

vue.component('app-auth', auth);
vue.component('app-login', login);
vue.component('app-logout', logout);
