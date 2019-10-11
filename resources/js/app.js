import './bootstrap';
import Vue from 'vue';

import Routes from '@/js/routes.js';
import Store from '@/js/store.js';

import App from '@/js/views/App.vue';

const app = new Vue({
    el: '#app',
    router: Routes,
    store: Store,
    render: h => h(App)
});

export default app;
