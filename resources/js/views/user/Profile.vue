<template>
    <Page>
        <PageHeader back="dashboard">
            {{ $t('pageTitle') }}
        </PageHeader>

        <div class="page-icon">
            <IconProfile classes="mx-auto" height="75" />
        </div>
        <NameEditable />
        <LoadingButton @clicked="logout">{{ $t('logout') }}</LoadingButton>

        <template v-slot:bottom>
            <div class="settings">
                <EmailEditable />
                <PasswordEditable />
                <LocaleEditable />
                <NightMode />
                <SubscriptionEditable />
                <PaymentMethod />
                <PaymentsHistory />
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
import NameEditable from '@/components/settings/NameEditable'
import NightMode from '@/components/settings/NightMode'
import LocaleEditable from '@/components/settings/LocaleEditable'
import PasswordEditable from '@/components/settings/PasswordEditable'
import SubscriptionEditable from '@/components/settings/SubscriptionEditable'
import PaymentMethod from '@/components/settings/PaymentMethod'
import PaymentsHistory from '@/components/settings/PaymentsHistory'
import Oferta from '@/components/settings/Oferta'
import { mapState, mapGetters } from 'vuex'

export default {
    components: { Page, PageHeader, EmailEditable, NameEditable, LocaleEditable, PasswordEditable, IconProfile, SubscriptionEditable, PaymentMethod, PaymentsHistory, NightMode, LoadingButton, Oferta },
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
