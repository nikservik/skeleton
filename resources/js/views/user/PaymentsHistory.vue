<template>
  <div>
    <PageHeader back="profile">
        {{ $t('pageTitle') }}
    </PageHeader>

    <table class="table-auto w-full max-w-full">
        <tr v-for="(payment, index) in payments" :class="{ 'bg-gray-200' : index % 2 }">
            <td class="pl-20 py-20">{{ localizeDate(payment.created_at) }}</td>
            <td class="text-center">** {{ payment.card_last_digits }}</td>
            <td class="text-right pr-20">{{ payment.amount + ' ' + $t('currency.' + payment.currency) }}</td>
        </tr>
    </table>

  </div>
</template>

<script>
import PageHeader from '@/components/visual/PageHeader'
import { mapState } from 'vuex'

  export default {
    components: { PageHeader },
    methods: {
      localizeDate(date) {
        return date ? this.$d(new Date(date), 'payment') : ''
      },
    },
    mounted() {
        this.$store.dispatch('subscription/loadPayments')
    },
    computed: {
        ...mapState('subscription', {
            payments: state => state.payments
        }),
    },
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "История платежей"
  currency:
    RUB: "рублей"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Payments history"
  currency:
    RUB: "RUB"
</i18n>
