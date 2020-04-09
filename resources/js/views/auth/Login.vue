<template>
    <div>
        <h1 class="page-header">{{ $t('login') }}</h1>
        <div class="error" v-if="hasError">
            <p>{{ $t('badLoginOrPassword') }}</p>
        </div>
        <form autocomplete="off" @submit.prevent="login" method="post">
            <div class="form-group">
                <label for="email">{{ $t('email') }}</label>
                <input type="email" id="email" placeholder="user@example.com" v-model="email" required>
            </div>
            <div class="form-group">
                <label for="password">{{ $t('password') }}</label>
                <input type="password" id="password" v-model="password" required>
            </div>
            <div class="flex justify-between items-center form-group">
              <div>
                <button type="submit" class="button" :disabled="wait">{{ $t('loginButton') }}</button>
              </div>
              <div>
                <a href="/remind" class="text-blue-600 hover:underline">{{ $t('forgotPassword') }}</a>
              </div>
            </div>
        </form>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        email: null,
        password: null,
        hasError: false,
        wait: false,
      }
    },
    mounted() {
      //
    },
    methods: {
      login() {
        this.wait = true;
        this.hasError = false;
        // get the redirect object
        var redirect = this.$auth.redirect()
        var app = this
        this.$auth.login({
          params: {
            email: app.email,
            password: app.password
          },
          success: function() {
            // handle redirection
            if(this.$auth.user().email_verified_at)
              this.$router.push({name: 'dashboard'});
            else
              this.$router.push({name: 'verify'});
          },
          error: function() {
            this.wait = false;
            app.hasError = true;
          },
          rememberMe: true,
          fetchUser: true
        })
      }
    }
  }
</script>

<i18n locale="ru" lang="yaml">
  login: "Вход"
  email: "Электронная почта"
  password: "Пароль"
  loginButton: "Войти"
  forgotPassword: "Забыли пароль?"
  badLoginOrPassword: "Неправильный адрес или пароль."
</i18n>

<i18n locale="en" lang="yaml">
  login: "Login"
  email: "E-mail"
  password: "Password"
  loginButton: "Login"
  forgotPassword: "Forgot password?"
  badLoginOrPassword: "Bad email or password."
</i18n>
