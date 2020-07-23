<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="15 21 19.8 15"
        :height="height ? height : 8" :class="classes" class="fill-current">
        <path d="M25 32.4l-9.7-9.7 1.4-1.4 8.3 8.3 8.3-8.3 1.4 1.4z"/>
    </svg>
</template>

<script>
export default {
    props: [ 'height', 'classes' ]
}
</script>