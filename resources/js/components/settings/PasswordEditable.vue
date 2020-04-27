<template>
    <div>
        <SaveButton :editing="editing" @save="save" />
        <div class="block with-errors" >
            <div class="title">
                <IconLock height="20" classes="settings-icon vertical-center" />
                <div>{{ $t('password') }}</div>
            </div>
            <div v-if="! editing" @click="edit">********</div>
            <div class="bottom">
                <div class="input-item" :class="{ error : hasError('old_password') }" v-if="editing">
                    <label>{{ $t('oldPassword') }}</label>
                    <input type="password" id="old-password" autocomplete="off" 
                        v-model="old_password" 
                        @focusout="unedit">
                    <div class="error-text" :class="{ hidden : ! hasError('old_password') }">
                        {{ $t('errors.' + getError('old_password')) }}
                    </div>
                </div>
                <div class="input-item" :class="{ error : hasError('password') }" v-if="editing">
                    <label>{{ $t('newPassword') }}</label>
                    <input type="password" id="edit-password" autocomplete="off"
                        v-model="password" 
                        @focusout="unedit">
                    <div class="error-text" :class="{ hidden : ! hasError('password') }">
                        {{ $t('errors.' + getError('password')) }}
                    </div>
                    <label>{{ $t('passwordConfirmation') }}</label>
                    <input type="password" id="confirm-password" autocomplete="off"
                        v-model="password_confirmation" 
                        @focusout="unedit">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SaveButton from '@/components/visual/SaveButton'
import IconLock from '@/components/visual/icons/IconLock'
import { mapState, mapGetters, mapActions } from 'vuex'

export default {
    components: { SaveButton, IconLock },
    data() {
        return {
            editing: false,
            old_password: '',
            password: '',
            password_confirmation: '',
        }
    },
    mounted() {
        this.value = this.user.password
    },
    methods: {
        edit() {
            this.editing = true
            setTimeout(() => { document.getElementById('edit-password').focus() }, 10)
        },
        unedit(event) {
            setTimeout(() => {
                var active = document.activeElement.id
                if (active != 'edit-password' && active != 'confirm-password' 
                    && active != 'old-password')
                    setTimeout(() => { this.editing = false }, 10)
            }, 10)
        },
        save() {
            this.$store.dispatch('errors/clear')
            this.$store.dispatch('auth/savePassword', {
                    old_password: this.old_password,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                .then(() => {
                    if (this.hasError('password') || this.hasError('old_password')) 
                        this.edit()
                    else {
                        this.old_password = ''
                        this.password = ''
                        this.password_confirmation = ''
                    }
                })
        },
    },
    computed: {
        ...mapGetters('errors', {
            hasError: 'has',
            getError: 'getFirst',
        }),
        ...mapState('auth', {
            user: state => state.user
        }),
    }
}
</script>

<i18n locale="ru" lang="yaml">
  password: "Пароль"
  newPassword: "Новый пароль"
  passwordConfirmation: "Подтверждение пароля"
  oldPassword: "Старый пароль"
  errors:
    password:
        required: "Пароль обязательно нужен"
        min: "Пароль должен быть не меньше 8 символов"
        confirmed: "Пароль и подтверждение пароля должны совпадать"
    old_password:
        required: "Старый пароль обязательно нужен"
        password: "Старый пароль не правильный"
</i18n>

<i18n locale="en" lang="yaml">
  password: "Password"
  newPassword: "New password"
  passwordConfirmation: "Confirm password"
  oldPassword: "Old password"
  errors:
    password:
        required: "Password is required"
        min: "Password must be at least 8 symbols"
        confirmed: "Password and confirmation must be the same"
    old_password:
        required: "Old password is required"
        password: "Old password is incorrect"
</i18n>
