<template>
    <div>
        <div class="mx-20 px-16 my-16 py-20 shadow-lg rounded-md" 
            v-if="visible"
            :class="{ 
                'bg-white' : ! selected,
                'bg-gray-500 border text-white' : selected,
            }"
            @click="select()">
            <div class="float-right">
                <span class="rounded-sm bg-blue-500 text-white text-xs p-5" v-if="selected">
                    {{ $t('state.selected') }}
                </span>
                <span class="rounded-sm bg-blue-200 text-blue-600 text-xs p-5" v-if="next">
                    {{ $t('state.next') }}
                </span>
                <span class="rounded-sm bg-green-200 text-green-600 text-xs p-5" v-if="active">
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
                <div class="text-red-600" v-if="expire">
                    {{ $t('expire', { date: localizeDate(subscription.next_transaction_date) }) }}
                </div>
            </div>
            <div class="mt-20" v-if="! active">
                <ul class="list-inside text-sm">
                    <div v-for="feature in features" 
                        :class="{ 
                            'line-through text-gray-700': featureSign(feature) == '–',
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
            if (! this.tariff.features.includes(feature) 
                && this.subscription.features.includes(feature))
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