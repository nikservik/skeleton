<template>
    <div>
        <div class="block with-errors" >
            <div class="title">
                <IconProfile height="20" classes="settings-icon vertical-center" />
                <div>{{ $t('name') }}</div>
                <div class="change" @click="edit" v-if="! editing">{{ $t('change') }}</div>
            </div>
            <div class="value" v-if="! editing" @click="edit">{{ user.name }}</div>
            <div class="bottom">
                <div class="input-item text-right" :class="{ error : hasError('name') }" v-if="editing">
                    <input type="text" id="edit-name" 
                        :value="value" 
                        @focusout="unedit">
                </div>
                <div class="error-text" v-if="hasError('name')">
                    {{ $t('errors.' + getError('name')) }}
                </div>
                <SaveButton :editing="editing" @save="save" />
            </div>
        </div>
    </div>
</template>

<script>
import SaveButton from '@/components/visual/SaveButton'
import IconProfile from '@/components/visual/icons/IconProfile'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { SaveButton, IconProfile },
    data() {
        return {
            editing: false,
            value: '',
        }
    },
    mounted() {
        this.value = this.user.name
    },
    methods: {
        edit() {
            this.editing = true
            setTimeout(() => { document.getElementById('edit-name').focus() }, 10)
        },
        unedit(event) {
            this.value = event.target.value
            setTimeout(() => {this.editing = false}, 10)
        },
        save() {
            if (this.value == this.user.name)
                return
            this.$store.dispatch('errors/clear')
            this.$store.dispatch('auth/saveName', this.value)
                .then(() => {
                    if (this.hasError('name')) {
                        this.editable = true
                        document.getElementById('edit-name').focus()
                    } else
                        this.$store.dispatch('message/show' , this.$t('nameSaved'))

                })
        },
    },
    computed: {
        bindedValue() {
            return this.editing ? this.value : this.user.name
        },
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
    name: "Имя"
    nameSaved: "Имя сохранено"
    change: "Изменить"
    errors:
        name:
            required: "Имя обязательно нужно"
            string: "В имени нельзя писать загадочные символы"
            min: "Имя должно быть хотя бы из трех букв"
</i18n>

<i18n locale="en" lang="yaml">
    name: "Name"
    nameSaved: "Name was saved"
    change: "Change"
    errors:
        name:
            required: "Name is required"
            string: "Please use only letters and numbers"
            min: "Name must be at least 3 letters"
</i18n>
