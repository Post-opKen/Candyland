/*
* Ean Daus
* 3/13/19
* signUpVal.js
* Event handlers for inline form validation in signUp.html
*/

//when the name field loses focus
$("#name").on("blur change", function () {
    //load output from validateUsername.php
    $("#userMessage").load('model/validateUsername.php', {username: $("#name").val()});
});

//when the password field gains focus
$("#pass").on("focus", function () {
    //display criteria message
    $("#passMessage").html('<p class="text-primary">Between 8 and 15 characters, must contain upper and lowercase letters, and numbers.</p>');
});

//when the password field loses focus
$("#pass").on("blur", function () {
    //get the password, define regex
    let pass = $("#pass").val();
    let regex = RegExp('^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}$', 'g');

    //test the password against regex
    if (regex.test(pass)) {
        //display success message
        $("#passMessage").html('<p class="text-success">Between 8 and 15 characters, must contain upper and lowercase letters, and numbers.</p>');
    } else {
        //display error message
        $("#passMessage").html('<p class="text-danger">Between 8 and 15 characters, must contain upper and lowercase letters, and numbers.</p>');
    }
});