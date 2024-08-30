const validation = new JustValidate("#registrationCheck");

validation
    .addField("#inputForename", [
        {
            rule: "required"
        }
    ])
    
    .addField("#inputSurname", [
        {
            rule: "required"
        }
    ])

    .addField("#inputUsername", [
        {
            rule: "required"
        },
        {
            validator: (value) => () => {
                return fetch("usernameValidation.php?inputUsername=" + encodeURIComponent(value))
                    .then(function(response){
                        return response.json();
                    })
                    .then(function(json){
                        return json.available;
                    });
            },
            errorMessage: "Username Already Taken"
        }
    ])

    .addField("#inputEmail1",[
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        {
            // Validator to check whether email is exited or no by fetch emailValidation php
            validator: (value) => () => {
                return fetch("emailValidation.php?inputEmail1=" + encodeURIComponent(value))
                    .then(function(response){
                        return response.json();
                    })
                    .then(function(json){
                        return json.available;
                    });
            },
            errorMessage: "Email Already Taken"
        }
    ])
     .addField("#inputEmail2",[
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        {
            validator: (value, fields) => {
                return value === fields["#inputEmail1"].elem.value;
            },
            errorMessage: "Email should match"
        }
    ])
     .addField("#inputNumber",[
        {
            rule: "required"
        },
        {
            rule: 'integer'
        }
    ])
     .addField("#inputPassword1",[
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
     .addField("#inputPassword2",[
        {
            validator: (value, fields) => {
                return value === fields["#inputPassword1"].elem.value;
            },
            errorMessage: "Passwords should match"
        }
    ])
     .onSuccess((event) => {
        document.getElementById("registrationCheck").submit();
    });
