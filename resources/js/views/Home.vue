<template>
  <div>
    <h1 class="page-header">{{ $t('pageTitle') }}</h1>

    <div class="py-6 mx-4">
        Эта страница видна всем – и авторизованным, и не авторизованным.
    </div>
    {{ $t('test') }}
  </div>
</template>

<script>
import LocaleMixin from '@/components/LocaleMixin'

export default {
    mixins: [LocaleMixin],
    mounted() {
        this.addToLocale('test', {ru:'sss',en:'ttt'})
    }
}
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Добро пожаловать"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Welcome"
</i18n>
