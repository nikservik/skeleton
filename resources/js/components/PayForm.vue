<template>
  <div class="px-20 max-w-sm mx-auto">
    <div class="pay-form">
      <form id="cardform">
        <input v-mask="'#### #### #### #### ###'" class="card-number field" 
          :class="{ 
            'border border-prime-500' : hasError('cardNumber'), 
          }"
          autocomplete="cc-number" 
          type="tel" data-cp="cardNumber" 
          :placeholder="$t('card.number')" />

        <div class="line-2">
          <div class="expire" :class="{
              'border border-prime-500': hasError('expDateMonth') || hasError('expDateYear'), 
            }">
            <input v-mask="'##'" class="expire-month" 
              autocomplete="cc-exp-month" 
              type="tel" data-cp="expDateMonth" 
              :placeholder="$t('card.expire-month')" />

            <span class="divider">/</span>

            <input v-mask="'##'" class="expire-year" 
              autocomplete="cc-exp-year" 
              type="tel" data-cp="expDateYear" 
              :placeholder="$t('card.expire-year')" />
          </div>
          <div class="cvv">
            <span class="description">{{ $t('card.cvv') }}</span>
            <input v-mask="'###'" class="number field" :class="{ 
                'border border-prime-500': hasError('cvv'), 
              }"
              autocomplete="off" type="password" data-cp="cvv" 
              :placeholder="$t('card.cvv-placeholder')" />
          </div>
        </div>
        <input class="card-holder field" :class="{ 
            'border border-prime-500': hasError('name'), 
          }"
          autocomplete="cc-name" type="text" data-cp="name" 
          :placeholder="$t('card.name')" v-model="cardholder" />
      </form>
    </div>
    <div class="pay-form-error" v-if="errorHappened">
      {{ errorMessage }}
    </div>
    <SecureFrame ref="secureframe" />
  </div>
</template>

<script>
import { mask } from 'vue-the-mask'
import SecureFrame from '@/components/SecureFrame'
import { mapState, mapGetters } from 'vuex'

export default {
  props: [ 'tariff' ],
  components: { SecureFrame },
  directives: { mask },
  data() {
    return {
      cpLoaded: false,
      cardholder: '',
      checkout: undefined,
      crypt: '',
    }
  },
  methods: {
      loadCP() {
        this.$loadScript('https://widget.cloudpayments.ru/bundles/checkout')
          .then(() => { 
            this.cpLoaded = true 
            this.$emit('loaded')
          })
      },
      initCheckout() {
        this.crypt = ''
        if(! this.checkout)
          this.checkout = new cp.Checkout(
            process.env.MIX_CLOUDPAYMENTS_PUBLICID,
            document.getElementById("cardform")
          )
      },
      createCrypt() {
        if (! this.cpLoaded) return

        this.initCheckout()
        this.$store.dispatch('errors/clear')

        var result = this.checkout.createCryptogramPacket();
        if (result.success) 
          this.crypt = result.packet
        else 
          this.$store.dispatch('errors/set', result.messages)
      },
      open3ds(data, message) {
        this.$refs.secureframe.open(this.user.id, this.tariff.id, 
          data.TransactionId, data.AcsUrl, data.PaReq, message)
      },
      pay() {
        this.createCrypt()
        if (! this.crypt) return

        this.$store.dispatch('subscription/payByCrypt', {
            tariff: this.tariff.id,
            name: this.cardholder,
            crypt: this.crypt 
          })
          .then(() => {
            if (this.for3ds)
              return this.open3ds(this.for3ds, this.$t('paymentSuccessful'))
            if (! this.errorHappened) {
              this.$store.dispatch('message/show', this.$t('paymentSuccessful'))
              return this.$router.push({ name: 'profile' })
            }
          })
      },
      authorize() {
        this.createCrypt()
        if (! this.crypt) return

        this.$store.dispatch('subscription/authorizeCard', {
            name: this.cardholder,
            crypt: this.crypt 
          })
          .then(() => {
            if (this.for3ds)
              return this.open3ds(this.for3ds, this.$t('authorizationSuccessful'))
            if (! this.errorHappened) {
              this.$store.dispatch('message/show', this.$t('authorizationSuccessful'))
              return this.$router.push({ name: 'profile' })
            }
          })
      },
  },
  mounted() {
    this.loadCP()
  },
  computed: {
    errorMessage() {
      if (this.hasError('response'))
        return this.$t(this.getError('response'))
      if (this.hasError('payment'))
        return this.$t(this.getError('payment'))
      return this.$t('errors.form')
    },
    ...mapState('subscription', {
        for3ds: state => state.for3ds
    }),
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
  paymentSuccessful: "Поздравляем! Подписка оплачена. Все возможности тарифного плана уже включены."
  authorizationSuccessful: "Новая платежная карта сохранена. Следующие автоматические платежи будут списываться с нее."
  errors: 
    form: "Проверьте все данные еще раз"
    failed: "Попытка не удалась, попробуйте позже"
    insufficient-funds: "Недостаточно средств на карте"
    incorrect-cvv: "Неверно указан код CVV"
    restricted-card: "Платежи для этой карты запрещены. Попробуйте другую карту"
    incorrect-card: "Проверьте правильность введенных данных карты или воспользуйтесь другой картой"
    contact-issuer: "Свяжитесь с вашим банком или воспользуйтесь другой картой"
    try-later: "Повторите попытку позже"
    try-later-or-use-other: "Повторите попытку позже или воспользуйтесь другой картой"
    use-other: "Воспользуйтесь другой картой"    
  card:
    name: "Владелец карты"
    number: "Номер карты"
    expire-month: "ММ"
    expire-year: "ГГ"
    cvv: "Три цифры на обороте"
    cvv-placeholder: "CVC"
</i18n>
<i18n locale="en" lang="yaml">
  paymentSuccessful: "Congratulations! Subscription is activated. You can enjoy all features."
  authorizationSuccessful: "New credit card was saved. It will be charged with next autopayments."
  errors: 
    form: "Please check entered data"
    failed: "Failed for unknown reason, please try later"
    insufficient-funds: "Insufficient funds"
    incorrect-cvv: "Incorrect CVV"
    restricted-card: "Restricted card, please use another one"
    incorrect-card: "Check entered data or use other card"
    contact-issuer: "Contact your bank or use other card"
    try-later: "Transaction failed. Try again later"
    try-later-or-use-other: "Transaction failed. Try again later or use other card"
    use-other: "Use other card"    
  card:
    name: "Cardholder"
    number: "Card Number"
    expire-month: "MM"
    expire-year: "YY"
    cvv: "Three digits on back"
    cvv-placeholder: "CVC"
</i18n>