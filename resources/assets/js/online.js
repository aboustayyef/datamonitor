
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        'status': 'loading',
        'values': {}
    },
    computed: {
        'daily_target': function(){
            if (this.status == 'loaded') {
                return this.values.recommended_daily * this.values.days_passed;
            }
            return 0;
        }
    },
    mounted: function(){
        axios.get('https://internet-balance-at-home.firebaseio.com/usage.json').then(data => {
            this.values = data.data;
            this.status = 'loaded';
        });
    }
});
