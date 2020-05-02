<template>
    <div>
        <div class="block with-errors" >
            <div class="title">
                <IconMoney height="20" classes="settings-icon vertical-center" />
                <div>{{ $t('tariff') }}</div>
            </div>
            <div class="flex items-center text-black dark:text-gray-500" 
                @click="$router.push({ name: 'select-tariff' })">
                <div class="">{{ subscription.name[$i18n.locale] }}</div>
                <div class="w-20">
                    <IconRightChevron height="16" classes="vertical-center ml-auto" />
                </div>
            </div>
            <div class="bottom">
                <div class="warning-text pr-16">
                    <div v-if="isEndless()">{{ $t('neverExpire') }}</div>
                    <div v-if="canExpire()" class="text-prime-500">
                        {{ $t('expire', { date: localizeNext() }) }}
                    </div>
                    <div v-if="isPaid() && ! canExpire()">
                        {{ 
                            subscription.price 
                            + ' ' + $t('currency.' + subscription.currency) 
                            + '/' + $t('periods.' + subscription.period)
                        }} <br>
                        {{ $t('nextPayment', { date: localizeNext() }) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import IconRightChevron from '@/components/visual/icons/IconRightChevron'
import IconMoney from '@/components/visual/icons/IconMoney'
import { mapState, mapGetters, mapActions } from 'vuex'

export default {
    components: { IconRightChevron, IconMoney },
    methods: {
      canExpire() {
        return this.subscription.price == 0 && ! this.subscription.prolongable 
            && this.subscription.period != 'endless' || this.subscription.status == 'Cancelled'
      },
      isPaid() {
        return this.subscription.price > 0
      },
      isEndless() {
        return this.subscription.period == 'endless'
      },
      localizeNext() {
        return this.subscription.next_transaction_date 
            ? this.$d(new Date(this.subscription.next_transaction_date), 'short') 
            : ''
      },
    },
    mounted() {
        this.$store.dispatch('locale/loadSubscriptions')
    },
    computed: {
        ...mapState('auth', {
            subscription: state => state.user.subscription
        }),
    }
}
</script>

<i18n locale="ru" lang="yaml">
    tariff: "Тарифный план"
    currency:
        RUB: "рублей"
    expire: "Закончится {date}"
    neverExpire: "Не закончится никогда"
    nextPayment: "Следующий автоматический платеж {date}"
</i18n>

<i18n locale="en" lang="yaml">
    tariff: "Subscription plan"
    currency:
        RUB: "RUB"
    expire: "Will expire {date}"
    neverExpire: "Never expire"
    nextPayment: "Next payment {date}"
</i18n>
