<template>
  <div class="fixed left-0 top-0 w-full h-full max-h-screen bg-white dark:bg-gray-800 pb-75" :class="opened ? 'block' : 'hidden'">
    <a href="#" class="float-right p-11 text-gray-700 dark:text-gray-300 text-xl clearfix" @click.prevent="close()">×</a>
    <iframe class="w-full h-full pb-50" id="secureframe"></iframe>
  </div>
</template>

<script>
export default {
    data() {
      return {
        opened: false,
      }
    },
    mounted() {
      const me = this
      window.closeFrame = () => { 
        me.close() 
        me.$store.dispatch('auth/fetch')
          .then(() => {
            me.$router.push({ name: 'profile' })
          })
      }
      window.closeFrameWithError = (error) => { 
        me.close() 
        me.$store.dispatch('errors/set', { response: error })
      }
    },
    methods: {
      open(userId, tariffId, transactionId, url, PaReq) {
        // создать форму и отправить
        var iframe = document.getElementById('secureframe');
        var doc = iframe.contentWindow.document;
        var termUrl = document.location.origin + '/api/subscriptions/'+userId;
        if (tariffId)
          termUrl += '/'+tariffId
        doc.open().write(
          '<body onload="document.getElementById(\'iframeform\').submit()">' +
          '<form id="iframeform" action="' + url + '" method="POST">' +
          '<input type="hidden" name="PaReq" value="' + PaReq + '">' +
          '<input type="hidden" name="MD" value="' + transactionId + '">' +
          '<input type="hidden" name="TermUrl" value="' + termUrl + '">' +
          '</form>' 
        );
        doc.close();
        this.opened = true;
      },
      close() {
        this.opened = false
        document.getElementById('secureframe').src = ''
      }
    }
}
</script>