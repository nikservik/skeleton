<template>
    <div>
        <h1 class="page-header">{{ $t('pageTitle') }}</h1>

        <div class="mx-4 md:mx-8">
          <h2 class="mt-6 -mx-2 px-2 text-xl font-bold border-b-4 border-blue-500">{{ $auth.user().subscription.name }}</h2>

          <div class="my-4" v-if="$auth.user().subscription.period == 'endless'">
            {{ $t('neverExpire') }}
          </div>
          <div class="my-4 text-red-600" v-if="canExpire($auth.user().subscription)">
            {{ $t('expire', { date: localizeDate($auth.user().subscription.next_transaction_date) }) }}
          </div>
          <div class="my-4" v-if="isPaid($auth.user().subscription) 
            && ! canExpire($auth.user().subscription)">
            {{ $auth.user().subscription.price + ' ' + 
              $t('currency.'+$auth.user().subscription.currency) + 
              ' / ' + $t('periods.'+$auth.user().subscription.period) }}
            <br>
            {{ $t('nextPayment', { date: localizeDate($auth.user().subscription.next_transaction_date) }) }}
          </div>
          <div class="my-4" v-if="isPaid($auth.user().subscription) 
            && $auth.user().subscription.status != 'Cancelled'">
            <a href="#" @click.prevent="cancel()" 
              class="text-red-600 px-2 py-1 border border-red-600 rounded-lg hover:bg-red-100">
              {{ $t('button.cancel') }}
            </a>
          </div>
          <div class="my-4">
            <router-link :to="{name: 'subscription-change'}" 
              class="text-blue-600 px-2 py-1 border border-blue-600 rounded-lg hover:bg-blue-100">
              {{ $t('button.change') }}
            </router-link>
          </div>

          <h4 class="text-lg my-4 mt-6 -mx-2 px-2 border-b-2 border-blue-500">{{ $t('features.title') }}</h4>
          <ul class="my-4 list-disc list-inside">
            <li v-for="feature in allFeatures" 
              :class="{ 'line-through text-gray-500' : !$auth.user().subscription.features.includes(feature) }">
              {{ $t('features.'+feature) }}
            </li>
          </ul>

          <h4 class="text-lg my-4 -mx-2 px-2 border-b-2 border-blue-500">{{ $t('payments.title') }}</h4>
          <div class="-mx-2">
            <table class="table-auto w-full">
              <tbody>
                <tr v-for="(payment, index) in payments" :class="{ 'bg-gray-200' : index % 2 }">
                  <td class="p-2">{{ localizeDate(payment.created_at) }}</td>
                  <td class="text-center p-2">{{ payment.amount }} {{ $t('currency.' + payment.currency) }}</td>
                  <td class="text-right p-2">{{ $t('payments.byCard', { card: payment.card_last_digits }) }}</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
    </div>
</template>
<script>
import LocaleMixin from '@/components/LocaleMixin'

  export default {
    mixins: [LocaleMixin],
    data() {
      return {
        payments: [],
        allFeatures: undefined,
      }
    },
    methods: {
      canExpire(tariff) {
        return tariff.price == 0 && ! tariff.prolongable && tariff.period != 'endless' 
          || tariff.status == 'Cancelled'
      },
      isPaid(tariff) {
        return tariff.price > 0 || tariff.visible == false
      },
      cancel() {
        this.$http.post('/subscriptions/cancel')
        .then(response => {
          setTimeout(() => { location.reload() }, 2000);
        })
      },
      localizeDate(date) {
        return date ? this.$d(new Date(date), 'short') : ''
      },
    },
    mounted() {
        this.$http.get('/subscriptions/translations')
        .then(response => {
          this.allFeatures = Object.keys(response.data.data.features)
          for (let [feature, translations] of Object.entries(response.data.data.features))
            this.addToLocale('features.'+feature, translations)
          for (let [period, translations] of Object.entries(response.data.data.periods))
            this.addToLocale('periods.'+period, translations)
        })
        this.$http.get('/subscriptions/payments')
        .then(response => {
          this.payments = response.data.data.payments
        })
    },
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Мой тариф"
  features: 
    title: "Доступные возможности"
  currency:
    RUB: "рублей"
  expire: "Закончится {date}"
  neverExpire: "Не закончится никогда"
  nextPayment: "Следующий платеж {date}"
  payments:
    title: "История платежей"
    byCard: "с карты *{card}"
  button:
    change: "Выбрать другой тарифный план"
    cancel: "Отменить подписку"
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
  nextPayment: "Next payment {date}"
  button:
    activate: "Activate"
    pay: "Pay"
    cancel: "Cancel"
    active: "Active"
</i18n>
