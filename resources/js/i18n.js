import Vue from 'vue';
import VueI18n from 'vue-i18n';

Vue.use(VueI18n);

const dateTimeFormats = {
    'ru': { short: {year: 'numeric', month: 'short', day: 'numeric'} },
    'en': { short: {year: 'numeric', month: 'short', day: 'numeric'} },
}
const i18n = new VueI18n({
  dateTimeFormats
})

export default i18n;
