<template>
    <div class="save-button-holder" v-if="editing">
        <button @click="$emit('save')">
            {{ save ? save : $t('save') }}
        </button>
    </div>
</template>

<script>
export default {
    props: [ 'save', 'editing' ],
}
</script>

<i18n locale="ru" lang="yaml">
    save: "Сохранить"
</i18n>

<i18n locale="en" lang="yaml">
</i18n>
