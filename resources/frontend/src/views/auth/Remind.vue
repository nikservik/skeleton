<template>
    <Page type="no-helpers">
        <PageHeader back="login">
            {{ $t('pageTitle') }}
        </PageHeader>
        <div class="page-icon">
            <IconLock classes="mx-auto" height="75" />
        </div>
        <template v-slot:bottom>
            <form @submit.prevent="remind" class="form">
                <div class="group" :class="{ 'has-error' : hasError('email') }">
                    <label for="email">{{ $t('email') }}</label>
                    <input type="email" placeholder="user@example.com" v-model="email" required>
                    <div v-if="hasError('email')">
                      <div class="error-description" v-for="error in errors.email" :key="error">
                          {{ $t('errors.'+error) }}
                      </div>
                    </div>
                </div>
                <BigButton :disable="disable" @clicked="remind">
                  {{ $t('send') }}
                </BigButton>
            </form>
        </template>
    </Page>
</template>
<script>
import IconLock from '@/components/visual/icons/IconLock'
import Page from '@/components/visual/Page'
import BigButton from '@/components/visual/BigButton'
import PageHeader from '@/components/visual/PageHeader'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { IconLock, Page, PageHeader, BigButton },
    data() {
      return {
        email: null,
      }
    },
    mounted() {
      //
    },
    methods: {
      remind() {
        this.$store.dispatch('errors/clear')
        this.$store.dispatch('auth/remind', this.email)
          .then(() => {
            if (! this.errorsHappened) {
              this.email = ''
              this.$store.dispatch('message/show' , this.$t('link.sent'))
            }
          })
      }
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
  pageTitle: "Напоминание пароля"
  email: "Электронная почта"
  send: "Отправить напоминание"
  link:
    sent: "Письмо со ссылкой для установки нового пароля отправлено."
  errors: 
    validation: "Исправьте ошибки, чтобы отправить напоминание пароля"
    email:
        required: "Электронная почта обязательно нужна"
        exists: "Нет пользователя с такой электронной почтой"
    passwords:
        user: "Нет пользователя с такой электронной почтой"
        throttled: "Слишком много попыток. Попробуйте немного позже"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Remind password"
  email: "Email"
  send: "Send me a link"
  link:
    sent: "Email with password reset link was sent to you"
  errors: 
    validation: "Please provide correct data to get a reminder link"
    email:
        required: "Email is required"
        exists: "User with this email doesn't exists"
    passwords:
        user: "User with this email doesn't exists"
        throttled: "Too many attempts. Please try later"
</i18n>
