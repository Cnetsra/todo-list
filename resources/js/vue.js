import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';

Vue.use(VueRouter);

import App from './vue/App.vue';
import Index from './vue/views/Index.vue';
import Create from './vue/views/Create.vue';
import Show from './vue/views/Show.vue';
import Edit from './vue/views/Edit.vue';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'index',
            component: Index,
            props: true
        },
        {
            path: '/create',
            name: 'create',
            component: Create
        },
        {
            path: '/show/:id',
            name: 'show',
            component: Show,
            props: true
        },
        {
            path: '/edit/:id',
            name: 'edit',
            component: Edit,
            props: true
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store
});