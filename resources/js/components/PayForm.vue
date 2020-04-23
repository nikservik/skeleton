<template>
  <div class="my-6">
    <div class="mx-auto w-84 p-2 max-w-full border rounded-lg bg-gray-200 border-gray-500">
      <form id="cardform">
        <the-mask mask="#### #### #### #### ###" class="border border-gray-300 py-1 px-2 mt-12 w-full text-lg tracking-widest focus:outline-none" 
          :class="{ 'border-gray-300': !errors['cardNumber'], 'border-red-400': errors['cardNumber'], }"
          autocomplete="cc-number" type="tel" data-cp="cardNumber" 
          :placeholder="$t('card.number')" />
        <div class="flex justify-between mt-2">
          <div class="border border-gray-300 flex items-center bg-white"
            :class="{ 'border-gray-300': !errors['expDateMonth'] && !errors['expDateYear'], 
              'border-red-400': errors['expDateMonth'] || errors['expDateYear'], }">
            <the-mask mask="##" class=" py-1 w-10 text-lg tracking-widest focus:outline-none text-right" autocomplete="cc-exp-month" type="tel" data-cp="expDateMonth" :placeholder="$t('card.expire-month')" />
            <span class="pb-1 pt-px mx-1">/</span>
            <the-mask mask="##" class=" py-1 pr-2 w-8 text-lg tracking-widest focus:outline-none" autocomplete="cc-exp-year" type="tel" data-cp="expDateYear" :placeholder="$t('card.expire-year')" />
          </div>
          <div class="flex justify-end items-center">
            <span class="text-xs text-gray-500 w-16 leading-snug mr-2">{{ $t('card.cvv') }}</span>
            <the-mask mask="###" class="border border-gray-300 py-1 px-2 w-16 text-center text-lg tracking-normal focus:outline-none" 
              :class="{ 'border-gray-300': !errors['cvv'], 'border-red-400': errors['cvv'], }"
              autocomplete="off" type="password" data-cp="cvv" 
              :placeholder="$t('card.cvv-placeholder')" />

          </div>
        </div>
        <input class="border border-gray-300 py-1 px-2 mt-4 w-full text-lg tracking-widest focus:outline-none" 
          :class="{ 'border-gray-300': !errors['name'], 'border-red-400': errors['name'], }" 
          autocomplete="cc-name" type="tel" data-cp="name" 
          :placeholder="$t('card.name')" v-model="cardholder" />
      </form>
    </div>
    <div class="text-red-600 mx-auto w-84 p-2 max-w-full" v-if="hasError()">
      {{ formError() ? $t('errors.form') : $t(errors['response']) }}
    </div>
  </div>
</template>

<script>
import {TheMask} from 'vue-the-mask'

export default {
  props: ['errors'],
  data() {
    return {
      cardholder: '',
    }
  },
  methods: {
    hasError() { return Object.keys(this.errors).length !== 0 },
    formError() { 
      return this.errors['cardNumber'] || this.errors['expDateMonth'] || this.errors['expDateYear'] 
        || this.errors['cvv'] || this.errors['name']
    }
  },
  components: { TheMask }
}
</script>
<i18n locale="ru" lang="yaml">
  errors: 
    form: "Проверьте все данные еще раз"
  card:
    name: "Владелец карты"
    number: "Номер карты"
    expire-month: "ММ"
    expire-year: "ГГ"
    cvv: "Три цифры на обороте"
    cvv-placeholder: "CVC"
</i18n>
<i18n locale="en" lang="yaml">
</i18n>