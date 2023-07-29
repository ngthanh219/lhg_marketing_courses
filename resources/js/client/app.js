import '../bootstrap.js';
import './assets/sass/root.scss';

import {createApp} from 'vue'
import router from './router/index.js';
import store from './store';
import helper from './helpers/helper.js';
import env from '../env.js';

import App from './App.vue';

const app = createApp(App);

app.use(store);
app.use(router);
app.config.globalProperties.$helper = helper;
app.config.globalProperties.$env = env;

app.mount('#app');
