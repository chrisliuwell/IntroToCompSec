 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Assignment</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
     <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
     <script src="../CompSecAssignment/js/validation.js" defer></script>
     <script src="https://www.google.com/recaptcha/api.js?render=6Lfavx4pAAAAAEYRRuRcbg6Mdusz2DbtiJ6TEgrs"></script>
     <script src="../CompSecAssignment/js/script.js"></script>
     <link rel="stylesheet" href="style.css">
 </head>

 <body>
     <div>
         <!-- //Novalidate used to validate the data entered in the form to check whether it is empty or no  -->
         <form action="registrationCheck.php" method="post" id="registrationCheck" novalidate>
             <h1>User Registration</h1>

             <div>
                 <input type="text" name="inputForename" id="inputForename" placeholder="Forename">
             </div>

             <div>
                 <input type="text" name="inputSurname" id="inputSurname" placeholder="Surname">
             </div>

             <div>
                 <input type="text" name="inputUsername" id="inputUsername" placeholder="Username">
             </div>

             <div>
                 <input type="text" name="inputEmail1" id="inputEmail1" placeholder="Email Address">
             </div>

             <div>
                 <input type="text" name="inputEmail2" id="inputEmail2" placeholder="Confirm Email Address">
             </div>

             <div>
                 <input type="tel" name="inputNumber" id="inputNumber" placeholder="Phone Number">
             </div>

             <div>
                 <input type="password" name="inputPassword1" id="inputPassword1" placeholder="Password">
             </div>

             <div>
                 <input type="password" name="inputPassword2" id="inputPassword2" placeholder="Confirm Password">
             </div>

             <input type="hidden" name="token_generate" id="token_generate">

             <button>Sign Up</button>

             <p>Already have an account? <a href="login.php">Sign In</a></p>

         </form>
     </div>
 </body>

 </html>

 <script>
     grecaptcha.ready(function() {
         grecaptcha.execute('6Lfavx4pAAAAAEYRRuRcbg6Mdusz2DbtiJ6TEgrs', {
             action: 'submit'
         }).then(function(token) {

             var response = document.getElementById('token_generate');
             response.value = token;

         });
     });
 </script>