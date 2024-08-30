<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6Lfavx4pAAAAAEYRRuRcbg6Mdusz2DbtiJ6TEgrs"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>Forgot Password</h1>

    <form action="passwordResetValidation.php" method="post">

        <div>
            <input type="email" name="inputEmail" id="inputEmail" placeholder="Email Address">
            <input type="hidden" name="token_generate" id="token_generate">
        </div>

        <button>Send</button>

    </form>

</body>

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