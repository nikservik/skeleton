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
              <topmenu />
              <locales />
              <usermenu />
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
  import topmenu from '@/components/Menu'
  import usermenu from '@/components/UserMenu'
  import locales from '@/components/Locales'

  export default {
    data() {
      return {
        menuOpened: false,
        userOpened: false,
        localeOpened: false,
      }
    },
    methods: {
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
    components: { topmenu, usermenu, locales },
  }
</script>

<i18n locale="ru" lang="yaml">
  title: "Скелетон"
  uni: "Университет Никифоровых"
</i18n>

<i18n locale="en" lang="yaml">
  title: "Skeleton"
  uni: "Nikiforovy University"
</i18n>
