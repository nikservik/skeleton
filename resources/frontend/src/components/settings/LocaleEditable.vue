<template>
    <div>
        <div class="block with-errors" >
            <div class="title">
                <IconGlobe height="20" classes="settings-icon vertical-center" />
                <div>{{ $t('language') }}</div>
            </div>
            <div class="flex items-center text-black dark:text-gray-500" @click="toggleEdit">
                <div class="pr-5">{{ $t('locales.' + locale) }}</div>
                <div class="w-20">
                    <IconBottomChevron classes="mx-auto" v-if="! editing" />
                    <IconTopChevron classes="mx-auto" v-if="editing" />
                </div>
            </div>
            <div class="bottom">
                <div v-if="editing">
                    <div class="text-base py-5 px-5 mr-20" 
                        :class="{ 'font-semibold' : language == locale }"
                        v-for="language in locales" :key="language"
                        @click="set(language)">
                        {{ $t('locales.' + language) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import IconBottomChevron from '@/components/visual/icons/IconBottomChevron'
import IconTopChevron from '@/components/visual/icons/IconTopChevron'
import IconGlobe from '@/components/visual/icons/IconGlobe'
import { mapState } from 'vuex'

export default {
    components: { IconBottomChevron, IconTopChevron, IconGlobe },
    data() {
        return {
            editing: false,
            locales: ['ru', 'en'],
        }
    },
    mounted() {
    },
    methods: {
        toggleEdit() {
            this.editing = ! this.editing
        },
        set(locale) {
            this.$store.dispatch('locale/set', locale)
            this.editing = false
        },
    },
    computed: {
        ...mapState('locale', {
            locale: state => state.locale
        }),
    }
}
</script>

<i18n locale="ru" lang="yaml">
    language: "Язык"
    locales:
        ru: "Русский"
        en: "English"
</i18n>

<i18n locale="en" lang="yaml">
    language: "Language"
    locales:
        ru: "Русский"
        en: "English"
</i18n>
