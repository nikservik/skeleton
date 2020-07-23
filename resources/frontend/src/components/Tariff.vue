<template>
    <div v-if="visible">
        <div class="page-block" 
            :class="{ 'active' : active, 'selected' : selected, }"
            @click="select()">
            <div class="float-right">
                <span class="marker" v-if="selected">
                    {{ $t('state.selected') }}
                </span>
                <span class="marker" v-if="next">
                    {{ $t('state.next') }}
                </span>
                <span class="marker" v-if="active">
                    {{ $t('state.active') }}
                </span>
            </div>

            <div class="font-bold text-base">{{ $t('tariffs.' + tariff.slug) }}</div>

            <div class="mt-20">
                <div class="" v-if="free && endless">
                    {{ $t('free') }}
                </div>
                <div class="" v-if="trial && !expire">
                    {{ $t('trialFor') }} {{ $t('periods.'+tariff.period) }}
                </div>
                <div class="" v-if="paid && !expire">
                    {{ tariff.price + ' ' + $t('currency.'+tariff.currency) + 
                    '/' + $t('periods.'+tariff.period) }}
                </div>
                <div class="text-prime-100 dark:text-prime-300" v-if="expire">
                    {{ $t('expire', { date: localizeDate(subscription.next_transaction_date) }) }}
                </div>
            </div>
            <div class="mt-20" v-if="! active">
                <ul class="list-inside text-sm">
                    <div v-for="feature in features" :key="feature"
                        :class="{ 
                            'line-through': featureSign(feature) == '–',
                            'font-bold': featureSign(feature) == '+',
                        }">
                        <span v-html="featureSign(feature)"></span> 
                        {{ $t('features.'+feature) }}
                    </div>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
    props: [ 'tariff', 'selected', 'collapsed' ],
    methods: {
        select() {
            if (! this.active && ! this.disabled && ! this.next)
                this.$emit('select')
        },
        localizeDate(date) {
            return date ? this.$d(new Date(date), 'short') : ''
        },
        featureChanged(feature) { 
            return this.tariff.features.includes(feature) 
                != this.subscription.features.includes(feature)
        },
        featureSign(feature) {
            if (this.tariff.features.includes(feature) 
                && ! this.subscription.features.includes(feature))
                return '+'
            if (! this.tariff.features.includes(feature))
                return '–'
            return '&nbsp;&nbsp;'
        },
    },
    computed: {
        active() { 
            return this.tariff.id == this.subscription.tariff_id 
        },
        free() { 
            return this.tariff.price == 0 
        },
        endless() { 
            return this.tariff.period == 'endless'
        },
        paid() { 
            return this.tariff.price > 0 
        },
        trial() { 
            return this.tariff.price == 0 && ! this.tariff.prolongable 
                && this.tariff.period != 'endless'
        },
        next() {
            return this.tariff.default && this.subscription.status == 'Cancelled'
        },
        onTrial() { 
            return this.subscription.price == 0 && ! this.subscription.prolongable 
                && this.subscription.period != 'endless'
        },
        visible() {
            if (this.collapsed && ! this.selected) return false
            if (this.active) return true
            if (! this.tariff.visible) return false
            if (this.disabled) return false
            return true
        },
        disabled() {
            if (this.trial && this.user.hadTrial) return true
            if (this.trial && this.onTrial) return true
            if (this.subscription.price > 0 && this.trial) return true
            return false
        },
        expire() {
            return this.active && (this.trial || this.subscription.status == 'Cancelled')
        },
        tariffId() {
            return this.tariff.id
        },
        ...mapState('auth', {
            subscription: state => state.user.subscription,
            user: state => state.user,
        }),
        ...mapState('subscription', {
            features: state => state.features,
        }),
    },
}
</script>

<i18n locale="ru" lang="yaml">
    free: "Всегда бесплатный"
    trialFor: "Бесплатный на"
    expire: "Закончится {date}"
    currency:
        RUB: "рублей"
    state:
        unavailable: "недоступен"
        selected: "выбран"
        active: "активный"
        next: "включится после"
</i18n>

<i18n locale="en" lang="yaml">
</i18n>