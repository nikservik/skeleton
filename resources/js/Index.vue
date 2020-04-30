<template>
  <div id="app">
    <PopupMessage />

    <router-view/>

    <BottomMenu />
  </div>
</template>

<script>
  import BottomMenu from '@/components/visual/BottomMenu'
  import PopupMessage from '@/components/visual/PopupMessage'
  export default {
    components: { BottomMenu, PopupMessage },
    data() {
      return {
      }
    },
    methods: {
      
    },
  }
</script>

<i18n locale="ru" lang="yaml">
  title: "Скелетон"
  uni: "Университет Никифоровых"
</i18n>

<i18n locale="en" lang="yaml">
  title: "Skeleton"
  uni: "Nikiforovy University"
</i18n>
