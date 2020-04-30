<template>
  <Page type="no-header">
    <div class="page-text">
      <h1>Лучший скелетон</h1>
      <p>Эта страница видна всем – и авторизованным, и не авторизованным.</p>
      <h2>Важный подраздел</h2>
      <p>Вам разрешат смотреть на небо, читать книги, а особо приближенным – даже получать деньги.</p>
    </div>
    <template v-slot:bottom>
      <BigButton @clicked="$router.push({ name: 'login' })" 
        v-if="! loggedIn">
        {{ $t('login') }}
      </BigButton>
      <BigButton @clicked="$router.push({ name: 'register' })" 
        v-if="! loggedIn">
        {{ $t('register') }}
      </BigButton>
    </template>
  </Page>
</template>

<script>
import Page from '@/components/visual/Page'
import BigButton from '@/components/visual/BigButton'
import { mapGetters } from 'vuex'

export default {
    components: { Page, BigButton },
    computed: {
        ...mapGetters('auth', {
            loggedIn: 'loggedIn',
        }),
    }
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Добро пожаловать"
  login: "Войти"
  register: "Зарегистрироваться"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Welcome"
  login: "Sign in"
  register: "Register"
</i18n>
