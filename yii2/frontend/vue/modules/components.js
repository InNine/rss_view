import Vue from 'vue';

import auth from '../components/auth.vue';
import ArticleList from '../components/article_list.vue';

let authForm = Vue.component('Auth', auth),
    articleList = Vue.component('article_list', ArticleList);
export {
    authForm,
    articleList
}