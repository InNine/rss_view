import Vue from 'vue';
import Vuex from 'vuex';
import {router} from './router';
import axios from "axios/index";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        token: localStorage.getItem('user-token') || '',
        isLoading: false
    },
    getters: {
        isAuthenticated: state => !!state.token
    },
    actions: {
        // simple save token to local storage
        login: function ({state}, token) {
            localStorage.setItem('user-token', token.token);
            state.token = token.token;
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token.token;
            router.push('/');
        },
        logout: function ({state}) {
            localStorage.removeItem('user-token');
            state.token = '';
            router.push('/auth/login');
        },
    }
});