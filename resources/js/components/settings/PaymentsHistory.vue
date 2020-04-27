<template>
    <div>
        <div class="block" >
            <div class="title">
                <IconHistory height="20" classes="vertical-center" />
                <div class="ml-11">{{ $t('history') }}</div>
            </div>
            <div class="text-black">
                    <IconRightChevron height="16" classes="vertical-center ml-auto" />
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
</i18n>

<i18n locale="en" lang="yaml">
    history: "Payments history"
</i18n>
