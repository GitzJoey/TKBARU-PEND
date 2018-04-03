window._ = require('lodash');
window.Popper = require('popper.js/dist/umd/popper').default;

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    require('jquery-slimscroll/jquery.slimscroll');
    require('jquery-scroll-lock/jquery-scrollLock');
    require('jquery.appear/jquery.appear');
    require('jquery-countto/jquery.countTo');
    require('jquery.cookie/jquery.cookie');
    window.moment = require('moment/moment');
    window.momentDurationFormat = require('moment-duration-format');
    require('jquery-gotop/src/jquery.gotop');
    require('fullcalendar/dist/fullcalendar');
    require('fullcalendar/dist/locale/id');
} catch (e) {
    console.error(e.message);
}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.Vue = require('vue');
window.VeeValidate = require('vee-validate');
window.VeeValidateID = require('vee-validate/dist/locale/id');

Vue.use(VeeValidate, {
    delay: 100,
    locale: $('html').attr('lang'),
    dictionary: VeeValidateID
});

//Vue.component('passport-clients', require('./components/passport/Clients.vue'));
//Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'));
//Vue.component('passport-personal-access-tokens',require('./components/passport/PersonalAccessTokens.vue'));

Vue.mixin({
    methods: {
        handleErrors: function(e) {
            //Catch For Laravel Validation
            if (e.response.data.errors != undefined && Object.keys(e.response.data.errors).length > 0) {
                for (var key in e.response.data.errors) {
                    for (var i = 0; i < e.response.data.errors[key].length; i++) {
                        this.$validator.errors.add('', e.response.data.errors[key][i], 'server', '__global__');
                    }
                }
            } else {
                //Catch From Controller
                this.$validator.errors.add('', e.response.data.message + ' (' +e.response.status + ' ' + e.response.statusText + ')', 'server', '__global__');
            }
        }
    }
});

