<template>
  <div class="fixed left-0 top-0 w-full h-full bg-white" :class="opened ? 'block' : 'hidden'">
    <a href="#" class="float-right p-3 text-gray-700 text-xl clearfix" @click.prevent="close()">×</a>
    <iframe class="w-full h-full" id="secureframe"></iframe>
  </div>
</template>

<script>
export default {
    props: [ 'errors' ],
    data() {
      return {
        opened: false,
      }
    },
    mounted() {
      const me = this
      window.closeFrame = () => { 
        me.close() 
        me.$router.push({name: 'subscription'});
      }
      window.closeFrameWithError = (error) => { 
        me.close() 
        me.errors = { response: error }
      }
    },
    methods: {
      open(userId, tariffId, transactionId, url, PaReq) {
        // создать форму и отправить
        var iframe = document.getElementById('secureframe');
        var doc = iframe.contentWindow.document;
        var termUrl = document.location.origin + '/api/subscriptions/'+userId+'/'+tariffId;
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