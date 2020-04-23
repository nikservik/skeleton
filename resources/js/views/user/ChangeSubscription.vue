<template>
    <div>
        <h1 class="page-header">{{ $t('pageTitle') }}</h1>

        <div class="flex flex-wrap my-4">
          <div class="md:w-1/2 w-full my-2" v-for="(tariff, index) in tariffs" v-if="canSee(tariff)">
            <div class="mx-2 rounded-lg p-2 h-full"
              :class="{
                'text-gray-500 border': isActive(tariff) || cantUse(tariff),
                'border-gray-300 bg-gray-100' : cantUse(tariff), 
                'border-red-400 text-red-500 bg-red-100' : isActive(tariff),
                'border-gray-700 border cursor-pointer' : !isActive(tariff) && !cantUse(tariff) && index != selected,
                'border-blue-600 text-blue-600 bg-blue-100 border-2' : index == selected
              }"  @click="select(index)">
              <div class="float-right">
                <span class="" v-if="index == selected && !tariffs[selected].default">
                  {{ $t('state.selected') }}</span>
                <span class="" v-if="index == selected && tariffs[selected].default 
                  && $auth.user().subscription.status == 'Cancelled'">{{ $t('state.default') }}</span>
                <span class="text-red-600" v-if="isActive(tariff)">{{ $t('state.active') }}</span>
                <span class="" v-if="cantUse(tariff) && ! isActive(tariff)">{{ $t('state.unavailable') }}</span>
              </div>
              <h3 class="font-bold text-lg">{{ $t('name'+index) }}</h3>
              <div class="mx-2" v-if="canExpire(tariff)">
                {{ $t('expire', { date: localizeDate($auth.user().subscription.next_transaction_date) }) }}
              </div>
              <div class="mt-2"  v-if="!isActive(tariff) && !cantUse(tariff)">
                <div class="mx-2" v-if="tariff.price > 0">
                  {{ tariff.price + ' ' + $t('currency.'+tariff.currency) + 
                  ' / ' + $t('periods.'+tariff.period) }}
                </div>
                <div class="mx-2" v-if="isTrial(tariff)">
                  {{ $t('periods.'+tariff.period) }}
                </div>
                <ul class="mt-2 mx-2 list-disc list-inside">
                  <span class="block" v-for="feature in allFeatures" 
                    v-if="featureChanged(feature, tariff)" 
                    :class="{ 'line-through': featureSign(feature, tariff) == '-' }">
                    {{ featureSign(feature, tariff) }} {{ $t('features.'+feature) }}
                  </span>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="mx-4 md:mx-8" v-if="selected !== undefined 
          && (nextAction() != 'cancel' 
              || (nextAction() == 'cancel' && $auth.user().subscription.status != 'Cancelled')) ">
          <h2 class="mt-6 -mx-2 px-2 border-b-2 border-blue-500">{{ $t('warning.title') }}</h2>

          <div class="mx-2 my-4">
            {{ $t('warning.'+getType($auth.user().subscription)+'-to-'+getType(tariffs[selected]), {
                period: $t('periods.'+tariffs[selected].period), 
                expire: localizeDate($auth.user().subscription.next_transaction_date),
            } ) }}
          </div>

          <div class="-mx-2" v-if="nextAction() == 'pay' && getType($auth.user().subscription) != 'paid'">
            <PayForm ref="payform" :errors="errors" />
          </div>

          <div class="mx-2 mb-6 text-center" v-if="nextAction() == 'cancel'">
            <button class="text-white font-bold px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 focus:outline-none" 
              @click="cancel()">{{ $t('button.cancel') }}</button>
          </div>
          <div class="mx-2 mb-6 text-center" v-if="nextAction() == 'activate'">
            <button class="text-white font-bold px-4 py-2 rounded-lg bg-blue-500 hover:bg-blue-700 focus:outline-none" 
              @click="activateFree(tariffs[selected])">{{ $t('button.activate') }}</button>
          </div>
          <div class="mx-2 mb-6 text-center" v-if="nextAction() == 'pay'">
            <button class="text-white font-bold px-4 py-2 rounded-lg bg-blue-500 hover:bg-blue-700 focus:outline-none" 
              @click="pay(tariffs[selected])" :disabled="!cpLoaded">{{ $t('button.pay') }}</button>
          </div>
        </div>
      <SecureFrame ref="secureframe" :errors="errors" />
    </div>
