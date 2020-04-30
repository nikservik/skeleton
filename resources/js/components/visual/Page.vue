<template>
    <div class="page" 
        :class="{ 'pt-75' : type != 'no-header' }">
        <div class="">
            <slot></slot>
        </div>
        <div>
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
