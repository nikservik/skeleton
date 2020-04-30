<template>
    <div v-if="user.cardLastFour">
        <div class="block with-errors" @click="$router.push({ name: 'payment-card' })">
            <div class="title">
                <IconMoney height="20" classes="settings-icon vertical-center" />
                <div>{{ $t('method') }}</div>
            </div>
            <div class="flex items-center text-black dark:text-gray-500">
                <div class="">** {{ user.cardLastFour }}</div>
                <div class="w-20">
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
import { mapState, mapGetters, mapActions } from 'vuex'

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
</i18n>

<i18n locale="en" lang="yaml">
    method: "Saved credit card"
</i18n>
