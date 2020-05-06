<template>
    <div>
        <div class="block" @click="$router.push({ name: 'oferta' })">
            <div class="title">
                <IconFile height="20" classes="settings-icon vertical-center" />
                <div>{{ $t('history') }}</div>
            </div>
            <div class="value">
                    <IconRightChevron height="16" classes="vertical-center ml-auto" />
            </div>
        </div>
    </div>
</template>

<script>
import IconRightChevron from '@/components/visual/icons/IconRightChevron'
import IconFile from '@/components/visual/icons/IconFile'

export default {
    components: { IconRightChevron, IconFile },
}
</script>

<i18n locale="ru" lang="yaml">
    history: "Публичная оферта"
</i18n>

<i18n locale="en" lang="yaml">
    history: "User Agreement"
</i18n>
