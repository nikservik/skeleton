<template>
  <div id="app">
    <PopupMessage />

    <router-view/>

    <BottomMenu />
    <LeftMenu />
    <div class="h-16 hidden"></div>
  </div>
</template>

<script>
  import BottomMenu from '@/components/visual/BottomMenu'
  import LeftMenu from '@/components/visual/LeftMenu'
  import PopupMessage from '@/components/visual/PopupMessage'
  export default {
    components: { BottomMenu, LeftMenu, PopupMessage },
    data() {
      return {
      }
    },
    mounted() {
      this.$store.dispatch('support/loadUnread')
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
