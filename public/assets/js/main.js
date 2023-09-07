function saveLoop() {
    var savedRecipesCookie = Cookies.get("saved_recipes");
    console.log(savedRecipesCookie);
    if (savedRecipesCookie) {
        var savedRecipes = JSON.parse(savedRecipesCookie);
        if (!Array.isArray(savedRecipes)) {
            savedRecipes = [savedRecipes];
        }

        $(".recipe-card").each(function () {
            var recipeId = $(this).attr("data-recipeId");
            if (savedRecipes.indexOf(recipeId) !== -1) {
                $(this).find(".recipe-card-save").addClass("recipe-card-saved");
            } else {
                $(this).find(".recipe-card-save").removeClass("recipe-card-saved");
            }
        });
    }
}

$(document).ready(function () {
    saveLoop();

    $(".recipe-card-save").on("click", function (event) {
        event.preventDefault();

        savedRecipesCookie = Cookies.get("saved_recipes");

        // check if cookie exists
        if (savedRecipesCookie == undefined) {
            // open login modal
            return $("#loginModal").modal("show");
        }
        
        $.ajax({
            type: "POST",
            url: "/save",
            data: {
                recipe_id: $(this).attr("data-recipeId")
            },
            success: function (data) {
                saveLoop();
            },
            error: function (data) {
                console.log("error saving");
                location.reload();
            }
        });

    });

    jQuery.validator.addMethod("validname", function (value, element) {
        return this.optional(element) || /^[a-zA-Z-]{2,20}$/.test(value);
    }, "Name must be at least 2 characters long, no longer than 20 characters and must contain only letters and hyphens.");

    jQuery.validator.addMethod("validpassword", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/.test(value);
    }, "Must contain at least one number and at least one uppercase and lowercase letter.");

    $("#registrationForm").validate({
        errorClass: "is-invalid",
        rules: {
            first_name: {
                required: true,
                minlength: 2,
                maxlength: 20,
                validname: true
            },
            last_name: {
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
                    //create cookie with saved_recipes
                    var savedRecipes = data.saved_recipes;
                    var savedRecipesCookie = JSON.stringify(savedRecipes);
                    Cookies.set("saved_recipes", savedRecipesCookie);
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

    $("#updateAccount").validate({
        errorClass: "is-invalid",
        rules: {
            first_name: {
                required: true,
                minlength: 2,
                maxlength: 20,
                validname: true
            },
            last_name: {
                required: true,
                minlength: 2,
                maxlength: 20,
                validname: true
            },
            email: {
                required: true,
                email: true
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
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: "/account",
                data: $(form).serialize(),
                success: function (data) {
                    if ($("#updateAccount > #errorAlert").hasClass("d-none") == false) {
                        $("#updateAccount > #errorAlert").toggleClass("d-none");
                    }
                    $("#updateAccount > #successAlert").html("Account updated successfully.");
                    if ($("#updateAccount > #successAlert").hasClass("d-none")) {
                        $("#updateAccount > #successAlert").toggleClass("d-none");
                    }
                    $("#dropdownMenuButton1").html("Welcome " + $("#first_name").val() + "!");
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
                    if ($("#updateAccount > #successAlert").hasClass("d-none") == false) {
                        $("#updateAccount > #successAlert").toggleClass("d-none");
                    }
                    $("#updateAccount > #errorAlert").html($errorMessage);
                    if ($("#updateAccount > #errorAlert").hasClass("d-none")) {
                        $("#updateAccount > #errorAlert").toggleClass("d-none");
                    }
                }
            });
        }
    });

    $("#updatePassword").validate({
        errorClass: "is-invalid",
        rules: {
            password: {
                required: true
            },
            new_password: {
                required: true,
                validpassword: true,
                maxlength: 255,
                minlength: 6
            },
            confirm_new_password: {
                required: true,
                equalTo: "#updatePassword #new_password"
            }
        },
        messages: {
            password: {
                required: "Password is required."
            },
            new_password: {
                required: "New Password is required.",
                maxlength: "New Password must be no longer than 255 characters.",
                minlength: "New Password must be at least 6 characters long.",
                validpassword: "New Password must contain at least one number and at least one uppercase and lowercase letter."
            },
            confirm_new_password: {
                required: "Confirm New Password is required.",
                equalTo: "New Passwords must match."
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: "/account",
                data: $(form).serialize(),
                success: function (data) {
                    if ($("#updatePassword > #errorAlert").hasClass("d-none") == false) {
                        $("#updatePassword > #errorAlert").toggleClass("d-none");
                    }
                    $("#updatePassword > #successAlert").html("Password updated successfully.");
                    if ($("#updatePassword > #successAlert").hasClass("d-none")) {
                        $("#updatePassword > #successAlert").toggleClass("d-none");
                    }
                    //clear all 3 inputs in #updatePassword form
                    $("#updatePassword").reset();
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
                    if ($("#updatePassword > #successAlert").hasClass("d-none") == false) {
                        $("#updatePassword > #successAlert").toggleClass("d-none");
                    }
                    $("#updatePassword > #errorAlert").html($errorMessage);
                    if ($("#updatePassword > #errorAlert").hasClass("d-none")) {
                        $("#updatePassword > #errorAlert").toggleClass("d-none");
                    }
                }
            });
        }
    });


});