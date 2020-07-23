<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="15 17 19.8 15"
        :height="height ? height : 8" :class="classes" class="fill-current">
        <path d="M33.3 28.7L25 20.4l-8.3 8.3-1.4-1.4 9.7-9.7 9.7 9.7z"/>
    </svg>
</template>

<script>
export default {
    props: [ 'height', 'classes' ]
}
</script>