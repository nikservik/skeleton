<template>
    <div class="page-header">
        <div class="nav">
            <div class="back">
                <router-link :to="{ name: back }" v-if="back">
                    <IconLeftChevron height="20" />
                </router-link>
                &nbsp;
            </div>
            <div class="title">
                <slot></slot>
            </div>
            <div>&nbsp;</div>
        </div>
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
