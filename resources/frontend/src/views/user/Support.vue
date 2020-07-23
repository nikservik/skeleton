<template>
    <Page type="no-helpers">
        <PageHeader back="dashboard">
            {{ $t('pageTitle') }}
        </PageHeader>
        <div class="page-icon">
            <IconSupport classes="mx-auto" height="75" />
        </div>

        <div class="flex items-end">
          <div v-if="messages" class="support-messages w-full md:w-1/2 md:pb-75">
            <div v-for="message in messages.slice().reverse()" 
              :key="message.id" class="support-message" 
              :class="message.type == 'userMessage' ? 'user' : 'admin'">
              <div class="info">
                {{ format(new Date(message.created_at), 'dd.MM.yyyy HH:mm') }}
              </div>
              <div class="message" v-html="message.message"></div>
            </div>
          </div>
          <div class="hidden md:block md:w-1/2">
            <SupportForm />
          </div>
        </div>


        <template v-slot:bottom>
          <SupportForm class="md:hidden" />
        </template>
    </Page>
</template>
<script>
import { format } from 'date-fns'
import IconSupport from '@/components/visual/icons/IconSupport'
import Page from '@/components/visual/Page'
import PageHeader from '@/components/visual/PageHeader'
import SupportForm from '@/components/visual/SupportForm'
import { mapState } from 'vuex'

export default {
    components: { IconSupport, Page, PageHeader, SupportForm },
    data() {
      return {
        message: '',
        format: undefined,
      }
    },
    created() {
      this.format = format
    },
    mounted() {
      this.$store.dispatch('support/load')
        .then(() => {
          setTimeout(() => { window.scrollTo(0,document.body.scrollHeight) }, 100)
        })
    },
    methods: {
    },
    computed: {
        ...mapState('support', {
            messages: state => state.messages
        }),
    }
  }
</script>

<i18n locale="ru" lang="yaml">
  pageTitle: "Отдел заботы"
</i18n>

<i18n locale="en" lang="yaml">
  pageTitle: "Service desk"
</i18n>
