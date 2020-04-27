<template>
  <div id="app">
    <div class="content">
        <div class="">
            <router-view/>
        </div>
    </div>
    <BottomMenu />
  </div>
</template>

<script>
  import BottomMenu from '@/components/visual/BottomMenu'
  export default {
    data() {
      return {
      }
    },
    methods: {
      
    },
    components: { BottomMenu },
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
