<template>
  <div>
    <h1 class="page-header">{{ $t('pageTitle') }}</h1>

    <div class="py-6 mx-4">
        Фича. Смотреть на небо могут только те, у кого это включено в тарифе
    </div>

  </div>
</template>

<script>
export default {
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Видно небо"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "See sky"
</i18n>
