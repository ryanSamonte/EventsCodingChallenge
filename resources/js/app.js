require('./bootstrap');

window.Vue = require('vue');

import Vue           from 'vue'
import Notifications from 'vue-notification'

Vue.use(Notifications);

Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('calendarform', require('./components/CalendarForm.vue').default);
Vue.component('calendar', require('./components/Calendar.vue').default);

export const retrieve_calendar_trigger = new Vue();

const app = new Vue({
    el: '#app',
});
