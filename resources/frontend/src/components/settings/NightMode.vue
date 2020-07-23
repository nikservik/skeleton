<template>
    <div>
        <div class="block" >
            <div class="title">
                <IconMoon height="20" classes="settings-icon vertical-center" />
                <div>{{ $t('nightMode') }}</div>
            </div>
            <div>
                <label class="form-switch">
                  <input type="checkbox"  :checked="mode == 'on'" 
                    @change="save($event.target.checked ? 'on' : 'off')">
                  <i></i>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
import IconMoon from '@/components/visual/icons/IconMoon'
import { mapState } from 'vuex'

export default {
    components: { IconMoon },
    methods: {
        save(mode) {
            this.$store.dispatch('nightmode/set', mode)
        },
    },
    computed: {
        ...mapState('nightmode', {
            mode: state => state.mode
        }),
    }
}
</script>

<i18n locale="ru" lang="yaml">
    nightMode: "Темная тема"
</i18n>

<i18n locale="en" lang="yaml">
    nightMode: "Night theme"
</i18n>
