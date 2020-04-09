<template>
    <div>
        <h1 class="page-header">{{ $t('pageTitle') }}</h1>
        <div :class="hasError?'error':'info'" v-if="hasError || message">
            <p>{{ message }}</p>
        </div>
        <form autocomplete="off" @submit.prevent="reset" method="post">
            <div class="form-group" :class="{ 'has-error': errors.password }">
                <label for="password">{{ $t('password') }}</label>
                <input type="password" id="password" class="form-control" v-model="password" required>
                <div class="error-description" v-if="errors.password" v-for="error in errors.password">
                    {{ $t('errors.'+error) }}
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirmation">{{ $t('passwordConfirmation') }}</label>
                <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation" required>
            </div>
            <div class="text-center">
                <button type="submit" class="button" :disabled="!goodToken||wait">{{ $t('save') }}</button>
            </div>
        </form>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        password: null,
        password_confirmation: null,
        hasError: false,
        message: undefined,
        errors: {},
        goodToken: false,
        wait: false,
      }
    },
    mounted() {
      this.$http.post('/auth/checkToken',
        { token: this.$route.query.token, email: this.$route.query.email }
      ).then(response => {
        this.goodToken = true;
      }).catch(error => {
        this.hasError = true;
        this.message = this.$t(error.response.data.message);
      })
    },
    methods: {
      reset() {
        this.hasError = false;
        this.message = undefined;
        this.errors = {};
        this.wait = true;
        this.$http.post('/auth/newPassword',
          { 
            token: this.$route.query.token, 
            email: this.$route.query.email, 
            password: this.password, 
            password_confirmation: this.password_confirmation, 
          }
        )
        .then(response => {
          this.message = this.$t(response.data.message);
        }).catch(error => {
          this.hasError = true
          this.errors = error.response.data.errors || {}
          this.wait = false;
          if (error.response.status == 422) {
            if (this.errors.token || this.errors.email) 
              this.message = this.$t(this.errors.token[0]) || this.$t(this.errors.email[0]);
            else
              this.message = this.$t('errors.validation');
          } else
            this.message = this.$t(error.response.data.message);
        });
      }
    }
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Установите новый пароль"
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
