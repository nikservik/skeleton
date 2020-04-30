<template>
    <div class="min-h-screen flex flex-col justify-between pb-75" 
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
}
</script>
