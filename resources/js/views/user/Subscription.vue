<template>
    <div>
        <h1 class="page-header">{{ $t('pageTitle') }}</h1>

        <div class="mx-10 my-4 border border-gray-500 rounded-lg p-3" 
          :class="{'bg-blue-100': isActive(tariff)}"
          v-if="tariff.visible || !tariff.visible && isActive(tariff)"
          v-for="(tariff, index) in tariffs">
          <div class="p-2 float-right">
            <button class="button small" disabled="" 
              v-if="isActive(tariff) && !isPaid(tariff)">
              {{ $t('button.active') }}</button>
            <button class="button small" @click="activateFree(tariff)" 
              v-if="!isActive(tariff) && isFree(tariff) && !hasPaid()">
              {{ $t('button.activate') }}</button>
            <button class="button small" @click="cancel(tariff)" 
              v-if="isActive(tariff) && isPaid(tariff)">
              {{ $t('button.cancel') }}</button>
            <button class="button small" @click="pay(tariff)" 
              v-if="!isActive(tariff) && isPaid(tariff)" :disabled="!cpLoaded">
              {{ $t('button.pay') }}</button>
          </div>
          <h3 class="font-bold text-lg mb-4">{{ $t('name'+index) }}</h3>
          {{ $t('type.'+tariff.type) }} <br>
          {{ (isTrial(tariff) && isActive(tariff)) ? 
            $t('expire', { date: expire(tariff) }) : '' }}
          {{ (tariff.price) ? tariff.price + ' ' + $t('currency.'+tariff.currency) + 
            ' / ' + $t('periods.'+tariff.period) : '' }}
          <h4 class="text-lg my-4">{{ $t('features.title') }}</h4>
          <span class="block" v-for="feature in tariff.features">
            {{ $t('features.'+feature) }}
          </span>
        </div>
    </div>
</template>
<script>
import LocaleMixin from '@/components/LocaleMixin'

  export default {
    mixins: [LocaleMixin],
    data() {
      return {
        tariffs: [],
        cpLoaded: false,
      }
    },
    methods: {
      isActive(tariff) {
        return tariff.id == this.$auth.user().subscription.tariff_id
      },
      isFree(tariff) {
        return tariff.price == 0
      },
      isTrial(tariff) {
        return tariff.price == 0 && ! tariff.prolongable && tariff.period != 'endless'
      },
      isPaid(tariff) {
        return tariff.price > 0 || tariff.visible == false
      },
      hasPaid() {
        return this.$auth.user().subscription.price > 0 
          || this.tariffs.find((tariff) => {
            return tariff.visible == false && tariff.id == this.$auth.user().subscription.tariff_id
          })
      },
      activateFree(tariff) {
        this.$http.post('/subscriptions', { tariff: tariff.id})
        .then(response => {
          this.$root.$auth.user().subscription = response.data.data.subscription
        })
      },
      cancel() {
        this.$http.post('/subscriptions/cancel')
        .then(response => {
          this.$root.$auth.user().subscription = response.data.data.subscription
        })
      },
      expire(tariff) {
        if (this.isTrial(tariff) && this.isActive(tariff)) 
          return this.$d(new Date(this.$auth.user().subscription.next_transaction_date), 'short')
        else
          return ''
      },
      loadCP() {
        this.$loadScript('https://widget.cloudpayments.ru/bundles/cloudpayments')
          .then(() => { this.cpLoaded = true })
      },
      successPayment(options) {
          console.log('success')
          console.log(options)
          location.reload()
      },
      failPayment(reason, options) {
          console.log('fail')
          console.log(reason)
          console.log(options)
      },
      pay(tariff) {
        var widget = new cp.CloudPayments();
        widget.charge({ 
          publicId: 'pk_4ac2f7a43a9f5f3167e2396048810',  
          description: 'Подписка', 
          amount: tariff.price,
          currency: tariff.currency, 
          accountId: this.$auth.user().id,
          data: {
              tariff_id: tariff.id,
              activation: true
          },
          skin: "mini",
        }, this.successPayment, this.failPayment);
      },
    },
    mounted() {
        this.$http.get('/subscriptions')
        .then(response => {
          this.tariffs = response.data.data.subscriptions;
          this.tariffs.forEach((tariff, index) => {
            this.addToLocale('name'+index, tariff.name)
          })
          for (let [feature, translations] of Object.entries(response.data.data.features))
            this.addToLocale('features.'+feature, translations)
          for (let [period, translations] of Object.entries(response.data.data.periods))
            this.addToLocale('periods.'+period, translations)
        })
        this.loadCP()
    },
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Мой тариф"
  features: 
    title: "Возможности"
  type:
    free: "Бесплатные возможности"
    paid: "Платный"
    trial: "Проба платных возможностей"
  currency:
    RUB: "рублей"
  expire: "Закончится {date}"
  button:
    activate: "Активировать"
    pay: "Купить"
    cancel: "Отменить"
    active: "Используется"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "My subscription"
  features: 
    title: "Features"
  type:
    free: "Free"
    paid: "Paid"
    trial: "Trial"
  currency:
    RUB: "RUB"
  expire: "Will expire {date}"
  button:
    activate: "Activate"
    pay: "Pay"
    cancel: "Cancel"
    active: "Active"
</i18n>
