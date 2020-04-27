<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="21.3 15 11 20"
        :height="height" :class="classes" class="fill-current">
        <path d="M22.7 34.7l-1.4-1.4 8.3-8.3-8.3-8.3 1.4-1.4 9.7 9.7z"/>
    </svg>
</template>

<script>
export default {
    props: [ 'height', 'classes' ]
}
</script>