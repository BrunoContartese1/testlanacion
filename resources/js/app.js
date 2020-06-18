/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import router from '@/js/routes.js';
import App from '@/js/views/App';
import store from '@/js/store';
/*========================================================
                    Plugins
/*======================================================*/
import moment from 'moment';

import Toasted from 'vue-toasted';
import 'vue-toasted/dist/vue-toasted.min.css';

import vuetify from '@/js/plugins/vuetify';

import VuejsDialog from 'vuejs-dialog';
import VuejsDialogMixin from 'vuejs-dialog/dist/vuejs-dialog-mixin.min.js';
import 'vuejs-dialog/dist/vuejs-dialog.min.css';
/*========================================================
                    Fin Plugins
/*======================================================*/
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!store.getters.loggedIn) {
        next({
            name: 'Login',
        })
        } else {
            next()
        }
    } else {
        next()
    }
})
/*========================================================
                    Mixins
/*======================================================*/
import handleErrors from '@/js/mixins/handleErrors';
Vue.mixin(handleErrors);
/*========================================================
                   Fin Mixins
/*======================================================*/

/*========================================================
                    Filtros
/*======================================================*/
Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY hh:mm');
    }
});
/*========================================================
                    Fin Filtros
/*======================================================*/

Vue.use(Toasted);
Vue.use(VuejsDialog);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
 const files = require.context('./', true, /\.vue$/i)
 files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    render: h => h(App),
});
