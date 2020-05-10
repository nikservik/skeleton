<template>
  <Page type="no-header">
    <div class="page-text">
      <h1>{{ $t('pageTitle') }}</h1>

      <div v-html="content"></div>
    </div>
  </Page>
</template>

<script>
import Page from '@/components/visual/Page'
import axios from 'axios'

export default {
    components: { Page },
    data() {
      return {
        content: [],
      }
    },
    mounted() {
      axios.get('/oferta')
      .then(response => {
        this.content = response.data.content;
      })
    },
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Публичная оферта"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "User agreement"
</i18n>
