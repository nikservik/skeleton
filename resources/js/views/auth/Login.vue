<template>
    <div class="mt-75">
        <div class="error" v-if="errorsHappened">
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
  import { mapGetters } from 'vuex'
  export default {
    data() {
      return {
        email: null,
        password: null,
        wait: false,
      }
    },
    methods: {
      login () {
        this.$store.dispatch('errors/clear')
        this.$store.dispatch('auth/login', {
            email: this.email,
            password: this.password
          })
          .then(() => {
            this.$router.push({ name: 'dashboard' })
          })
          .catch(err => {
            this.$store.dispatch('errors/set', { login: 'failed' })
          })
      },
    },
    computed: {
      ...mapGetters('errors', {
        errorsHappened: 'happened'
      })
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
