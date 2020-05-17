<template>
    <Page type="no-helpers">
        <PageHeader back="home">
            {{ $t('pageTitle') }}
        </PageHeader>
        <div class="page-icon">
            <IconProfile classes="mx-auto" height="75" />
        </div>
        <template v-slot:bottom>
            <form @submit.prevent="register" class="form">
                <div class="group" :class="{ 'has-error' : hasError('name') }">
                    <label for="name">{{ $t('name') }}</label>
                    <input type="text" placeholder="Ваше имя" v-model="name" required>
                    <div class="error-description" v-if="hasError('name')" v-for="error in errors.name">
                        {{ $t('errors.'+error) }}
                    </div>
                </div>
                <div class="group" :class="{ 'has-error' : hasError('email') }">
                    <label for="email">{{ $t('email') }}</label>
                    <input type="email" placeholder="user@example.com" v-model="email" required>
                    <div class="error-description" v-if="hasError('email')" v-for="error in errors.email">
                        {{ $t('errors.'+error) }}
                    </div>
                </div>
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

                <div class="error" v-if="errorsHappened">
                    {{ hasError('connection') ? $t('errors.connection') : $t('errors.validation') }}
                </div>

                <BigButton :disable="disable" @clicked="register">
                  {{ $t('register') }}
                </BigButton>
            </form>
        </template>
    </Page>
</template>
<script>
import IconProfile from '@/components/visual/icons/IconProfile'
import Page from '@/components/visual/Page'
import BigButton from '@/components/visual/BigButton'
import PageHeader from '@/components/visual/PageHeader'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { IconProfile, Page, PageHeader, BigButton },
    data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      }
    },
    methods: {
      register() {
        this.$store.dispatch('errors/clear')
        this.$store.dispatch('auth/register', {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation
          })
          .then(() => {
            if (! this.errorsHappened) {
              this.$store.dispatch('message/show', this.$t('success'))
              this.$router.push({ name: 'login' })
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
  success: "Поздравляем с регистрацией! Мы отправили вам письмо для подтверждения электронной почты. Подтвердите ее, перейдя по ссылке в письме, чтобы пользоваться всеми возможностями программы."
  errors:
    validation: "Проверьте все данные еще раз"
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
  success: "Congratulations! You've been registered. We sent you a mail with confirmation link. Please comfirm your email by clickin a link to use all the features."
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
