import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from './pages/Login.vue';
import Register from "./pages/Register.vue";
import Dashboard from "./pages/Dashboard.vue";
import PaymentHistory from "./pages/PaymentHistory.vue";

Vue.use(VueRouter);

const auth = (to, from, next) => {
    let token = localStorage.getItem('api_token');
    if (!token) {
        return router.push({
            name: 'login',
            params: {
                returnTo: to.path,
                query: to.query,
            },
        });
    }
    return next();
};

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            beforeEnter: auth
        },
        {
            path: '/payment-history',
            name: 'payment-history',
            component: PaymentHistory,
            beforeEnter: auth
        },
    ]
});
export default router;
