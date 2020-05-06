<template>
    <Page type="no-helpers">
        <PageHeader>
            {{ $t('pageTitle') }}
        </PageHeader>

        <div class="page-icon">
            <IconEmail classes="mx-auto" height="75" />
        </div>

        <template v-slot:bottom>
          <PageBlock v-if="errorsHappened">
            <div v-for="(name, error) in errors" class="text-prime-500"
              v-html="$t('errors.' + error)">
            </div>
          </PageBlock>
          <PageBlock v-if="! errorsHappened">
            {{ $t('messages.checkEmail') }}
            <p>{{ $t('messages.canResend') }}</p>
          </PageBlock>

          <BigButton :disable="disable" @clicked="resend" v-if="loggedIn">
            {{ $t('button') }}
          </BigButton>

          <PageBlock v-if="! loggedIn">
            {{ $t('messages.loginToSend') }}
          </PageBlock>
          <BigButton @clicked="$router.push({ name: 'login' })" v-if="! loggedIn">
            {{ $t('login') }}
          </BigButton>
        </template>
    </Page>
</template>

<script>
import IconEmail from '@/components/visual/icons/IconEmail'
import Page from '@/components/visual/Page'
import PageBlock from '@/components/visual/PageBlock'
import BigButton from '@/components/visual/BigButton'
import PageHeader from '@/components/visual/PageHeader'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { IconEmail, Page, PageHeader, PageBlock, BigButton },
    created() {
      if (this.loggedIn && ! this.needVerification)
        this.$router.push({ name: 'dashboard' })

      if (this.$route.params.user && this.$route.params.hash) {
        this.$store.dispatch('errors/clear')
        this.$store.dispatch('auth/verifyEmail', {
            user: this.$route.params.user,
            hash: this.$route.params.hash,
          })
          .then(() => {
            if (! this.errorsHappened) {
              this.$store.dispatch('message/show' , this.$t('messages.verified'))
              if (this.loggedIn)
                this.$store.dispatch('auth/fetch')
                  .then(() => {
                    this.$router.push({ name: 'dashboard' })
                  })
              else 
                this.$router.push({ name: 'login' })
            }
          })
      }
    },
    methods: {
      resend() {
        this.$store.dispatch('errors/clear')
        this.$store.dispatch('auth/resendVerification')
          .then(() => {
            if (! this.errorsHappened) 
              this.$store.dispatch('message/show' , this.$t('messages.newLinkSent'))
          })
      }
    },
    computed: {
        ...mapGetters('loading', [ 'disable' ]),
        ...mapGetters('auth', [ 'loggedIn', 'needVerification' ]),
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
        ...mapState('auth', {
            user: state => state.user
        }),
    }
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Подтверждение электронной почты"
  button: "Отправить еще раз"
  login: "Вход"
  messages:
    checkEmail: "Проверьте свою почту, мы уже отправили ссылку для подтверждения адреса."
    canResend: "Если письмо не нашлось, то ссылку для подтверждения можно отправить повторно."
    newLinkSent: "Ссылка для подтверждения электронной почты отправлена на адрес, указанный при регистрации."
    verified: "Ваша почта подтверждена! Теперь вы можете пользоваться программой."
    loginToSend: "Войдите, чтобы оптправить повторное проверочное письмо."
  errors:
    verification: "Не удалось подтвердить почту. Попробуйте позже."
    connection: "Не удалось отправить письмо для продтверждения"
    verify: "Это некорректная ссылка для подтверждения почты. Используйте ссылку из письма, которое вам пришло на адрес, указанный при регистрации. <p>Вы можете отправить новое письмо со ссылкой для подтверждения.</p>"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Email verification"
  button: "Send again"
  login: "Sign in"
  messages:
    checkEmail: "Check your mailbox, we sent you a verification email."
    canResend: "If you don't get a mail, you can resend it with button below."
    newLinkSent: "We sent a new verification link to email provided while register"
    verified: "Your email now is verified! Enjoy."
    loginToSend: "You need to sign in to resend verification email."
  errors:
    verification: "We can't verify your email right now. Please try again later."
    connection: "Can't send a verification email right now. Please try later"
    verify: "You tried to use incorrect link. Please use a link from email you entered in registration form. <p>You can send a new mail with verification link.</p>"
</i18n>
