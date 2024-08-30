<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6Lfavx4pAAAAAEYRRuRcbg6Mdusz2DbtiJ6TEgrs"></script>
    <link rel="stylesheet" href="../CompSecAssignment/style.css">
</head>

<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div class="fileupload">
            <h2>Upload File</h2>
            <i>Please Upload a Photo of The Object<br><br></i>
            <input type="text" name="name" id="name" placeholder="Name Your File" required>
            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
            <input type="hidden" name="token_generate" id="token_generate">
            <button type="submit" name="submit">Submit</button>
            <br>
            <p><a href=" ../CompSecAssignment/index.php">Back</a></p>
        </div>
    </form>
</body>

</html>

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