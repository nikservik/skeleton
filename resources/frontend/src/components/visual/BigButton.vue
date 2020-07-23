<template>
    <div class="big-button-holder">
      <button 
        :disabled="disable"
        @click="$emit('clicked')">
        <div class="flex items-center justify-center">
          <LoadingSign size="16" class="-ml-16 align-middle" />
          <div class="mx-5"><slot></slot></div>
        </div>
      </button>
    </div>
</template>

<script>
import LoadingSign from '@/components/visual/LoadingSign'

export default {
    props: [ 'disable', ],
    components: { LoadingSign },
}
</script>
