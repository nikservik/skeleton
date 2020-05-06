<template>
    <Page>
        <PageHeader back="dashboard">
            {{ $t('pageTitle') }}
        </PageHeader>

        <div class="page-container double settings large">
            <NameEditableLarge />
            <SubscriptionEditable />
            <EmailEditable />
            <PaymentMethod />
            <PasswordEditable />
            <PaymentsHistory />
        </div>

        <template v-slot:bottom>
            <LoadingButton @clicked="logout">{{ $t('logout') }}</LoadingButton>
            <div class="settings">
                <LocaleEditable />
                <NightMode />
                <Oferta />
            </div>
        </template>
    </Page>
</template>

<script>
import IconProfile from '@/components/visual/icons/IconProfile'
import LoadingButton from '@/components/visual/LoadingButton'
import PageHeader from '@/components/visual/PageHeader'
import Page from '@/components/visual/Page'
import EmailEditable from '@/components/settings/EmailEditable'
import NameEditableLarge from '@/components/settings/NameEditableLarge'
import NightMode from '@/components/settings/NightMode'
import LocaleEditable from '@/components/settings/LocaleEditable'
import PasswordEditable from '@/components/settings/PasswordEditable'
import SubscriptionEditable from '@/components/settings/SubscriptionEditable'
import PaymentMethod from '@/components/settings/PaymentMethod'
import PaymentsHistory from '@/components/settings/PaymentsHistory'
import Oferta from '@/components/settings/Oferta'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { Page, PageHeader, EmailEditable, NameEditableLarge, LocaleEditable, PasswordEditable, IconProfile, SubscriptionEditable, PaymentMethod, PaymentsHistory, NightMode, LoadingButton, Oferta },
    data() {
        return {
        }
    },
    methods: {
        logout() {
            this.$store.dispatch('auth/logout')
                .then(() => {
                    this.$router.push({ name: 'home' })
                })
        },
    },
    computed: {
        ...mapGetters('errors', {
            errorsHappened: 'happened'
        }),
        ...mapState('auth', {
            user: state => state.user,
            loaded: state => state.loaded,
        }),
    },
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Профиль"
  logout: "Выйти"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Profile"
  logout: "Logout"
</i18n>
