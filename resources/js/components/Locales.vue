<template>
  <div class="pb-4 md:pb-2 pl-2 pr-12 md:pr-2 md:mr-8 text-right md:absolute right-0 bg-gray-300 dark:bg-gray-900 md:border-gray-400 md:border md:shadow md:rounded md:-mt-10" :class="$parent.localeOpened ? 'block' : 'hidden'">
    <a v-for="locale in locales" href="#" class="router-link block md:ml-0 uppercase" @click.prevent="setLocale(locale)">{{ locale }}</a>
  </div>
</template>

<script>
export default {
    data() {
      return {
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
        this.$parent.closeMenus();
        this.$root.$i18n.locale = locale;
        this.$cookie.set('locale', locale, { expires: '10Y' });
        if (this.$auth.check()) {
          this.$http.post('/locale', { locale: locale })
            .catch(error => {});
        }
      },
    }
}
</script>