<template>
    <div>
        <h1 class="page-header">{{ $t('pageTitle') }}</h1>

        <div class="error" v-if="hasError">
            <p v-if="error == 'validation_error'">{{ $t('errors.validation') }}</p>
            <p v-else>{{ $t('errors.connection') }}</p>
        </div>
        <form autocomplete="off" @submit.prevent="register" method="post">
            <div class="form-group" :class="{ 'has-error': errors.name }">
                <label for="name">{{ $t('name') }}</label>
                <input type="text" id="name" class="form-control" placeholder="Ваше имя" v-model="name" required>
                <div class="error-description" v-if="errors.name" v-for="error in errors.name">
                    {{ $t('errors.'+error) }}
                </div>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.email }">
                <label for="email">{{ $t('email') }}</label>
                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                <div class="error-description" v-if="errors.email" v-for="error in errors.email">
                    {{ $t('errors.'+error) }}
                </div>
            </div>
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
                <button type="submit" class="button" :disabled="wait">{{ $t('register') }}</button>
            </div>
        </form>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        hasError: false,
        error: '',
        errors: {},
        wait: false,
      }
    },
    methods: {
      register() {
        this.wait = true;
        this.errors = {};
        var app = this
        this.$auth.register({
          data: {
            name: app.name,
            email: app.email,
            password: app.password,
            password_confirmation: app.password_confirmation
          },
          // autoLogin: true,
          success: function () {
            this.$router.push({ name: 'login', params: { successRegistrationRedirect: true } })
          },
          error: function (res) {
            app.hasError = true;
            app.wait = false;
            if (res.response.status == 422) 
                app.error = 'validation_error'
            app.errors = res.response.data.errors || {}
          }
        })
      }
    }
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Регистрация"
  name: "Имя"
  email: "Электронная почта"
  password: "Пароль"
  passwordConfirmation: "Подтверждение пароля"
  register: "Зарегистрироваться"
  errors:
    validation: "Проверьте правильность данных."
    connection: "Невозможно зарегистрироваться сейчас, попробуйте позже."
    name:
        required: "Имя обязательно нужно"
        string: "В имени нельзя писать загадочные символы"
        min: "Имя должно быть хотя бы из трех букв"
    email:
        required: "Элетронная почта обезательно нужна"
        email: "Электронная почта должна быть настоящей"
        unique: "С такой электронной почтой уже кто-то зарегистрировался. Если это вы, то вы можете восстановить пароль на странице входа"
    password:
        required: "Пароль обязательно нужен"
        min: "Пароль должен быть не меньше 8 символов"
        confirmed: "Пароль и подтверждение пароля должны совпадать"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Registration"
  name: "Name"
  email: "Email"
  password: "Password"
  passwordConfirmation: "Confirm password"
  register: "Register"
  errors:
    validation: "Please provide correct data"
    connection: "Can't register right now, please try later"
    name:
        required: "Name is required"
        string: "Please use only letters and numbers"
        min: "Name must be at least 3 letters"
    email:
        required: "Email is required"
        email: "Please provide correct email"
        unique: "Somebody already registered with this mail. You can reset password on Login page if that were you."
    password:
        required: "Password is required"
        min: "Password must be at least 8 symbols"
        confirmed: "Password and confirmation must be the same"
</i18n>
