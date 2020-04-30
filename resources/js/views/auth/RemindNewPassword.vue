<template>

    <Page>
        <PageHeader back="home">
            {{ $t('pageTitle') }}
        </PageHeader>
        <div class="page-icon">
            <IconLock classes="mx-auto" height="75" />
        </div>
        <template v-slot:bottom>
            <form @submit.prevent="reset" class="form">
                <div class="group" :class="{ 'has-error' : hasError('password') }">
                    <label for="password">{{ $t('password') }}</label>
                    <input type="password" v-model="password" required>
                    <div class="error-description" v-if="hasError('password')" v-for="error in errors.password">
                        {{ $t('errors.'+error) }}
                    </div>
                </div>
                <div class="group">
                    <label for="password_confirmation">{{ $t('passwordConfirmation') }}</label>
                    <input type="password" v-model="password_confirmation" required>
                </div>

                <div class="error" v-if="hasError('token')">
                    {{ $t('errors.' + errors.token) }}
                </div>

                <BigButton :disable="disable || ! goodToken" @clicked="reset">
                  {{ $t('save') }}
                </BigButton>
            </form>
        </template>
    </Page>
</template>

<script>
import IconLock from '@/components/visual/icons/IconLock'
import Page from '@/components/visual/Page'
import PageBlock from '@/components/visual/PageBlock'
import BigButton from '@/components/visual/BigButton'
import PageHeader from '@/components/visual/PageHeader'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { IconLock, Page, PageHeader, PageBlock, BigButton },
    data() {
      return {
        password: null,
        password_confirmation: null,
        goodToken: false,
      }
    },
    mounted() {
      this.$store.dispatch('auth/checkToken', { 
          token: this.$route.query.token, 
          email: this.$route.query.email 
        })
        .then(() => {
          if (! this.errorsHappened)
            this.goodToken = true
        })
    },
    methods: {
      reset() {
        this.$store.dispatch('errors/clear')
        this.$store.dispatch('auth/newPassword', { 
            token: this.$route.query.token, 
            email: this.$route.query.email, 
            password: this.password, 
            password_confirmation: this.password_confirmation, 
          })
          .then(() => {
            if (! this.errorsHappened)
              this.$router.push({ name: 'login' })
          })
      },
    },
    computed: {
        ...mapGetters('loading', {
            disable: 'disable',
        }),
        ...mapGetters('errors', {
            errorsHappened: 'happened',
            hasError: 'has',
        }),
        ...mapState('errors', {
            errors: state => state.errors
        }),
        ...mapState('message', {
            message: state => state.message
        }),
    }
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Новый пароль"
  password: "Пароль"
  passwordConfirmation: "Подтверждение пароля"
  save: "Сохранить пароль"
  errors:
    validation: "Исправьте ошибки, чтобы установить новый пароль"
    email: "Некорректная ссылка. Для установки пароля используйте ссылку, которую мы отправили вам на почту."
    token: "Ссылка устарела. Запросите новый сброс пароля на странице входа"
    password:
        required: "Пароль обязательно нужен"
        min: "Пароль должен быть не меньше 8 символов"
        confirmed: "Пароль и подтверждение пароля должны совпадать"
    passwords:
        reset: "Новый пароль установлен"
        user: "Нет пользователя с такой электронной почтой"
        token: "Эта ссылка для сброса пароля недействительна"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Set new password"
  password: "Password"
  passwordConfirmation: "Confirm password"
  save: "Save"
  errors:
    validation: "Please verify provided input"
    email: "Incorrect link. Please use link we sent to your email"
    token: "Link is outdated. Request new password reset link on login page"
    password:
        required: "Password is required"
        min: "Password must be at least 8 symbols"
        confirmed: "Password and confirmation must be the same"
    passwords:
        reset: "New password succesfully stored"
        user: "User with this email doesn't exists"
        token: "This password reset link is outdated"
</i18n>
