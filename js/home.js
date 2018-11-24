$(document).ready(function() {
  $('.form').find('input, select, textarea').on('keyup blur focus', function (e) {
    
    var $this = $(this),
        label = $this.prev('label');

  	  if (e.type === 'keyup') {
  			if ($this.val() === '') {
            resetLabel(label);
            label.removeClass('active highlight');
          } else {
            credentialRequirements(label);
            label.addClass('active highlight');
          }
      } else if (e.type === 'blur') {
      	if( $this.val() === '' ) {
          resetLabel(label);
      		label.removeClass('active highlight'); 
  			} else {
          credentialRequirements(label);
  		    label.removeClass('highlight');   
  			}   
      } else if (e.type === 'focus') {
        
        if( $this.val() === '' ) {
          resetLabel(label);
      		label.removeClass('highlight'); 
  			} 
        else if( $this.val() !== '' ) {
          credentialRequirements(label);
  		    label.addClass('highlight');
  			}
      }

  });

  $('.tab a').on('click', function (e) {
    
    e.preventDefault();
    
    $(this).parent().addClass('active');
    $(this).parent().siblings().removeClass('active');
    
    target = $(this).attr('href');

    $('.tab-content > div').not(target).hide();
    
    $(target).fadeIn(600);
    
  });

  $('.formDropDown').on('click', function (e) {
    $(this).prev().addClass('active highlight');
  });

  $('.button').on('click', function(e) {
     var selector = $(this);
     if(!validate(e, selector)) {
        e.preventDefault();
     }
  });

  $('#usernameInput').on('change', function() {
    checkAvailability();
    if($("#usernameInput").val().length < 5 || $("#usernameInput").val().length > 10) {
      $("#usernameLabel").text("Username must be alphanumeric between 6 and 10 characters.");
    }
  });

  function checkAvailability() {
    jQuery.ajax({
    url: "check_availability.php",
    data:'username='+$("#usernameInput").val(),
    type: "POST",
    success:function(data){
      $("#usernameLabel").html(data);
    },
    error:function (){}
    });
}


  function credentialRequirements(selector) {
        var id = $(selector).attr("id");
        if(id === "usernameLabel") {
          $(selector).text("Username must be lowercase alphanumeric between 6 and 10 characters.");
        }
        else if(id === "passwordLabel") {
          $(selector).text("Password must be at least 8 characters and contain upper and lower case letter and number.");
        }
         
  }

  function resetLabel(selector) {
    var id = $(selector).attr("id");
        if(id === "usernameLabel") {
          $(selector).html('Username<span class="req">*</span>');
        }
        else if(id === "passwordLabel") {
          $(selector).html('Password<span class="req">*</span>');
        }
  }

  function validate(event, selector) {
    var validationComplete = false;
    var id = $(selector).attr("id");
    var passwordDiv = $(selector).prev();
    var userNameDiv = $(passwordDiv).prev();

    var userNameInput = $(userNameDiv).find('input').val();
    var userLabel = $("#usernameLabel").text();
    var passwordInput = $(passwordDiv).find('input').val();
    var divArray;

    if(id === "createButton") {
        var nameDiv = $(userNameDiv).prev();
        var firstNameDiv = $(nameDiv).find("#firstNameDiv");
        var lastNameDiv = $(nameDiv).find("#lastNameDiv");
        var infoDiv = $(nameDiv).prev();
        var accountDiv = $(infoDiv).find("#accountDiv");
        var emailDiv = $(infoDiv).find("#emailDiv");
        var emailInput = $(emailDiv).find('input').val();
        divArray = [accountDiv, emailDiv, firstNameDiv, lastNameDiv, userNameDiv, passwordDiv];

        if(!validateRequiredFieldsAreNonEmpty(event, divArray)) {
          alert("Please fill all required fields.");
          return validationComplete;
        }
        else {
          var validatedUsername = validateUsername(event, userNameInput, userLabel);
          var validatedPassword = validatePassword(event, passwordInput);
          var validatedEmail = validateEmail(event, emailInput);
          if (!validatedUsername || !validatedPassword || !validatedEmail) {
            alert("Invalid username, password, and/or e-mail address.");
            return validationComplete;
          }
        }
    }
    else {
      divArray = [userNameDiv, passwordDiv]
      if(!validateRequiredFieldsAreNonEmpty(event, divArray)) {
        alert("Please fill all required fields.");
        return validationComplete;
      }
      else {
        var validatedUsername = validateUsername(event, userNameInput, userLabel);
        var validatedPassword = validatePassword(event, passwordInput);
        if (!validatedUsername || !validatedPassword) {
          alert("Invalid username or password.");
          return validationComplete;
        }
      }
    }

    validationComplete = true;
    return validationComplete;
  }


  function validateRequiredFieldsAreNonEmpty(event, divArray) {
    var allFieldsAreNonEmpty = true;
    var input;
    jQuery.each(divArray, function( i, val ) {
      if($(this).find('select').length > 0) {
        input = $(this).find('select').val();
      }
      else {
        input = $(this).find('input').val();
      }

      if(input.length == 0) {
        allFieldsAreNonEmpty = false;
        if($(this).find('select').length > 0) {
          $(this).find('select').focus();
        }
        else {
          $(this).find('input').focus();
        }
      }
 
    });

    return allFieldsAreNonEmpty;
    
  }


  function validateUsername(event, usernameInput, userLabel) {
      var validUsername = true;

      if(userLabel === "Username is not available, select a new username.") {
        validUsername = false;
        $(".credentialInput").focus().val("").focus(); 
      }
      else if(usernameInput.length < 6 || usernameInput.length > 10) {
        validUsername = false;
        $(".credentialInput").focus().val("").focus();
      }
      else if(!isAlphaNumeric(usernameInput)) {
        validUsername = false;
        $(".credentialInput").focus().val("").focus();
      }
      return validUsername;
      
  }

  function validatePassword(event, passwordInput) {
    var validPassword = true;

    if(!isUpperLowerAlphaNumeric(passwordInput)) {
      validPassword = false;
      $(".credentialInput").focus().val("").focus();
    }

    return validPassword;
  }

  function validateEmail(event, emailAddress) {
    var validEmail = true;

    if(!emailAddress.includes("@")) {
      validEmail = false;
      $(".credentialInput").focus().val("").focus();
    }
    else {
      var emailAccount = emailAddress.substring(0, emailAddress.indexOf("@"));
      var emailDomain = emailAddress.substring(emailAddress.indexOf("@")+1, emailAddress.length-4);
      var emailHost = emailAddress.substring(emailAddress.length-4);

      if(!isAlphaNumeric(emailAccount)) {
        validEmail = false;
        $(".credentialInput").focus().val("").focus();
      }
      else if(!isAlphaNumeric(emailDomain)) {
        validEmail = false;
        $(".credentialInput").focus().val("").focus();
      }
      else if(emailHost.charAt(0) !== "." || !isLowerAlpha(emailHost.substring(1))) {
        validEmail = false;
        $(".credentialInput").focus().val("").focus();
      }
    }

    return validEmail;
  }


  function isAlphaNumeric(inputtxt) {
      var letter = /^[a-zA-Z0-9.]+$/;
      if(inputtxt.match(letter)) {
        return true;
       }
       else {
        return false;
      }
  }

   function isLowerAlpha(inputtxt) {
      var letter = /^[a-z]+$/;
      if(inputtxt.match(letter)) {
        return true;
       }
       else {
        return false;
      }
  }

    function isUpperLowerAlphaNumeric(inputtxt)  {
       var letterNumber = /(?=^.{8,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)[0-9a-zA-Z!@#$%^&*()]*$/;
       if(inputtxt.match(letterNumber)) {
         return true;
        }
        else {
         return false;
       }
    }

});