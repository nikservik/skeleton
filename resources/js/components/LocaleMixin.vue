<script>
export default {
    methods: {
        addToLocale(name, translations) {
            for (let [locale, translation] of Object.entries(translations))
                this.$i18n.mergeLocaleMessage(locale, {[name]: translation})
        }
    }
}
</script>