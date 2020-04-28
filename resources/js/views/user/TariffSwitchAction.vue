<template>
  <div>
    <div class="text-sm text-red-600 text-center" v-if="hasError('failed')">
      {{ $t('errors.failed') }}
    </div>
    
    <PayForm ref="payform" 
      :tariff="to"
      v-if="nextAction == 'pay'"
      v-on:loaded="cpLoaded = true"
       />

    <div class="button-holder">
      <button id="action" 
        @click="doNextAction" 
        :disabled="nextAction == 'pay' && ! cpLoaded" 
        :class="{
          'bg-red-600 hover:bg-red-700' : nextAction == 'cancel',
          'bg-blue-500 hover:bg-blue-700' : nextAction == 'activate' || nextAction == 'pay'
        }">
        {{ $t('button.' + nextAction, { amount: price + ' ' + $t('currency.' + to.currency)}) }}
      </button>
    </div>
  </div>
</template>

<script>
import PayForm from '@/components/PayForm'
import { mapState, mapGetters } from 'vuex'

  export default {
    props: [ 'from', 'to' ],
    components: { PayForm },
    data() {
      return {
        cpLoaded: false,
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
    mounted() {
      document.getElementById('action').scrollIntoView(true)
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
    },
  }
</script>

<i18n locale="ru" lang="yaml">
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
  button:
    activate: "Activate"
    pay: "Pay {amount}"
    cancel: "Cancel"
    active: "Active"
  currency:
      RUB: "RUB"
</i18n>
