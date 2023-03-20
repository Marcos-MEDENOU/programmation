let validation = document.getElementById("validation_inscription");

document.addEventListener("DOMContentLoaded", () => {
validation.addEventListener("click", (e) => {
    e.preventDefault();
    let email = document.getElementById("email").value;
    let pseudo = document.getElementById("pseudo").value;
    let password = document.getElementById("password").value;
    let confirm = document.getElementById("confirm_pass").value;

    if((email !== "") && (pseudo !== "") && (password !== "") && (confirm !== ""))
    {
        if(password === confirm)
        {
            let data = {
                email: email,
                pseudo: pseudo,
                password: password,
                confirm: confirm
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("/[c9fu1geqtXTszR0gTwxPrWOajaxDGZnqKYv1WuKQz979E0c]/user-controller~verifyInputs", option).then(response => response.json()).then(response  => {
                // console.log(response);
                if(response == "valid_input")
                {
                    fetch("/[c9fu1geqtXTszR0gTwxPrWOajaxDGZnqKYv1WuKQz979E0c]/user-controller~verifyEmail", option).then(response => response.json()).then(response  => {
                        if(response == "email_valid")
                        {
                            fetch("/[c9fu1geqtXTszR0gTwxPrWOajaxDGZnqKYv1WuKQz979E0c]/user-controller~verifyPassword", option).then(response => response.json()).then(response  => {
                                console.log(response);
                                if(response == "password_identique")
                                {
                                    fetch("/[c9fu1geqtXTszR0gTwxPrWOajaxDGZnqKYv1WuKQz979E0c]/user-controller~passWord", option).then(response => response.json()).then(response  => {
                                        console.log(response);
                                        if(response == "password_respect")
                                        {

                                        } else
                                        {
                                            console.log("Le mot de passe ne respect le format pré-définis!!");
                                        }
                                        // window.location.href = response;
                                    })
                                } else {
                                    console.log("Les mots de passe ne sont pas conformes!!");
                                }
                            })
                        } else {
                            console.log("L'email n'est pas correct!!");
                        }
                    })
                } else {
                    console.log("Remplissez tous les champs!!");
                }
                
            });
        }
    }
})
})