<template>
    <div class="left-menu">
        <div class="title">
            {{ $t('title') }}
        </div>
        <div class="item">
            <LoadingSign size="30" classes="text-prime-400" />
        </div>
        <div class="item">
            <router-link :to="{ name: loggedIn ? 'dashboard' : 'home' }">
                <IconHome height="24" :classes="
                    current == 'home' || current == 'dashboard' ? 'text-prime-400' : ''
                " />
            </router-link>
        </div>
        <div class="item">
            <router-link :to="{ name: 'support' }">
                <SupportSign :classes=" 
                    (current == 'support' ? 'text-prime-400' : '') + ' w-6 h-6'
                " />
            </router-link>
        </div>
        <div class="item">
            <router-link :to="{ name: loggedIn ? 'profile' : 'settings' }">
                <IconSettings height="24" :classes=" 
                    current == 'profile' || current == 'settings' ? 'text-prime-400' : ''
                " />
            </router-link>
        </div>
    </div>
</template>

<script>
import IconSettings from '@/components/visual/icons/IconSettings'
import IconHome from '@/components/visual/icons/IconHome'
import LoadingSign from '@/components/visual/LoadingSign'
import SupportSign from '@/components/visual/SupportSign'
import { mapGetters } from 'vuex'
export default {
    components: { IconSettings, IconHome, LoadingSign, SupportSign, },
    computed: {
        current() {
            return this.$route.name
        },
        ...mapGetters('auth', {
            loggedIn: 'loggedIn',
        }),
    }
}
</script>

<i18n locale="ru" lang="yaml">
    title: "Скелетон"
</i18n>

<i18n locale="en" lang="yaml">
    title: "Skeleton"
</i18n>
