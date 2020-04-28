<template>
    <div>
        <div class="header">
            <div class="back">
                <router-link :to="{ name: back }" v-if="typeof back == 'string'">
                    <IconLeftChevron height="20" />
                </router-link>
                <div v-if="typeof back == 'function'" @click="back">
                    <IconLeftChevron height="20" />
                </div>
                &nbsp;
            </div>
            <div class="title">
                <slot></slot>
            </div>
            <div>&nbsp;</div>
        </div>
        <div class="header-spacer"></div>
    </div>
</template>

<script>
import IconLeftChevron from '@/components/visual/icons/IconLeftChevron'
export default {
    props: [ 'back' ],
    components: { IconLeftChevron },
}
</script>

<i18n locale="ru" lang="yaml">
    save: "Сохранить"
</i18n>

<i18n locale="en" lang="yaml">
</i18n>
