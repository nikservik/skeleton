<template>
  <Page>
    <PageHeader :back="collapsed ? () => { collapsed = false } : 'profile'">
        {{ $t('pageTitle') }}
    </PageHeader>

    <div class="page-container double">
      <Tariff 
        v-for="(tariff, index) in tariffs" 
        :key="tariff.id"
        :tariff="tariff"
        :selected="selected === index"
        :collapsed="collapsed"
        v-on:select="select(index)" />
        
      <div class="element">
        <TariffSwitch v-if="collapsed" 
          :from="subscription"
          :to="tariffs[selected]" />
      </div>
    </div>
  </Page>
</template>

<script>
import Page from '@/components/visual/Page'
import PageHeader from '@/components/visual/PageHeader'
import Tariff from '@/components/Tariff'
import TariffSwitch from '@/views/user/TariffSwitch'
import { mapState } from 'vuex'

  export default {
    components: { Page, PageHeader, Tariff, TariffSwitch },
    data() {
      return {
        selected: undefined,
        collapsed: false,
      }
    },
    methods: {
      select(index) {
        this.selected = index
        this.collapsed = true
      },
      localizeDate(date) {
        return date ? this.$d(new Date(date), 'short') : ''
      },
    },
    mounted() {
        this.$store.dispatch('locale/loadTariffs')
        this.$store.dispatch('locale/loadSubscriptions')
        this.$store.dispatch('subscription/loadFeatures')
        this.$store.dispatch('subscription/loadTariffs')
    },
    computed: {
        ...mapState('subscription', {
            tariffs: state => state.tariffs
        }),
        ...mapState('auth', {
            subscription: state => state.user.subscription
        }),
    },
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Смена тарифного плана"
  warning: "Вы собираетесь сменить тарифный план на "
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Change subscription plan"
  warning: "You are going to switch to "
</i18n>
