import Vue from 'vue';
import VueRouter from "vue-router";
import {articleList, authForm} from "./components";


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: '/article',
            beforeEnter: this.ifNotAuthenticated
        },
        {
            path: '/article',
            component: articleList,
            meta: {
                requiresAuth: true
            },
            beforeEnter: this.ifAuthenticated
        },
        {
            path: '/article/:page',
            component: articleList,
            meta: {
                requiresAuth: true
            },
            beforeEnter: this.ifAuthenticated
        },
        {
            path: '/auth/login',
            component: authForm,
            props: {
                isLogin: true
            },
            beforeEnter: this.ifNotAuthenticated
        },
        {
            path: '/auth/register',
            component: authForm,
            props: {
                isLogin: false
            },
            beforeEnter: this.ifNotAuthenticated
        },
    ],
    methods: {
        ifAuthenticated: function(to, from, next) {
            if (this.$store.getters.isAuthenticated) {
                next();
                return
            }
            next('/auth/login')
        },
        ifNotAuthenticated: function(to, from, next) {
            if (!this.$store.getters.isAuthenticated) {
                next();
                return
            }
            next('/article')
        }
    }
});
export {
    router
}