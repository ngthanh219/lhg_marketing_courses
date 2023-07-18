import '../bootstrap.js';

import {createApp} from 'vue'
import router from './router/index.js';
import store from './store';
import App from './App.vue';

import './assets/sass/root.scss';

const app = createApp(App);
app.use(store);
app.use(router);

app.mount('#app');
