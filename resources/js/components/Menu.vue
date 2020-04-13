<template>
  <div class="pb-4 md:pb-2 px-1 md:flex"  :class="$parent.menuOpened ? 'block' : 'hidden'">
    <router-link :to="{name: 'home'}" 
        class="router-link block md:ml-1" 
        @click.native="$parent.closeMenus">
        {{ $t('welcome') }}
    </router-link>
    <router-link :to="{name: 'sky'}" 
        :class="{ hidden: !allowed('see-sky') }"
        class="router-link block md:ml-1" 
        @click.native="$parent.closeMenus">
        {{ $t('sky') }}
    </router-link>
    <router-link :to="{name: 'books'}" 
        :class="{ hidden: !allowed('read-books') }"
        class="router-link block md:ml-1" 
        @click.native="$parent.closeMenus">
        {{ $t('books') }}
    </router-link>
  </div>
</template>

<script>
export default {
    methods: {
        allowed(feature) {
            if (!this.$auth.user()) 
                return false;
            if (!this.$auth.user().features) 
                return false;
            if (!this.$auth.user().features.includes(feature)) 
                return false;
            return true;
        }
    }
}
</script>

<i18n locale="ru" lang="yaml">
    welcome: "Добро пожаловать"
    sky: "Видно небо"
    books: "Читать книги"
</i18n>

<i18n locale="en" lang="yaml">
    welcome: "Welcome"
    sky: "See sky"
    books: "Read books"
</i18n>
