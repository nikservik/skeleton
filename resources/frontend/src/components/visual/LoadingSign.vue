<template>
    <div :class="'w-' + size + ' h-' + size">
        <IconLoading 
            :classes="'w-' + size + ' h-' + size + ' ' + classes" 
            v-if="mode" />
    </div>
</template>

<script>
import IconLoading from '@/components/visual/icons/IconLoading'
import { mapState } from 'vuex'
export default {
    props: [ 'size', 'classes' ],
    components: { IconLoading },
    computed: {
        ...mapState('loading', {
            mode: state => state.mode
        }),
    }
}
</script>
