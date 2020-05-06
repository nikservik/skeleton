<template>
    <div>
        <div class="block with-errors" >
            <div class="title">
                <IconEmail height="20" classes="settings-icon vertical-center" />
                <div>{{ $t('email') }}</div>
                <div class="change" @click="edit" v-if="! editing">{{ $t('change') }}</div>
            </div>
            <div class="value" v-if="! editing" @click="edit">{{ user.email }}</div>
            <div class="bottom">
                <div class="input-item text-right" :class="{ error : hasError('email') }" v-if="editing">
                    <input type="email" id="edit-email" 
                        :value="value" 
                        @focusout="unedit">
                </div>
                <div class="error-text" v-if="hasError('email')">
                    {{ $t('errors.' + getError('email')) }}
                </div>
                <div class="warning-text" v-if="editing && !hasError('email')">
                    {{ $t('warning') }}
                </div>
                <SaveButton :editing="editing" @save="save" />
            </div>
        </div>
    </div>
</template>

<script>
import SaveButton from '@/components/visual/SaveButton'
import IconEmail from '@/components/visual/icons/IconEmail'
import { mapState, mapGetters, mapActions } from 'vuex'

export default {
    components: { SaveButton, IconEmail },
    data() {
        return {
            editing: false,
            value: '',
        }
    },
    mounted() {
        this.value = this.user.email
    },
    methods: {
        edit() {
            this.editing = true
            setTimeout(() => { document.getElementById('edit-email').focus() }, 10)
        },
        unedit(event) {
            this.value = event.target.value
            setTimeout(() => { this.editing = false }, 10)
        },
        save() {
            if (this.value == this.user.email)
                return
            this.$store.dispatch('errors/clear')
            this.$store.dispatch('auth/saveEmail', this.value)
                .then(() => {
                    if (this.hasError('email')) 
                        this.edit()
                    else {
                        this.$store.dispatch('message/show' , this.$t('emailSaved'))
                        if (this.$store.getters['auth/needVerification'])
                            this.$router.push({ name: 'verify' })
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
  email: "Электронная почта"
  warning: "Нужно будет подтвердить после изменения"
  emailSaved: "Новая электронная почта сохранена. Подвердите ее с помощью ссылки в письме."
  change: "Изменить"
  errors:
    email:
        required: "Элетронная почта обезательно нужна"
        email: "Электронная почта должна быть настоящей"
        unique: "Такой адрес элекронной почты уже используется"
</i18n>

<i18n locale="en" lang="yaml">
  email: "Email"
  warning: "Verification will be required after change"
  emailSaved: "New email was saved. Please verify it by link in email."
  change: "Change"
  errors:
    email:
        required: "Email is required"
        email: "Please provide correct email"
        unique: "Somebody already registered with this email"
</i18n>
