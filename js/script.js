<script>
  grecaptcha.ready(function() {
    grecaptcha.execute('6Lfavx4pAAAAAEYRRuRcbg6Mdusz2DbtiJ6TEgrs', {
      action: 'submit'
    }).then(function(token) {

      var response = document.getElementById('token_generate');
      response.value = token;

    })
  })
</script>