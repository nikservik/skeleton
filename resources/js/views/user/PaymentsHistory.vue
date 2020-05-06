<template>
  <Page>
    <PageHeader back="profile">
        {{ $t('pageTitle') }}
    </PageHeader>

    <table class="table-auto w-full max-w-full">
        <tr v-for="(payment, index) in payments" valign="top" 
          :class="{ 'bg-prime-100 dark:bg-prime-900' : index % 2 }">
            <td class="pl-20 py-20">{{ localizeDate(payment.created_at) }}</td>
            <td class="text-center py-20">** {{ payment.card_last_digits }}</td>
            <td class="text-right py-20">
              <span :class="{ 'line-through' : payment.status == 'Refunded'}">
                {{ payment.amount + ' ' + $t('currency.' + payment.currency) }}</span>
              <div v-if="payment.status == 'Refunded'">
                <IconRefund height="16" classes="vertical-center inline-block text-gray-700" />
                {{ $t('refunded') }}
              </div>
            </td>
            <td class="pl-11 pr-11 py-20 text-center">
              <a :href="payment.receipt_url" target="_blank">
                <IconReceipt height="16" classes="vertical-center inline-block text-gray-700"
                  v-if="payment.receipt_url" />
              </a>
            </td>
        </tr>
    </table>

  </Page>
</template>

<script>
import PageHeader from '@/components/visual/PageHeader'
import IconRefund from '@/components/visual/icons/IconRefund'
import IconReceipt from '@/components/visual/icons/IconReceipt'
import Page from '@/components/visual/Page'
import { mapState } from 'vuex'

  export default {
    components: { Page, PageHeader, IconRefund, IconReceipt },
    methods: {
      localizeDate(date) {
        return date ? this.$d(new Date(date), 'payment') : ''
      },
      openReceipt(url) {
        window.open(url, '_blank')
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
  refunded: "Возвращен"
  currency:
    RUB: "рублей"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Payments history"
  refunded: "Refunded"
  currency:
    RUB: "RUB"
</i18n>
