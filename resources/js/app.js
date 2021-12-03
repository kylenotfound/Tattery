require('./bootstrap');


window.Vue = require('vue').default;
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.component('like', () => import('../js/Components/Like.vue'));
Vue.component('follow', () => import('../js/Components/Follow.vue'));
Vue.component('followcounter', () => import('../js/Components/FollowCounter.vue'));

export const EventBus = new Vue();

const app = new Vue({
    el:'#app'
});
