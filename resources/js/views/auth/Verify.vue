<template>
    <div>
        <h1 class="page-header">{{ $t('pageTitle') }}</h1>
        <div :class="hasError?'error':'info'" v-if="hasError || message">
            <p>{{ message }}</p>
        </div>
        <div class="text">
          <p>{{ $t('messages.checkEmail') }}</p>
          <p>{{ $t('messages.canResend') }}</p>
          <p class="text-center">
            <button class="button" @click.prevent="resend" :disabled="wait">{{ $t('button') }}</button>
          </p>
        </div>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        email: null,
        hasError: false,
        message: undefined,
        wait: false,
      }
    },
    mounted() {
      if(this.$auth.user().email_verified_at)
        this.$router.push({name: 'dashboard'})
    },
    methods: {
      resend() {
        this.hasError = false;
        this.message = undefined;
        this.wait = true;
        this.$http.get('/email/resend')
        .then(response => {
            this.wait = false;
            this.message = this.$t('messages.newLinkSent');
        }).catch(error => {
            this.wait = false;
            this.hasError = true;
            this.message = this.$t('errors.connection');
        });
      }
    }
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Подтверждение электронной почты"
  button: "Отправить еще раз"
  messages:
    checkEmail: "Проверьте свою почту, мы уже отправили ссылку для подтверждения адреса."
    canResend: "Если письмо не нашлось, то ссылку для подтверждения можно отправить повторно."
    newLinkSent: "Ссылка для подтверждения элктронной почты отправлена на адрес, указанный при регистрации."
  errors:
    connection: "Не удалось отправить письмо для продтверждения"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Email verification"
  button: "Send again"
  messages:
    checkEmail: "Check your mailbox, we sent you a verification email."
    canResend: "If you don't get a mail, you can resend it with button below."
    newLinkSent: "We sent a new verification link to email provided while register"
  errors:
    connection: "Can't send a verification email right now. Please try later"
</i18n>
