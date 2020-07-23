<template>
  <div>
    <div class="text-sm text-prime-500 text-center" v-if="hasError('failed')">
      {{ $t('errors.failed') }}
    </div>
    
    <PayForm ref="payform" :tariff="to" v-if="nextAction == 'pay'"
      @loaded="cpLoaded = true" />

    <div class="mx-20 flex items-center justify-center" v-if="nextAction == 'pay'">
      <input type="checkbox" v-model="agree">
      <div class="ml-11" v-html="$t('agree', { url: '/oferta' })"></div>
    </div>

    <LoadingButton @clicked="doNextAction"
      :disable="disable || nextAction == 'pay' && (! cpLoaded || ! agree)">
      {{ $t('button.' + nextAction, { amount: price + ' ' + $t('currency.' + to.currency)}) }}
    </LoadingButton>
  </div>
</template>

<script>
import PayForm from '@/components/PayForm'
import LoadingButton from '@/components/visual/LoadingButton'
import { mapState, mapGetters } from 'vuex'

  export default {
    props: [ 'from', 'to' ],
    components: { PayForm, LoadingButton },
    data() {
      return {
        cpLoaded: false,
        agree: false,
      }
    },
    methods: {
      isFree(tariff) { return tariff.price == 0 },
      isPaid(tariff) { return tariff.price > 0 },
      isTrial(tariff) { return tariff.price == 0 && ! tariff.prolongable && tariff.period != 'endless'},
      doNextAction() {
        if (this.nextAction == 'cancel')
          return this.cancel()
        if (this.nextAction == 'activate')
          return this.activateFree()
        if (this.nextAction == 'pay')
          return this.$refs.payform.pay()
      },
      activateFree() {
        this.$store.dispatch('subscription/activateTariff', this.to.id)
          .then(() => {
            if (! this.errorHappened)
              this.$router.push({ name: 'profile' })
          })
      },
      cancel() {
        this.$store.dispatch('subscription/cancel')
          .then(() => {
            if (! this.errorHappened)
              this.$router.push({ name: 'profile' })
          })
      },
    },
    computed: {
        nextAction() {
          if (this.isPaid(this.to))
            return 'pay'
          if (this.isFree(this.to) && (this.isPaid(this.from) || this.isTrial(this.from)))
            return 'cancel'
          return 'activate'
        },
        price() {
          // TODO: добавить пересчет для paid-to-paid
          return this.to.price
        },
        ...mapState('auth', {
            user: state => state.user
        }),
        ...mapGetters('errors', {
            errorHappened: 'happened',
            hasError: 'has',
            getError: 'getFirst',
        }),
        ...mapGetters('loading', {
            disable: 'disable',
        }),
    },
  }
</script>

<i18n locale="ru" lang="yaml">
  agree: "Соглашаюсь с условиями <a href='{url}'>оферты</a>"
  button:
    activate: "Включить"
    pay: "Оплатить {amount}"
    cancel: "Отменить"
  currency:
      RUB: "рублей"
  errors:
    failed: "Не получилось активировать. Попробуйте позже."
</i18n>

<i18n locale="en" lang="yaml">
  agree: "Agree with <a href='{url}'>politics</a>"
  button:
    activate: "Activate"
    pay: "Pay {amount}"
    cancel: "Cancel"
    active: "Active"
  currency:
      RUB: "RUB"
</i18n>
