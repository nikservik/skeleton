<template>
  <div class="subscription-switch">
    <div class="title">
      {{ $t('swithcing', { to: $t('tariffs.' + to.slug) }) }}
    </div>

    <div class="text" 
      v-html="$t('warning.' + fromToType, {
        period: $t('periods.' + to.period),
        expire: localizeNext,
        'less-more': lessMore,
      })">
    </div>

    <TariffSwitchAction :from="from" :to="to" />
  </div>
</template>

<script>
import TariffSwitchAction from '@/views/user/TariffSwitchAction'
import { mapState } from 'vuex'

  export default {
    props: [ 'from', 'to' ],
    components: { TariffSwitchAction },
    methods: {
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
    },
    computed: {
        fromToType() {
          return this.getType(this.from) + '-to-' + this.getType(this.to)
        },
        localizeNext() {
          return this.from.next_transaction_date 
            ? this.$d(new Date(this.from.next_transaction_date), 'short') : ''
        },
        lessMore() {
          if (this.from.period.includes('month') && this.to.period.includes('year'))
            return this.$t('more')
          if (this.from.period.includes('year') && this.to.period.includes('month'))
            return this.$t('less')
        },
    },
  }
</script>

<i18n locale="ru" lang="yaml">
  swithcing: "Вы собираетесь сменить тарифный план на «{to}»"
  less: "менее"
  more: "более"
  warning:
    free-to-free: "За этот тарифный план вам не придется платить. <p>Посмотрите, какие возможности в нем добавятся, а какие исчезнут.</p>"

    free-to-trial: "На этом тарифном плане вы бесплатно можете попробовать и оценить платные возможности. Он будет активен только {period}. <p>Если до конца этого срока вы не решите перейти на платный тариф, то автоматически переключитесь на бесплатный.</p>"

    free-to-paid: "Этот тарифный план открывает доступ к платным возможностям. <p>Подписка продлевается автоматически. Это значит, что вам нужно оплатить только первый {period}, а все следующие платежи будут автоматически списываться с карты, которую вы укажете при оплате.</p> <p>Вы сможете отменить подписку в любой момент у себя в профиле.</p>"

    trial-to-free: "Вы собираетесь отменить пробный тарифный план. <p>Внимание! Все возможности текущего тарифного плана отключатся при переходе на новый.</p>"

    trial-to-paid: "Этот тарифный план открывает доступ к платным возможностям. <p>Подписка продлевается автоматически. Это значит, что вам нужно оплатить только первый {period}, а все следующие платежи будут списываться с карты, которую вы укажете при оплате. <p>Действие платного тарифа начнется только после окончания пробного, то есть после {expire}</p> <p>Вы сможете отменить подписку в любой момент у себя в профиле.</p>"

    paid-to-free: "Вы собираетесь отменить платный тарифный план. <p>Если вы отмените подписку, то все его возможности отключатся {expire} Деньги больше не будут списываться с вашей карты.</p>"

    paid-to-paid: "Вы собираетесь перейти на {less-more} выгодный тарифный план. <p>У вас уже есть предоплаченный период, который заканчивается {expire} Мы зачислим неиспользованный остаток в оплату нового тарифного плана.</p>"

    hidden-to-free: "За этот тарифный план вам не придется платить. <p>Внимание! Все возможности текущего тарифного плана отключатся при переходе на новый.</p>"

    hidden-to-trial: "На этом тарифном плане вы бесплатно можете попробовать и оценить платные возможности. <p>Он будет активен только {period}. Если до конца этого срока вы не решите перейти на платный тариф, то автоматически переключитесь на бесплатный.</p> <p>Внимание! Все возможности текущего тарифного плана отключатся при переходе на новый.</p>"

    hidden-to-paid: "Этот тарифный план открывает доступ к платным возможностям. <p>Подписка продлевается автоматически. Это значит, что вам нужно оплатить только первый {period}, а все следующие платежи будут списываться с карты, которую вы укажете при оплате.</p> <p>Вы сможете отменить подписку в любой момент у себя в профиле.</p>"
</i18n>

<i18n locale="en" lang="yaml">
  swithcing: "You are going to switch to \"{to}\""
</i18n>
