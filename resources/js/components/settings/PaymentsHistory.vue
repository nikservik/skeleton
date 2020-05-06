<template>
    <div>
        <div class="block" @click="$router.push({ name: 'payments' })">
            <div class="title">
                <IconHistory height="20" classes="settings-icon vertical-center" />
                <div>{{ $t('history') }}</div>
                <div class="change">{{ $t('view') }}</div>
            </div>
            <div class="value">
                <div class="action">
                    <IconRightChevron height="16" classes="vertical-center ml-auto" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import IconRightChevron from '@/components/visual/icons/IconRightChevron'
import IconHistory from '@/components/visual/icons/IconHistory'
import { mapState, mapGetters, mapActions } from 'vuex'

export default {
    components: { IconRightChevron, IconHistory },
    methods: {
    },
    mounted() {
    },
    computed: {
    }
}
</script>

<i18n locale="ru" lang="yaml">
    history: "История платежей"
    view: "Посмотреть"
</i18n>

<i18n locale="en" lang="yaml">
    history: "Payments history"
    view: "View"
</i18n>
