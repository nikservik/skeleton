<template>
  <Page>
    <PageHeader back="home">
        {{ $t('pageTitle') }}
    </PageHeader>

    <div class="page-icon">
        <IconSettings classes="mx-auto" height="75" />
    </div>

    <template v-slot:bottom>
        <div class="settings">
            <LocaleEditable />
            <NightMode />
            <Oferta />
        </div>
    </template>
  </Page>
</template>

<script>
import IconSettings from '@/components/visual/icons/IconSettings'
import Page from '@/components/visual/Page'
import PageHeader from '@/components/visual/PageHeader'
import NightMode from '@/components/settings/NightMode'
import LocaleEditable from '@/components/settings/LocaleEditable'
import Oferta from '@/components/settings/Oferta'

export default {
    components: { PageHeader, Page, LocaleEditable, IconSettings, NightMode, Oferta },
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Настройки"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Settings"
</i18n>
