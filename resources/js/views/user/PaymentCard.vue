<template>
    <Page>
      <PageHeader back="profile">
          {{ $t('pageTitle') }}
      </PageHeader>

      <div class="page-container double">
        <PageBlock>
          <div v-html="$t('warning')"></div>
        </PageBlock>

        <div class="element">
          <PayForm ref="payform" :tariff="{ id: 0 }" @loaded="cpLoaded = true" />

          <LoadingButton :disable="disable && ! cpLoaded"" @clicked="save">
            {{ $t('save') }}
          </LoadingButton>
        </div>
      </div>
    </Page>
</template>

<script>
import Page from '@/components/visual/Page'
import PageHeader from '@/components/visual/PageHeader'
import PageBlock from '@/components/visual/PageBlock'
import LoadingButton from '@/components/visual/LoadingButton'
import PayForm from '@/components/PayForm'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { Page, PageHeader, LoadingButton, PageBlock, PayForm },
    data() {
      return {
        cpLoaded: false,
      }
    },
    methods: {
        save() {
          return this.$refs.payform.authorize()
        },
        localizeDate(date) {
            return date ? this.$d(new Date(date), 'payment') : ''
        },
    },
    computed: {
        ...mapState('auth', {
            subscription: state => state.user.subscription
        }),
        ...mapGetters('loading', {
            disable: 'disable',
        }),
    },
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Новая карта"
  save: "Сохранить"
  warning: "Для сохранения новой карты мы сделаем авторизацию платежа на <nobr>10 рублей</nobr>.<p> Деньги с вашей карты НЕ БУДУТ списаны.</p>"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "New card"
  warning: ""
</i18n>
