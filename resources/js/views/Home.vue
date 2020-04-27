<template>
  <div>
    <PageHeader>{{ $t('pageTitle') }}</PageHeader>

    <div class="page-text">
        Эта страница видна всем – и авторизованным, и не авторизованным.
    </div>
  </div>
</template>

<script>
import PageHeader from '@/components/visual/PageHeader'

export default {
  components: { PageHeader }
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Добро пожаловать"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Welcome"
</i18n>
