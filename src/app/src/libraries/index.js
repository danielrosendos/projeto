import vue from 'vue';
import loader from './load';
import helpers from './helpers';
import sleep from './sleep';
import libHttp from './http';

vue.prototype.$load = loader;
vue.prototype.$helpers = helpers;
vue.prototype.$sleep = sleep;
vue.prototype.$libHttp = libHttp;