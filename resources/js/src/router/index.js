import {createRouter, createWebHistory} from 'vue-router'
import {useAuth} from '../stores/modules/auth.js'

const routes = [
    {
        path: '/login',
        component: () => import('../views/auth/layouts/AuthLayout.vue'),
        children: [
            {
                path: '',
                name: 'login',
                component: () => import('../views/auth/fragments/Login.vue')
            }
        ]

    },
    // {
    //     path : '/',
    //     name : 'Dashboard',
    //     component : import('../views/layouts/Dashboard.vue'),
    // },
    {
        path: '/',
        name: 'dashboard',
        component: () => import('../views/layouts/Dashboard.vue'),
        meta: {
            title: 'Home',
            breadcrumb: {
                label: 'Dashboard',
            }
        },
        redirect: '/customers',
        children: [
            {
                path: '/:pathMatch(.*)*',
                name: 'notFound',
                component: import('../views/pages/notFound/PageNotFound.vue')
            },
            {
                path: '/customers',
                meta: {
                    title: 'Customer',
                    breadcrumb: {
                        label: 'Customers'
                    }
                },
                children: [
                    {
                        path: '',
                        name: 'customers',
                        component: () => import('../views/pages/customer/Customer.vue'),
                        meta: {
                            title: 'Customer',
                            breadcrumb: {
                                label: 'All'
                            }
                        }
                    },
                    {
                        path: '/customer/create',
                        name: 'addCustomer',
                        component: () => import('../components/drawer/Customer/AddCustomer.vue'),
                        meta: {
                            title: 'Add Customer',
                            breadcrumb: {
                                label: 'Add'
                            }
                        }
                    },
                ]
            },
            {
                path: '/rooms',
                meta: {
                    title: 'Room',
                    breadcrumb: {
                        label: 'Rooms'
                    }
                },
                children: [
                    {
                        path: '',
                        name: 'rooms',
                        component: () => import('../views/pages/room/Room.vue'),
                        meta: {
                            title: 'Room',
                            breadcrumb: {
                                label: 'All'
                            }
                        }
                    }
                ]
            },
            {
                path: '/staffs',
                meta: {
                    title: 'Staff',
                    breadcrumb: {
                        label: 'Staffs'
                    }
                },
                children: [
                    {
                        path: '',
                        name: 'staffs',
                        component: () => import('../views/pages/staff/Staff.vue'),
                        meta: {
                            title: 'Staff',
                            breadcrumb: {
                                label: 'All'
                            }
                        }
                    }
                ]
            },
            {
                path: '/reservations',
                meta: {
                    title: 'Reservation',
                    breadcrumb : {
                        label : 'Reservations'
                    }
                },
                children : [
                    {
                        path : '',
                        name: 'reservations',
                        component: () => import('../views/pages/reservation/Reservation.vue'),
                        meta : {
                            title : 'Reservation',
                            breadcrumb : {
                                label : 'All'
                            }
                        }
                    }
                ]
            },
            {
                path: '/payments',
                meta: {
                    title: 'Payment',
                    breadcrumb : {
                        label : 'Payments'
                    }
                },
                children : [
                    {
                        path : '',
                        name: 'payments',
                        component: () => import('../views/pages/payment/Payment.vue'),
                        meta : {
                            title : 'Payment',
                            breadcrumb : {
                                label : 'All'
                            }
                        }
                    }
                ]
            }
        ]
    },
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

router.beforeEach((to, from) => {

    const authStore = useAuth();
    if (!authStore.getAuth && to.name !== 'login') return {name: 'login'};
    if (authStore.getAuth && to.name === 'login') return from;
    if (authStore.getAuth && to.name !== 'login') return true;
});
export default router;
