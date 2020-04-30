<template>
  <div>
    <PageHeader back="home">
        {{ $t('pageTitle') }}
    </PageHeader>

    <Page>
        <div class="page-icon">
            <IconProfile classes="mx-auto" height="75" />
        </div>
        <template v-slot:bottom>
            <form @submit.prevent="login" class="form">
                <div class="group" :class="{ 'has-error' : errorsHappened }">
                    <label for="email">{{ $t('email') }}</label>
                    <input type="email" placeholder="user@example.com" v-model="email" required>
                    </div>
                <div class="group" :class="{ 'has-error' : errorsHappened }">
                    <label for="password">{{ $t('password') }}</label>
                    <input type="password" v-model="password" required>
                </div>
                <div class="error" v-if="errorsHappened">
                    {{ $t('badLoginOrPassword') }}
                </div>
                <div class="flex justify-between items-center group">
                    <div class="flex-grow-0">
                      <LoadingButton :disable="disable">{{ $t('loginButton') }}</LoadingButton>
                    </div>
                    <a href="/remind" class="text-prime-500 hover:underline block mb-16">{{ $t('forgotPassword') }}</a>
                </div>
            </form>
        </template>
    </Page>
  </div>
</template>
<script>
import IconProfile from '@/components/visual/icons/IconProfile'
import Page from '@/components/visual/Page'
import LoadingButton from '@/components/visual/LoadingButton'
import PageHeader from '@/components/visual/PageHeader'
import { mapGetters } from 'vuex'

export default {
    components: { IconProfile, Page, PageHeader, LoadingButton },
    data() {
      return {
        email: null,
        password: null,
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
            if (! this.errorsHappened)
              this.$router.push({ name: 'dashboard' })
          })
      },
    },
    computed: {
        ...mapGetters('loading', {
            disable: 'disable',
        }),
        ...mapGetters('errors', {
            errorsHappened: 'happened'
        })
    }
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Вход"
  email: "Электронная почта"
  password: "Пароль"
  loginButton: "Войти"
  forgotPassword: "Забыли пароль?"
  badLoginOrPassword: "Неправильный адрес или пароль"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Login"
  email: "E-mail"
  password: "Password"
  loginButton: "Login"
  forgotPassword: "Forgot password?"
  badLoginOrPassword: "Bad email or password"
</i18n>
