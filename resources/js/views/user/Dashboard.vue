<template>
    <div>
        <h1 class="page-header">{{ $t('pageTitle') }}</h1>
        <form autocomplete="off" @submit.prevent="save" method="post">
            <div class="form-group" :class="{ 'has-error': errors.name && edit.name }">
                <label for="name">{{ $t('name') }}</label>
                <div class="flex items-center">
                    <input type="text" id="name" class="form-control flex-grow" placeholder="Ваше имя" v-model="user.name" required :disabled="!edit.name">
                    <a href="#" @click="toggleEditName()">
                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M6.3 12.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H7a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h6a1 1 0 0 1 0 2H4v14h14v-6z"/></svg>
                    </a>
                </div>
                <div class="error-description" v-for="error in errors.name" :class="!edit.name?'hidden':''">
                    {{ $t('errors.' + error) }}
                </div>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.email && edit.email }">
                <label for="email">{{ $t('email') }}</label>
                <div class="flex items-center">
                    <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required :disabled="!edit.email">
                    <a href="#" @click="toggleEditEmail()">
                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M6.3 12.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H7a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h6a1 1 0 0 1 0 2H4v14h14v-6z"/></svg>
                    </a>
                </div>
                <div class="error-description" v-for="error in errors.email" :class="!edit.email?'hidden':''">
                    {{ $t('errors.' + error) }}
                </div>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.old_password && edit.password }" v-if="edit.password">
                <label for="old_password">{{ $t('oldPassword') }}</label>
                <input type="password" id="old_password" class="form-control" v-model="old_password" required>
                <div class="error-description" v-for="error in errors.old_password" :class="!edit.password?'hidden':''">
                    {{ $t('errors.' + error) }}
                </div>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.password && edit.password }">
                <label for="password">{{ $t('password') }}</label>
                <div class="flex items-center">
                    <input type="password" id="password" class="form-control flex-grow" v-model="password" required :disabled="!edit.password">
                    <a href="#" @click="toggleEditPassword()">
                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M6.3 12.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H7a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h6a1 1 0 0 1 0 2H4v14h14v-6z"/></svg>
                    </a>
                </div>
                <div class="error-description" v-for="error in errors.password" :class="!edit.password?'hidden':''">
                    {{ $t('errors.' + error) }}
                </div>
            </div>
            <div class="form-group" v-if="edit.password">
                <label for="password_confirmation">{{ $t('passwordConfirmation') }}</label>
                <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation" required>
            </div>
            <div class="text-center" v-if="edit.name || edit.email || edit.password">
                <button type="submit" class="button" :disabled="wait">{{ $t('save') }}</button>
            </div>
        </form>
    </div>
