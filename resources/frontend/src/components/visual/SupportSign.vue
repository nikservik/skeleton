<template>
    <div :class="'w-' + size + ' h-' + size" class="relative">
        <IconSupport 
            :classes="'w-' + size + ' h-' + size + ' ' + classes" />
        <div v-if="unread" class="absolute top-0 right-0 text-prime-500 text-xs -mt-1">●</div>
    </div>
</template>

<script>
import IconSupport from '@/components/visual/icons/IconSupport'
import { mapState } from 'vuex'
export default {
    props: [ 'size', 'classes' ],
    components: { IconSupport },
    computed: {
        ...mapState('support', {
            unread: state => state.unread
        }),
    }
}
</script>
