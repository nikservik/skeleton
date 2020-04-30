<template>
    <div class="fixed top-0 inset-x-0">
        <div class="mt-75" @click="close">
            <PageBlock classes="bg-prime-600 text-gray-200 text-lg" v-if="message">
                {{ message }}
            </PageBlock>
        </div>
    </div>
</template>

<script>
import PageBlock from '@/components/visual/PageBlock'
import { mapState } from 'vuex'
export default {
    components: { PageBlock },
    methods: {
        close() {
            this.$store.dispatch('message/clear')
        },
    },
    // created() {
    //     this.$store.dispatch('message/show', 'Просто привет')
    // },
    computed: {
        ...mapState('message', {
            message: state => state.message
        }),
    },
}
</script>