</template>
<script>
import LocaleMixin from '@/components/LocaleMixin'
import PayForm from '@/components/PayForm'
import SecureFrame from '@/components/SecureFrame'

  export default {
    mixins: [LocaleMixin],
    components: { PayForm, SecureFrame },
    data() {
      return {
        tariffs: [],
        allFeatures: undefined,
        cpLoaded: false,
        selected: undefined,
        checkout: undefined,
        crypt: '',
        errors: {},
      }
    },
    methods: {
      canSee(tariff) {
        if (this.isActive(tariff)) return true
        if (! tariff.visible) return false
        if (this.cantUse(tariff)) return false
        return true
      },
      cantUse(tariff) {
        if (this.isTrial(tariff) && this.$auth.user().hadTrial) return true
        if (this.isTrial(tariff) && this.isTrial(this.$auth.user().subscription)) return true
        if (this.$auth.user().subscription.price > 0 && this.isTrial(tariff)) return true
        return false
      },
      select(index) {
        if (! this.isActive(this.tariffs[index]) && ! this.isTrial(this.tariffs[index]))
          this.selected = index
      },
      isActive(tariff) { return tariff.id == this.$auth.user().subscription.tariff_id },
      isFree(tariff) { return tariff.price == 0 },
      isPaid(tariff) { return tariff.price > 0 },
      isTrial(tariff) { return tariff.price == 0 && ! tariff.prolongable && tariff.period != 'endless'},
      isHidden(tariff) { return tariff.price == 0 && tariff.visible == false },
      getType(tariff) {
        if (this.isHidden(tariff)) return 'hiddden'
        if (this.isPaid(tariff)) return 'paid'
        if (this.isTrial(tariff)) return 'trial'
        return 'free'
      },
      canExpire(tariff) {
        return this.isActive(tariff) 
          && (tariff.price == 0 && ! tariff.prolongable && tariff.period != 'endless' 
            || this.$auth.user().subscription.status == 'Cancelled')
      },
      featureChanged(feature, tariff) { 
        return tariff.features.includes(feature) 
          != this.$auth.user().subscription.features.includes(feature)
      },
      featureSign(feature, tariff) {
        if (tariff.features.includes(feature) 
          && ! this.$auth.user().subscription.features.includes(feature))
          return '+'
        if (! tariff.features.includes(feature) 
          && this.$auth.user().subscription.features.includes(feature))
          return '-'
        return '&nbsp;'
      },
      nextAction() {
        const current = this.getType(this.$auth.user().subscription)
        const next = this.getType(this.tariffs[this.selected]) 
        if (next == 'paid')
          return 'pay'
        if (next == 'free' && (current == 'paid' || current == 'trial'))
          return 'cancel'
        return 'activate'
      },
      activateFree(tariff) {
        this.$http.post('/subscriptions', { tariff: tariff.id})
        .then(response => {
          this.$root.$auth.user().subscription = response.data.data.subscription
          this.$router.push({name: 'subscription'});
        })
      },
      cancel() {
        this.$http.post('/subscriptions/cancel')
        .then(response => {
          this.$root.$auth.user().subscription = response.data.data.subscription
          this.$router.push({name: 'subscription'});
        })
      },
      localizeDate(date) { return date ? this.$d(new Date(date), 'short') : '' },
      loadCP() {
        this.$loadScript('https://widget.cloudpayments.ru/bundles/checkout')
          .then(() => { 
            this.cpLoaded = true 
          })
      },
      initCheckout() {
        if(! this.checkout)
          this.checkout = new cp.Checkout(
            'pk_4ac2f7a43a9f5f3167e2396048810', 
            document.getElementById("cardform")
          )
      },
      createCrypt() {
        if (! this.cpLoaded) return

        this.initCheckout()
        this.crypt = ''
        this.errors = {}
        var result = this.checkout.createCryptogramPacket();
        if (result.success) 
          this.crypt = result.packet
        else
          this.errors = result.messages
      },
      open3ds(tariff, data) {
        this.$refs.secureframe.open(this.$auth.user().id, tariff.id, 
          data.TransactionId, data.AcsUrl, data.PaReq)
      },
      pay(tariff) {
        this.createCrypt()
        if (! this.crypt) return

        this.$http.post('/subscriptions/crypt', { 
          tariff: tariff.id,
          name: this.$refs.payform.cardholder,
          crypt: this.crypt 
        })
        .then(response => {
          console.log(response.data)
          if (response.data.status == 'error') 
            this.errors = { response: response.data.message }
          if (response.data.status == 'need3ds') 
            this.open3ds(tariff, response.data.data)
          if (response.data.status == 'success') {
            this.$root.$auth.user().subscription = response.data.data.subscription
            this.$router.push({name: 'subscription'});
          }
        })
      },
    },
    mounted() {
        this.$http.get('/subscriptions')
        .then(response => {
          this.tariffs = response.data.data.subscriptions;
          this.tariffs.forEach((tariff, index) => {
            if (this.$auth.user().subscription.status == 'Cancelled' && tariff.default)
              this.selected = index
            this.addToLocale('name'+index, tariff.name)
          })
        })
        this.$http.get('/subscriptions/translations')
        .then(response => {
          this.allFeatures = Object.keys(response.data.data.features)
          for (let [feature, translations] of Object.entries(response.data.data.features))
            this.addToLocale('features.'+feature, translations)
          for (let [period, translations] of Object.entries(response.data.data.periods))
            this.addToLocale('periods.'+period, translations)
        })
        this.loadCP()
    },
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Смена тарифного плана"
  features: 
    title: "Возможности"
  currency:
    RUB: "рублей"
  expire: "Закончится {date}"
  state:
    unavailable: "Недоступен"
    selected: "Выбран"
    active: "Активный"
    default: "Включится"
  button:
    activate: "Включить"
    pay: "Оплатить"
    cancel: "Отменить"
  warning:
    title: "Переключение"
    free-to-free: "За этот тарифный план вам не придется платить. Посмотрите, какие возможности в нем добавятся, а какие исчезнут."
    free-to-trial: "На этом тарифном плане вы бесплатно можете попробовать и оценить платные возможности. Он будет активен только {period}. Если до конца этого срока вы не решите перейти на платный тариф, то автоматически переключитесь на бесплатный."
    free-to-paid: "Этот тарифный план открывает доступ к платным возможностям. Подписка продлевается автоматически. Это значит, что вам нужно оплатить только первый период ({period}), а все следующие платежи будут автоматически списываться с карты, которую вы укажете при оплате. Вы сможете отменить подписку в любой момент у себя в профиле."
    trial-to-free: "Вы собираетесь отменить пробный тарифный план. Внимание! Все возможности текущего тарифного плана отключатся при переходе на новый."
    trial-to-paid: "Этот тарифный план открывает доступ к платным возможностям. Подписка продлевается автоматически. Это значит, что вам нужно оплатить только первый период ({period}), а все следующие платежи будут списываться с карты, которую вы укажете при оплате. Действие платного тарифа начнется только после окончания пробного, то есть после {expire} Вы сможете отменить подписку в любой момент у себя в профиле."
    paid-to-free: "Вы собираетесь отменить платный тарифный план. Если вы отмените подписку, то все его возможности отключатся {expire} Деньги больше не будут списываться с вашей карты."
    paid-to-paid: "Вы собираетесь перейти на {less-more} выгодный тарифный план. У вас уже есть предоплаченный период, который заканчивается {expire} Мы зачислим неиспользованный остаток в оплату нового тарифного плана."
    hidden-to-free: "За этот тарифный план вам не придется платить. Внимание! Все возможности текущего тарифного плана отключатся при переходе на новый."
    hidden-to-trial: "На этом тарифном плане вы бесплатно можете попробовать и оценить платные возможности. Он будет активен только {period}. Если до конца этого срока вы не решите перейти на платный тариф, то автоматически переключитесь на бесплатный. Внимание! Все возможности текущего тарифного плана отключатся при переходе на новый."
    hidden-to-paid: "Этот тарифный план открывает доступ к платным возможностям. Подписка продлевается автоматически. Это значит, что вам нужно оплатить только первый период ({period}), а все следующие платежи будут списываться с карты, которую вы укажете при оплате. Вы сможете отменить подписку в любой момент у себя в профиле."
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "My subscription"
  features: 
    title: "Features"
  type:
    free: "Free"
    paid: "Paid"
    trial: "Trial"
  currency:
    RUB: "RUB"
  expire: "Will expire {date}"
  button:
    activate: "Activate"
    pay: "Pay"
    cancel: "Cancel"
    active: "Active"
</i18n>
