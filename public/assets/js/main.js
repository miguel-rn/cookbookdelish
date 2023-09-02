$(document).ready(function () {
    // Adds custom validation method to jquery-validation to validate name fields.
    // Name fields must be at least 2 characters long, no longer than 20 characters and must contain only letters and hyphens.
    jQuery.validator.addMethod("validname", function (value, element) {
        return this.optional(element) || /^[a-zA-Z-]{2,20}$/.test(value);
    }, "Name must be at least 2 characters long, no longer than 20 characters and must contain only letters and hyphens.");


    // Adds custom validation method to jquery-validation.
    // This method validates that password field contains at least one number and at least one uppercase and lowercase letter.
    jQuery.validator.addMethod("validpassword", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/.test(value);
    }, "Must contain at least one number and at least one uppercase and lowercase letter.");

    // Use jquery-validation to validate the #registrationForm form client-side.
    // Fields are firstName, lastName, email, password, confirmPassword, acceptTerms.
    // If the form is valid, an AJAX request is sent to the server to register the user.
    // If the request is successful, the current page will be seemlessly reloaded and a session created.
    // If the request is unsuccessful, the error message will be displayed in the #errorAlert div.

    $("#registrationForm").validate({
        errorClass: "is-invalid",
        rules: {
            first_name: {
                required: true,
                minlength: 2,
                maxlength: 20,
                validname: true
            },
            first_name: {
                required: true,
                minlength: 2,
                maxlength: 20,
                validname: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                validpassword: true,
                maxlength: 255,
                minlength: 6
            },
            confirmPassword: {
                equalTo: "#registrationForm #password"
            },
            acceptTerms: {
                required: true
            }
        },
        messages: {
            first_name: {
                required: "First name is required.",
                minlength: "First name must be at least 2 characters long.",
                maxlength: "First name must be no longer than 20 characters.",
                validname: "First name must contain only letters and hyphens."
            },
            last_name: {
                required: "Last name is required.",
                minlength: "Last name must be at least 2 characters long.",
                maxlength: "Last name must be no longer than 20 characters.",
                validname: "Last name must contain only letters and hyphens."
            },
            email: {
                required: "Email is required.",
                email: "Email must be a valid email address."
            },
            password: {
                required: "Password is required.",
                maxlength: "Password must be no longer than 255 characters.",
                minlength: "Password must be at least 6 characters long.",
                validpassword: "Password must contain at least one number and at least one uppercase and lowercase letter."
            },
            confirmPassword: {
                equalTo: "Passwords must match."
            },
            acceptTerms: {
                required: "You must accept the terms and conditions."
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: "/register",
                data: $(form).serialize(),
                success: function (data) {
                    location.reload();
                },
                error: function (data) {
                    // Display proper error message in the #errorAlert.
                    var $errorMessage = "";
                    if (data.responseJSON.messages instanceof Object) {
                        for (var key in data.responseJSON.messages) {
                            $errorMessage += data.responseJSON.messages[key] + "<br>";
                        }
                    } else if (data.responseJSON.messages instanceof String) {
                        $errorMessage = data.responseJSON.messages;
                    }
                    $("#registrationForm > #errorAlert").html($errorMessage);
                    $("#registrationForm > #errorAlert").toggleClass("d-none");
                }
            });
        }
    });

    // Use jquery-validation to validate the #loginForm form client-side.
    // Fields are email and password.

    $("#loginForm").validate({
        errorClass: "is-invalid",
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
            }
        },
        messages: {
            email: {
                required: "Email is required.",
                email: "Email must be a valid email address."
            },
            password: {
                required: "Password is required.",
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: "/login",
                data: $(form).serialize(),
                success: function (data) {
                    location.reload();
                },
                error: function (data) {
                    // Display proper error message in the #errorAlert.
                    var $errorMessage = "";
                    if (data.responseJSON.messages instanceof Object) {
                        for (var key in data.responseJSON.messages) {
                            $errorMessage += data.responseJSON.messages[key] + "<br>";
                        }
                    } else if (data.responseJSON.messages instanceof String) {
                        $errorMessage = data.responseJSON.messages;
                    }
                    $("#loginForm > #errorAlert").html($errorMessage);
                    $("#loginForm > #errorAlert").toggleClass("d-none");
                    // Clear password field
                    $("#loginForm #password").val("");
                }
            });
        }
    });
});