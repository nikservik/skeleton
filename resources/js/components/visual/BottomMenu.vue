<template>
    <div class="bottom-menu sm:hidden">
        <div class="item">
            <router-link :to="{ name: 'home' }">
                <IconHome height="24" />
            </router-link>
        </div>
        <div class="item">
            <router-link :to="{ name: 'profile' }">
                <IconSettings height="24" />
            </router-link>
        </div>
    </div>
</template>

<script>
import IconSettings from '@/components/visual/icons/IconSettings'
import IconHome from '@/components/visual/icons/IconHome'
export default {
    components: { IconSettings, IconHome }
}
</script>

<i18n locale="ru" lang="yaml">
</i18n>

<i18n locale="en" lang="yaml">
</i18n>
