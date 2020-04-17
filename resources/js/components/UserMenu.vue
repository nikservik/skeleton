<template>
  <div class="pb-4 md:pb-2 px-2 text-right md:absolute right-0 bg-gray-300 dark:bg-gray-900 md:border-gray-400 md:border md:shadow md:rounded md:-mt-10" 
    :class="$parent.userOpened ? 'block' : 'hidden'">
    <router-link v-if="!$auth.check()" 
        :to="{name: 'login'}" 
        class="router-link block md:ml-0 md:mt-2" 
        @click.native="$parent.closeMenus">
        {{ $t('login') }}
    </router-link>
    <router-link v-if="!$auth.check()" 
        :to="{name: 'register'}" 
        class="router-link block md:ml-0" 
        @click.native="$parent.closeMenus">
        {{ $t('register') }}
    </router-link>

    <router-link v-if="$auth.check()" 
        :to="{name: 'dashboard'}" 
        class="router-link block md:ml-0 md:mt-2" 
        @click.native="$parent.closeMenus">
        {{ $t('profile') }}
    </router-link>
    <router-link v-if="$auth.check()" 
        :to="{name: 'subscription'}" 
        class="router-link block md:ml-0 md:mt-2" 
        @click.native="$parent.closeMenus">
        {{ $t('subscription') }}
    </router-link>
    <a v-if="$auth.check()" 
        href="#" 
        class="router-link block md:ml-0" 
        @click.prevent="logout()" 
        @click="$parent.closeMenus">
        {{ $t('logout') }}
    </a>
  </div>
</template>

<script>
export default {
    methods: {
        logout() {
            this.$auth.logout();
            this.$router.push({name: 'home'});
        }
    }
}
</script>

<i18n locale="ru" lang="yaml">
    login: "Вход"
    register: "Регистрация"
    profile: "Профиль"
    subscription: "Подписка"
    logout: "Выход"
</i18n>

<i18n locale="en" lang="yaml">
    login: "Login"
    register: "Register"
    profile: "Profile"
    subscription: "Subscription"
    logout: "Logout"
</i18n>
