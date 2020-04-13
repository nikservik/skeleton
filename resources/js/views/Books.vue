<template>
  <div>
    <h1 class="page-header">{{ $t('pageTitle') }}</h1>

    <div class="py-6 mx-4">
        Фича. Читать могут только те, у кого это включено в тарифе. Книги загружаются из api.
    </div>
    <div v-for="book in books"
        class="text-center py-6 text-xl border border-gray-500 rounded-lg my-4">
        {{ book }}
    </div>
  </div>
</template>

<script>
export default {
    data() {
      return {
        books: [],
      }
    },
    mounted() {
      this.$http.get('/books')
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