</template>
<script>
  import { mapState, mapGetters } from 'vuex'
  export default {
    data() {
      return {
        edit: { name: false, email: false, password: false },
        hasError: false,
        message: '',
        wait: false,
        name: '',
        email: '',
        password: '12345678',
        password_confirmation: '',
        old_password: '',
      }
    },
    computed: {
      errors() {
        return {}
      },
      ...mapGetters('errors', {
        errorsHappened: 'happened'
      }),
      ...mapState('auth', {
        user: state => state.user
      }),
    },
    mounted() {
      this.name = this.user.name
      this.email = this.user.email
    },
    methods: {
      toggleEditName() {
        if (this.edit.name) {
            this.edit.name = false;
            this.name = this.$auth.user().name;
            this.errors.name = undefined;
            this.checkHasError();
        } else {
            this.edit.name = true;
        }
      },
      toggleEditEmail() {
        if (this.edit.email) {
            this.edit.email = false;
            this.email = this.$auth.user().email;
            this.errors.email = undefined;
            this.checkHasError();
        } else {
            this.edit.email = true;
        }
      },
      toggleEditPassword() {
        if (this.edit.password) {
            this.edit.password = false;
            this.password = '12345678';
            this.old_password = '';
            this.password_confirmation = '';
            this.errors.password = undefined;
            this.errors.old_password = undefined;
            this.checkHasError();
        } else {
            this.edit.password = true;
            this.password = '';
        }
      },
      checkHasError() {
        if (!this.errors.name && !this.errors.password && !this.errors.old_password && !this.errors.email && this.hasError && this.message) {
            this.hasError = false;
            this.message = '';
        }
      },
      save() {
        this.hasError = false;
        this.message = '';
        this.errors = {};
        this.wait = true;
        if (this.edit.name)
            this.saveName();
        if (this.edit.email)
            this.saveEmail();
        if (this.edit.password)
            this.savePassword();
      },
      saveName() {
        this.$http.post('/user/name', {
            name: this.name, 
        })
        .then(response => {
          this.message += ' ' + this.$t('messages.' + response.data.message);
          this.wait = false;
          this.edit.name = false;
        })
        .catch(this.errorCatcher);
      },
      saveEmail() {
        this.$http.post('/user/email', {
            email: this.email, 
        })
        .then(response => {
          this.message += ' ' + this.$t('messages.' + response.data.message);
          this.wait = false;
          this.edit.email = false;
          if (response.data.needVerification) {
            this.$auth.user().email_verified_at = '';
            this.$router.push({name: 'verify'});
          }
        })
        .catch(this.errorCatcher);
      },
      savePassword() {
        this.$http.post('/user/password', {
            old_password: this.old_password, 
            password: this.password, 
            password_confirmation: this.password_confirmation, 
        })
        .then(response => {
          this.message += ' ' + this.$t('messages.' + response.data.message);
          this.wait = false;
          this.edit.password = false;
        })
        .catch(this.errorCatcher);
      },
      errorCatcher(error) {
          this.hasError = true
          this.errors = Object.assign({}, this.errors, error.response.data.errors || {})
          this.wait = false;
          if (error.response.status == 422) 
            this.message = this.$t('errors.validation');
          else
            this.message = this.$t('errors.connection');
      }
    }
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Личный кабинет"
  whatsup: "Как дела, {name}?"
  name: "Имя"
  namePlaceholder: "Ваше имя"
  email: "Электронная почта"
  password: "Пароль"
  passwordConfirmation: "Подтверждение пароля"
  oldPassword: "Старый пароль"
  save: "Сохранить"
  messages:
    nameSaved: "Изменения имени сохранены."
    emailSaved: "Изменения электронной почты сохранены."
    passwordSaved: "Новый пароль сохранен."
  errors:
    validation: "Исправьте ошибки, чтобы сохранить изменения."
    connection: "Невозможно сохранить данные сейчас, попробуйте позже."
    name:
        required: "Имя обязательно нужно"
        string: "В имени нельзя писать загадочные символы"
        min: "Имя должно быть хотя бы из трех букв"
    email:
        required: "Элетронная почта обезательно нужна"
        email: "Электронная почта должна быть настоящей"
        unique: "Такой адрес элекронной почты уже используется"
    password:
        required: "Пароль обязательно нужен"
        min: "Пароль должен быть не меньше 8 символов"
        confirmed: "Пароль и подтверждение пароля должны совпадать"
    old_password:
        required: "Старый пароль обязательно нужен"
        password: "Старый пароль не правильный"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Your profile"
  whatsup: "Whats up, {name}?"
  name: "Name"
  namePlaceholder: "Your name"
  email: "Email"
  password: "Password"
  passwordConfirmation: "Confirm password"
  oldPassword: "Old password"
  save: "Save"
  messages:
    nameSaved: "Name changes saved."
    emailSaved: "Email changes saved."
    passwordSaved: "New password saved."
  errors:
    validation: "Provide correct data to save changes."
    connection: "Can't save right now, please try agein later."
    name:
        required: "Name is required"
        string: "Please use only letters and numbers"
        min: "Name must be at least 3 letters"
    email:
        required: "Email is required"
        email: "Please provide correct email"
        unique: "Somebody already registered with this email."
    password:
        required: "Password is required"
        min: "Password must be at least 8 symbols"
        confirmed: "Password and confirmation must be the same"
    old_password:
        required: "Old password is required"
        password: "Old password is incorrect"
</i18n>
