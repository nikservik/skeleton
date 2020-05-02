<template>
  <Page type="no-header">
    <div class="page-text">
        <h1>{{ $t('pageTitle') }}</h1>

        <p> Фича. Смотреть на небо могут только те, у кого это включено в тарифе </p>
        <p><div class="w-20 h-20"><IconLoading classes="w-20 h-20" /></div></p>
    </div>
  </Page>
</template>

<script>
import Page from '@/components/visual/Page'
import IconLoading from '@/components/visual/icons/IconLoading'
export default {
    components: { Page, IconLoading },
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Видно небо"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "See sky"
</i18n>
