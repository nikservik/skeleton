<template>
    <form @submit.prevent="send" class="form">
        <AutoScroll ref="scroll" />
        <div class="group" :class="{ 'has-error' : hasError('message') }">
            <textarea v-model="message" rows="3" required></textarea>
            <div v-if="hasError('message')">
              <div class="error-description" v-for="error in errors.message" :key="error">
                  {{ $t('errors.'+error) }}
              </div>
            </div>
            <div class="error-description" v-if="hasError('connection')">
                {{ $t('errors.connection') }}
            </div>
        </div>

        <BigButton :disable="disable" @clicked="send">
          {{ $t('send') }}
        </BigButton>
    </form>
</template>
<script>
import BigButton from '@/components/visual/BigButton'
import AutoScroll from '@/components/visual/AutoScroll'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { BigButton, AutoScroll },
    data() {
      return {
        message: '',
      }
    },
    methods: {
      send() {
        this.$store.dispatch('errors/clear')
        this.$store.dispatch('support/send', this.message)
          .then(() => {
            if (! this.errorsHappened)
              this.message = ''
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
  send: "Отправить"
  errors:
    connection: "Невозможно отправить сейчас, попробуйте позже."
    message:
        required: "Нельзя отправить пустое сообщение"
        string: "В сообщении нельзя писать загадочные символы"
        min: "Сообщение должно быть хотя бы из двух букв"
</i18n>

<i18n locale="en" lang="yaml">
  send: "Send"
  errors:
    connection: "Can't register right now, please try later"
    message:
        required: "Message is required"
        string: "Please use only letters and numbers"
        min: "Message must be at least 2 letters"
</i18n>
