<template>
  <Page type="no-header">
    <div class="page-text">
      <h1>{{ $t('pageTitle') }}</h1>

      <p> Фича. Читать могут только те, у кого это включено в тарифе. Книги загружаются из api. </p>
    </div>
    <PageBlock v-for="(book, index) in books" :key="index">
        {{ book }}
    </PageBlock>
  </Page>
</template>

<script>
import Page from '@/components/visual/Page'
import PageBlock from '@/components/visual/PageBlock'
import axios from 'axios'

export default {
    components: { Page, PageBlock },
    data() {
      return {
        books: [],
      }
    },
    mounted() {
      axios.get('/books')
      .then(response => {
        this.books = response.data.books;
      })
    },
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Читать книги"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Read books"
</i18n>
