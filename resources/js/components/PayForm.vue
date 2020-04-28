<template>
  <div class="px-20">
    <div class="pay-form">
      <form id="cardform">
        <input v-mask="'#### #### #### #### ###'" class="card-number field" 
          :class="{ 
            'border-gray-300' : ! hasError('cardNumber'), 
            'border-red-400' : hasError('cardNumber'), 
          }"
          autocomplete="cc-number" 
          type="tel" data-cp="cardNumber" 
          :placeholder="$t('card.number')" />

        <div class="line-2">
          <div class="expire" :class="{
              'border-gray-300': !hasError('expDateMonth') && !hasError('expDateYear'), 
              'border-red-400': hasError('expDateMonth') || hasError('expDateYear'), 
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
                'border-gray-300': !hasError('cvv'), 
                'border-red-400': hasError('cvv'), 
              }"
              autocomplete="off" type="password" data-cp="cvv" 
              :placeholder="$t('card.cvv-placeholder')" />
          </div>
        </div>
        <input class="card-holder field" :class="{ 
            'border-gray-300': ! hasError('name'), 
            'border-red-400': hasError('name'), 
          }"
          autocomplete="cc-name" type="tel" data-cp="name" 
          :placeholder="$t('card.name')" v-model="cardholder" />
      </form>
    </div>
    <div class="pay-form-error" v-if="errorHappened">
      {{ hasError('response') ? $t(getError('response')) : $t('errors.form')  }}
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
            'pk_4ac2f7a43a9f5f3167e2396048810', 
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
      open3ds(data) {
        this.$refs.secureframe.open(this.user.id, this.tariff.id, 
          data.TransactionId, data.AcsUrl, data.PaReq)
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
              return this.open3ds(this.for3ds)
            if (! this.errorHappened)
              return this.$router.push({ name: 'profile' })
          })
      },
  },
  mounted() {
    this.loadCP()
  },
  computed: {
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
  errors: 
    form: "Проверьте все данные еще раз"
  card:
    name: "Владелец карты"
    number: "Номер карты"
    expire-month: "ММ"
    expire-year: "ГГ"
    cvv: "Три цифры на обороте"
    cvv-placeholder: "CVC"
</i18n>
<i18n locale="en" lang="yaml">
</i18n>