<template>
    <div class="popup-message" v-if="message">
        <div class="block">
            <div class="w-30 mr-11"><IconInfo height="30" classes="text-prime-500" /></div>
            <div class="mt-5">{{ message }}</div>
            <div class="close" @click="close">×</div>
        </div>
    </div>
</template>

<script>
import IconInfo from '@/components/visual/icons/IconInfo'
import { mapState } from 'vuex'
export default {
    components: { IconInfo },
    methods: {
        close() {
            this.$store.dispatch('message/clear')
        },
    },
    // created() {
    //     this.$store.dispatch('message/show', 'Новая электронная почта сохранена. Подвердите ее с помощью ссылки в письме.')
    // },
    computed: {
        ...mapState('message', {
            message: state => state.message
        }),
    },
}
</script>
