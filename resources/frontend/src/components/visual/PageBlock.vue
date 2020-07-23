<template>
    <div>
        <div class="page-block-title" v-if="title">
            {{ title }}
        </div>
        <div class="page-block" :class="classes">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: [ 'title', 'classes' ],
}
</script>
