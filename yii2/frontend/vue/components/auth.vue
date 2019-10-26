<template>
    <div class="auth_form">
        <router-link class="btn__outline" to="/auth/login">Login</router-link>
        or
        <router-link class="btn__outline" to="/auth/register">Register</router-link>
        <form class="auth_form__content" @submit.prevent="login" v-if="isLogin">
            <h1 class="auth_form__content__title">Login</h1>
            <div class="auth_form__content__input">
                <label>User name</label>
                <input required v-model="loginForm.username" type="text" placeholder="Your username"/>
            </div>
            <div class="auth_form__content__input">
                <label>Password</label>
                <input required v-model="loginForm.password" type="password" placeholder="Password"/>
            </div>
            <div class="btn-wrapper">
                <button class="btn" type="submit">Login</button>
                <div class="error-summary">{{errorMessage}}</div>
            </div>

        </form>
        <form class="auth_form__content" @submit.prevent="register" v-else>
            <h1 class="auth_form__content__title">Sign up</h1>
            <div class="auth_form__content__input">
                <label>User name</label>
                <input required v-model="registerForm.username" type="text" placeholder="Create unique username"/>
            </div>
            <div class="auth_form__content__input">
                <label>Password</label>
                <input required v-model="registerForm.password" type="password" placeholder="Create password"/>
            </div>

            <div class="auth_form__content__input">
                <label>Repeat password</label>
                <input required v-model="registerForm.repeat_password" type="password" placeholder="Repeat password"/>
            </div>
            <div class="btn-wrapper">
                <button class="btn" type="submit">Sign up</button>
                <div class="error-summary">{{errorMessage}}</div>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'login',
        props: {
            isLogin: true,
        },
        data() {
            return {
                loginForm: {
                    username: '',
                    password: ''
                },
                registerForm: {
                    username: '',
                    password: '',
                    repeat_password: ''
                },
                errorMessage: ''
            }
        },
        methods: {
            login: function () {
                let $this = this;

                $this.$root.showLoading();

                axios({
                    url: '/api/auth/login',
                    method: 'post',
                    data: this.loginForm,
                })
                    .then(function (response) {
                        let data = response.data;
                        $this.loginProcess(data);
                    })
            },
            register: function () {
                let $this = this;

                $this.$root.showLoading();

                axios({
                    url: '/api/auth/register',
                    method: 'post',
                    data: this.registerForm,
                })
                    .then(function (response) {
                        let data = response.data;
                        $this.loginProcess(data);
                    })
            },
            // unified login process for register and login
            loginProcess: function(data) {
                this.$root.removeLoading();
                if (data.success) {
                    this.$store.dispatch('login', {
                        token: data.token
                    });
                } else {
                    this.showErrorMessage(data.message)
                }
            },
            // Show message if smth was wrong with filling the form
            showErrorMessage: function (message) {
                let $this = this;
                $this.errorMessage = message;
                setTimeout(function () {
                    $this.errorMessage = '';
                }, 10000);
            }
        },


    }
</script>

<style scoped>

</style>