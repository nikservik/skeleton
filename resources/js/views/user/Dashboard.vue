<template>
  <Page type="no-header">
    <div class="page-text">
      <h1>Личный кабинет</h1>
      <p>Чувствуйте себя как дома.</p>
    </div>

    <template v-slot:bottom>
      <BigButton @clicked="$router.push({ name: 'sky' })" 
        v-if="can('see-sky')">
        {{ $t('features.see-sky') }}
      </BigButton>
      <BigButton @clicked="$router.push({ name: 'books' })" 
        v-if="can('read-books')">
        {{ $t('features.read-books') }}
      </BigButton>
    </template>
  </Page>
</template>

<script>
import Page from '@/components/visual/Page'
import PageHeader from '@/components/visual/PageHeader'
import BigButton from '@/components/visual/BigButton'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { Page, PageHeader, BigButton },
    created() {
      this.$store.dispatch('locale/loadSubscriptions')
    },
    computed: {
        ...mapState('auth', {
            user: state => state.user
        }),
        ...mapGetters('auth', {
            can: 'canUse',
        }),
    },
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Личный кабинет"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Dashboard"
</i18n>
