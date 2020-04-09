<template>
    <div>
        <h1 class="page-header">{{ $t('pageTitle') }}</h1>
        <div :class="hasError?'error':'info'" v-if="hasError || message">
            <p>{{ message }}</p>
        </div>
        <form autocomplete="off" @submit.prevent="remind" method="post">
            <div class="form-group">
                <label for="email">{{ $t('email') }}</label>
                <input type="email" id="email" placeholder="user@example.com" v-model="email" required>
                <div class="error-description" v-if="errors.email" v-for="error in errors.email">
                    {{ $t('errors.'+error) }}
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="button" :disabled="wait">{{ $t('send') }}</button>
            </div>
        </form>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        email: null,
        hasError: false,
        errors: {},
        message: undefined,
        wait: false,
      }
    },
    mounted() {
      //
    },
    methods: {
      remind() {
        this.hasError = false;
        this.errors = {};
        this.message = undefined;
        this.wait = true;
        this.$http.post('/auth/remind',
          { email: this.email }
        )
        .then(response => {
            this.hasError = (response.data.status == 'error');
            this.message = this.$t(response.data.message);
            this.wait = false;
        }).catch(error => {
            this.hasError = true;
            this.errors = error.response.data.errors || {};
            this.wait = false;
            if (error.response.status == 422) {
              this.message = this.$t('errors.validation');
            } else
              this.message = this.$t(error.response.data.message);
        });
      }
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
