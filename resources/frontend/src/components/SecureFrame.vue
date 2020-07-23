<template>
  <div class="secure-frame" :class="opened ? 'block' : 'hidden'">
    <a href="#" class="close" @click.prevent="close()">×</a>
    <iframe class="" id="secureframe"></iframe>
  </div>
</template>

<script>
export default {
    data() {
      return {
        opened: false,
        message: '',
      }
    },
    mounted() {
      const me = this
      window.closeFrame = () => { 
        me.close() 
        me.$store.dispatch('auth/fetch')
          .then(() => {
            me.$store.dispatch('message/show' , me.message)
            me.$router.push({ name: 'profile' })
          })
      }
      window.closeFrameWithError = (error) => { 
        me.close() 
        me.$store.dispatch('errors/set', { response: error })
      }
    },
    methods: {
      open(userId, tariffId, transactionId, url, PaReq, message) {
        // создать форму и отправить
        this.message = message
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