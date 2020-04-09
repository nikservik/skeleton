<template>
  <div id="app">
    <div class="content">
        <header class="dark:bg-gray-900">
            <div class="max-w-2xl mx-auto text-gray-700 dark:text-gray-500 relative">
              <div class="flex items-end py-4 md:pb-1 md:pt-6">
                <a class="mx-4 mb-px flex-grow-0 md:hidden" @click="toggleMenu">
                  <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path v-if="!menuOpened" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/>
                    <path v-if="menuOpened" d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"/>
                  </svg>
                </a>
                <router-link :to="{name: 'home'}" class="flex-grow text-3xl font-bold leading-none md:pl-4">
                  {{ $t('title') }}
                </router-link>
                <a class="flex-grow-0 uppercase" @click="toggleLocale">
                  {{ this.$root.$i18n.locale }}
                </a>
                <a class="mx-4 mb-px flex-grow-0 hover:bg-gray-400 rounded-full" @click="toggleUser">
                  <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path v-if="!userOpened" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z"/>
                    <path v-if="userOpened" d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"/>
                  </svg>
                </a>
              </div>
              <div class="pb-4 md:pb-2 px-1 md:flex" :class="menuOpened ? 'block' : 'hidden'">
                <router-link :to="{name: 'home'}" class="router-link block md:ml-1" @click.native="closeMenus">{{ $t('menu.welcome') }}</router-link>
              </div>
              <div class="pb-4 md:pb-2 pl-2 pr-12 md:pr-2 md:mr-8 text-right md:absolute right-0 bg-gray-300 dark:bg-gray-900 md:border-gray-400 md:border md:shadow md:rounded md:-mt-10" :class="localeOpened ? 'block' : 'hidden'">
                <a v-for="locale in locales" href="#" class="router-link block md:ml-0 uppercase" @click.prevent="setLocale(locale)">{{ locale }}</a>
              </div>
              <div class="pb-4 md:pb-2 px-2 text-right md:absolute right-0 bg-gray-300 dark:bg-gray-900 md:border-gray-400 md:border md:shadow md:rounded md:-mt-10" :class="userOpened ? 'block' : 'hidden'">
                <router-link v-if="!$auth.check()" :to="{name: 'login'}" class="router-link block md:ml-0 md:mt-2" @click.native="closeMenus">{{ $t('userMenu.login') }}</router-link>
                <router-link v-if="!$auth.check()" :to="{name: 'register'}" class="router-link block md:ml-0" @click.native="closeMenus">{{ $t('userMenu.register') }}</router-link>

                <router-link v-if="$auth.check()" :to="{name: 'dashboard'}" class="router-link block md:ml-0 md:mt-2" @click.native="closeMenus">{{ $t('userMenu.profile') }}</router-link>
                <a v-if="$auth.check()" href="#" class="router-link block md:ml-0" @click.prevent="$auth.logout()" @click="closeMenus">{{ $t('userMenu.logout') }}</a>
              </div>
            </div>
        </header>
        <div class="max-w-2xl mx-auto px-1 py-4" id="content">
            <router-view/>
        </div>
    </div>
    <footer class="dark:bg-gray-900 dark:text-gray-500">
        <div class="max-w-lg mx-auto px-2">
            @ <a href="https://nikiforovy.ru" target="_blank" class="hover:underline">{{ $t('uni') }}</a>
        </div>
    </footer>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        menuOpened: false,
        userOpened: false,
        localeOpened: false,
        locales: ['ru', 'en'],
      }
    },
    mounted() {
      if (this.$auth.check()) {
        this.$root.$i18n.locale = $auth.user().locale;
      } else {
        this.$root.$i18n.locale = this.$cookie.get('locale');
        if (! this.$root.$i18n.locale)
          this.$root.$i18n.locale = this.locales[0];
      }
    },
    methods: {
      setLocale(locale) {
        this.closeMenus();
        this.$root.$i18n.locale = locale;
        this.$cookie.set('locale', locale, { expires: '10Y' });
        if (this.$auth.check()) {
          this.$http.post('/locale', { locale: locale })
            .catch(error => {});
        }
      },
      closeMenus() { 
        this.menuOpened = false; 
        this.userOpened = false; 
        this.localeOpened = false; 
      },
      toggleMenu() { 
        if (this.menuOpened) {
          this.closeMenus(); 
        } else {
          this.closeMenus(); 
          this.menuOpened = true; 
        }
      },
      toggleUser() { 
        if (this.userOpened) {
          this.closeMenus(); 
        } else {
          this.closeMenus(); 
          this.userOpened = true; 
        }
      },
      toggleLocale() { 
        if (this.localeOpened) {
          this.closeMenus(); 
        } else {
          this.closeMenus(); 
          this.localeOpened = true; 
        }
      }
    },
  }
</script>

<i18n locale="ru" lang="yaml">
  title: "Скелетон"
  uni: "Университет Никифоровых"
  menu: 
    welcome: "Добро пожаловать"
  userMenu: 
    login: "Вход"
    register: "Регистрация"
    profile: "Профиль"
    logout: "Выход"
</i18n>

<i18n locale="en" lang="yaml">
  title: "Skeleton"
  uni: "Nikiforovy University"
  menu: 
    welcome: "Welcome"
  userMenu: 
    login: "Login"
    register: "Register"
    profile: "Profile"
    logout: "Logout"
</i18n>
