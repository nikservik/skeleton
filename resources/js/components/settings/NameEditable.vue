<template>
    <div>
        <SaveButton :editing="editing" @save="save" />
        <div class="input-name" :class="{ error : hasError('name') }">
            <input type="text" id="edit-name" 
                :value="bindedValue" 
                @focus="edit"
                @focusout="unedit">
            <div class="error-text" v-if="editing && hasError('name')">
                {{ $t('errors.' + getError('name')) }}
            </div>
        </div>
    </div>
</template>

<script>
import SaveButton from '@/components/visual/SaveButton'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { SaveButton },
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
                    }
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
    errors:
        name:
            required: "Имя обязательно нужно"
            string: "В имени нельзя писать загадочные символы"
            min: "Имя должно быть хотя бы из трех букв"
</i18n>

<i18n locale="en" lang="yaml">
    errors:
        name:
            required: "Name is required"
            string: "Please use only letters and numbers"
            min: "Name must be at least 3 letters"
</i18n>
