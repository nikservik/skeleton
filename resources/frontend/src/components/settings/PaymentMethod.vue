<template>
    <div v-if="user.cardLastFour">
        <div class="block with-errors" @click="$router.push({ name: 'payment-card' })">
            <div class="title">
                <IconMoney height="20" classes="settings-icon vertical-center" />
                <div>{{ $t('method') }}</div>
                <div class="change">{{ $t('change') }}</div>
            </div>
            <div class="value">
                <div class="">** {{ user.cardLastFour }}</div>
                <div class="action">
                    <IconRightChevron height="16" classes="vertical-center ml-auto" />
                </div>
            </div>
            <div class="bottom">
            </div>
        </div>
    </div>
</template>

<script>
import IconRightChevron from '@/components/visual/icons/IconRightChevron'
import IconMoney from '@/components/visual/icons/IconMoney'
import { mapState } from 'vuex'

export default {
    components: { IconRightChevron, IconMoney },
    methods: {
    },
    mounted() {
    },
    computed: {
        ...mapState('auth', {
            user: state => state.user
        }),
    }
}
</script>

<i18n locale="ru" lang="yaml">
    method: "Привязанная карта"
    change: "Изменить"
</i18n>

<i18n locale="en" lang="yaml">
    method: "Saved credit card"
    change: "Change"
</i18n>
