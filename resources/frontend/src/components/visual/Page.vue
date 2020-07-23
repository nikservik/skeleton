<template>
    <div class="page" 
        :class="{ 
            'with-header' : type != 'no-header', 
            'no-helpers' : type == 'no-helpers', 
        }">
        <div class="main">
            <slot></slot>
        </div>
        <div class="helpers" v-if="!!$slots.bottom">
            <slot name="bottom"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: [ 'type' ],
    mounted() {
        let vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);        
    },
}
</script>
