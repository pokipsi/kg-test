import Vue from 'vue';
import VueRouter from 'vue-router';

import Admin from '@/js/components/admin/Admin';
import Welcome from '@/js/components/admin/Welcome';
import Login from '@/js/components/admin/Login';
import Users from '@/js/components/admin/Users';
import Quotes from '@/js/components/admin/Quotes';
import Homepage from '@/js/components/Homepage';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [{
            path: '/',
            name: 'homepage',
            component: Homepage
        }, {
            path: '/admin-panel',
            name: 'admin',
            component: Admin,
            children: [
                {
                    path: '',
                    name: 'welcome',
                    component: Welcome
                }, {
                    path: 'login',
                    name: 'adminAuth',
                    component: Login
                }, {
                    path: 'users',
                    name: 'users',
                    component: Users
                }, {
                    path: 'quotes',
                    name: 'quotes',
                    component: Quotes
                }
            ]
        }
    ]
});

export default router;