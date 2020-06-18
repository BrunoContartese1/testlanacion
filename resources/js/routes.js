import Vue from 'vue';
import VueRouter from 'vue-router';

/*Pages*/
/*===================================================
                    Auth
====================================================*/
import Login from '@/js/views/auth/login';
import Logout from '@/js/views/auth/logout';

/*===================================================
                    Home
====================================================*/
import Home from '@/js/views/home';

/*===================================================
                    Profiles
====================================================*/
import Profiles from '@/js/views/administration/profiles/index';
import profilePermissions from '@/js/views/administration/profiles/permissions';

/*===================================================
                    Users
====================================================*/
import Users from '@/js/views/administration/users/index';

/*===================================================
                    Errors
====================================================*/
import NotFound from '@/js/views/errors/notFound';


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/login',
            name: 'Login',
            component: Login,
        },
        {
            path: '/logout',
            name: 'Logout',
            component: Logout,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/',
            name: 'Home',
            component: Home,
            meta: {
                requiresAuth: true,
            }
        },
        /*========================================================
                                Profiles
        /*======================================================*/
        {
            path: '/Administration/Profiles',
            name: 'Profiles',
            component: Profiles,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/Administration/Profile/:id/permissions',
            name: 'profilePermissions',
            component: profilePermissions,
            meta: {
                requiresAuth: true,
            }
        },

        /*========================================================
                                /Profiles
        /*======================================================*/

        /*========================================================
                                Users
        /*======================================================*/
        {
            path: '/Administration/Users',
            name: 'Users',
            component: Users,
            meta: {
                requiresAuth: true,
            }
        },

        /*========================================================
                                /Users
        /*======================================================*/
        {
            path: '/404',
            name: '404',
            component: NotFound,
        },
        {
            path: '*',
            redirect: '/404',
        },
    ]
});

export default router;
