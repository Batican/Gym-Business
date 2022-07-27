import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from '../pages/Login.vue';
import Main from '../pages/Main.vue';
import Dashboard from '../pages/Admin/Dashboard.vue';
import Admins from '../pages/Admin/Admin.vue';
import Employees from '../pages/Admin/Employee.vue';
import Customers from '../pages/Admin/Customer.vue';
import Equipments from '../pages/Admin/Equipment.vue';
import Subscriptions from '../pages/Admin/Subscription.vue';
import Payments from '../pages/Admin/Payment.vue';
import Memberships from '../pages/Admin/Membership.vue';



Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active-route',
    routes: [
        {
            path: '',
            name: 'main',
            component: Main,
            meta: {
                requiresAuth: true,
            },
            children: [{
                    path: '/dashboard',
                    name: 'dashboard',
                    component: Dashboard,
                },
                {
                    path: '/admins',
                    name: 'admins',
                    component: Admins,
                },
                {
                    path: '/employees',
                    name: 'employees',
                    component: Employees,
                },
                {
                    path: '/customers',
                    name: 'customers',
                    component: Customers,
                },
                {
                    path: '/equipments',
                    name: 'equipments',
                    component: Equipments,
                },
                {
                    path: '/subscriptions',
                    name: 'subscriptions',
                    component: Subscriptions,
                },
                {
                    path: '/memberships',
                    name: 'memberships',
                    component: Memberships,
                },
                {
                    path: '/payments',
                    name: 'payments',
                    component: Payments,
                },
                
            ]
        },

        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                requiresAuth: false
            },
        },
    ]
});

router.beforeEach(async (to, from, next) => {
    localStorage.setItem('from', from.fullPath)
    // let user = null
    const user = localStorage.getItem('token')       
    
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    
    if (!requiresAuth && user) {
        console.log('not require auth but there is user')
        next(from)
    } else if (requiresAuth && !user) {
        console.log('require auth there is no user')
        next('/login');
    } else {
        console.log('next')
        next();
    }

})

export default router;