<template>
    <div class="relative">
        <div class="absolute bottom-0 left-0 mb-75">
            <div id="auto-scroll-block"></div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.scroll()
    },
    methods: {
        scroll() {
            document.getElementById('auto-scroll-block').scrollIntoView(true)
        },
    },
}
</script>
