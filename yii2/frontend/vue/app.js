import Vue from 'vue';
import axios from 'axios';
import {store} from './modules/store';
import {router} from './modules/router';


//Auth and default headers
if (store.getters.isAuthenticated) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.state.token;
}
axios.defaults.headers.common['Content-type'] = 'application/json; charset=UTF-8';
axios.defaults.responseType = 'json';

// Default actions for response
axios.interceptors.response.use(function (response) {
    return response
}, function (error) {
    //Remove loading
    app.removeLoading();

    //Logout if unauthorized request
    if (error.response.data.status === 401) {
        store.dispatch('logout');
    }
    return Promise.reject(error)
});

let app = new Vue({
    router,
    store,
    el: '#app',
    methods: {
        //methods to show/hide loading screen
        showLoading: function () {
            store.state.isLoading = true;
        },
        removeLoading: function () {
            store.state.isLoading = false;

        }
    }
});