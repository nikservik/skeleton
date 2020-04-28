<template>
  <div>
    <PageHeader back="home">
        {{ $t('pageTitle') }}
    </PageHeader>

    <div class="text-gray-500">
        <IconProfile classes="mx-auto" height="75" />
    </div>
    <NameEditable />
    <div class="content-bottom">
        <EmailEditable />
        <PasswordEditable />
        <LocaleEditable />
        <SubscriptionEditable />
        <PaymentMethod />
        <PaymentsHistory />
    </div>
  </div>
</template>

<script>
import IconProfile from '@/components/visual/icons/IconProfile'
import PageHeader from '@/components/visual/PageHeader'
import EmailEditable from '@/components/settings/EmailEditable'
import NameEditable from '@/components/settings/NameEditable'
import LocaleEditable from '@/components/settings/LocaleEditable'
import PasswordEditable from '@/components/settings/PasswordEditable'
import SubscriptionEditable from '@/components/settings/SubscriptionEditable'
import PaymentMethod from '@/components/settings/PaymentMethod'
import PaymentsHistory from '@/components/settings/PaymentsHistory'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { PageHeader, EmailEditable, NameEditable, LocaleEditable, PasswordEditable, IconProfile, SubscriptionEditable, PaymentMethod, PaymentsHistory },
    data() {
        return {
        }
    },
    methods: {
    },
    computed: {
        ...mapGetters('errors', {
            errorsHappened: 'happened'
        }),
        ...mapState('auth', {
            user: state => state.user
        }),
    },
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Профиль"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Profile"
</i18n>
