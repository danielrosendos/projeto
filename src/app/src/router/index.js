import Login from '@/components/auth/index';
import Register from '@/components/register/index';
import Dashboard from '@/components/dashboard/index';
import CadastroEstabelecimento from '@/components/estabelecimento/index';
import AreaCliente from '@/components/cliente/index';
import store from '@/store';
import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const router = new Router({
  routes: [
    { path: '/', name: 'Default', redirect: '/login' },
    setRoute('login', Login, false),
    setRoute('register', Register, false),
    setRoute('dashboard', Dashboard, true),
    setRoute('cadastrarEstabelecimento', CadastroEstabelecimento, true),
    setRoute('areaCliente', AreaCliente, true),
  ]
});

function setRoute(name, component, isPrivate) {
  return {
    path: `/${name}`,
    name: name,
    component: component,
    meta: { requiresAuth: isPrivate, title: name }
  };
}

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    if (!store.getters.isLogged) {
      next({ name: 'login' });
    } else {
      next();
    }
  } else if (store.getters.isLogged) {
    next({ name: 'dashboard' });
  } else {
    next();
  }
});

export default router;
