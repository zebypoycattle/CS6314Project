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

  $('#account').on('click', function (e) {
    $('#accountText').addClass('active highlight');
  });

  $('.button').on('click', function(e) {
     var selector = $(this);
     validate(e, selector);
  });


  function credentialRequirements(selector) {
        var id = $(selector).attr("id");
        if(id === "usernameLabel") {
          $(selector).text("Username must be alphanumeric between 6 and 15 characters.");
        }
        else if(id === "passwordLabel") {
          $(selector).text("Password must be at least 7 characters and contain upper and lower case letter, number, and special character.");
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
    event.preventDefault();
    
    var id = $(selector).attr("id");
    var passwordDiv = $(selector).prev();
    var userNameDiv = $(passwordDiv).prev();
    var divArray;

    if(id === "createButton") {
        var nameDiv = $(userNameDiv).prev();
        var firstNameDiv = $(nameDiv).find("#firstNameDiv");
        var lastNameDiv = $(nameDiv).find("#lastNameDiv");
        var accountDiv = $(nameDiv).prev();
        divArray = [accountDiv, firstNameDiv, lastNameDiv, userNameDiv, passwordDiv];

        if(!validateRequiredFieldsAreNonEmpty(event, divArray)) {
          alert("Please fill all required fields.");
        }
        else {
          var validatedUsername = validateUsername(event, userNameDiv);
          var validatedPassword = validatePassword(event, passwordDiv);
          if (!validatedUsername || !validatedPassword) {
            alert("Invalid username or password.");
          }
        }
        
      
    }
    else {
      divArray = [userNameDiv, passwordDiv]
      if(!validateRequiredFieldsAreNonEmpty(event, divArray)) {
        alert("Please fill all required fields.");
      }
    }
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

  function validateUsername(event, selector) {
      var validUsername = true;
      var usernameInput = $(selector).find('input').val();
      if(usernameInput.length < 5) {
        validUsername = false;
        $(selector).find('input').focus().val("");
      }
      else if(!isAlphaNumeric(usernameInput)) {
        validUsername = false;
        $(selector).find('input').focus().val("");
      }

      return validUsername;
      
    }

    function validatePassword(event, selector) {
      var validPassword = true;
      var passwordInput = $(selector).find('input').val();
      if(passwordInput.length < 5) {
        validPassword = false;
        $(selector).find('input').focus().val("");
      }
      else if(!isAlphaNumeric(passwordInput)) {
        validPassword = false;
        $(selector).find('input').focus().val("");
      }

      return validPassword;
    }


  function isAlpha(inputtxt) {
      var letter = /^[a-zA-Z]+$/;
      if(inputtxt.match(letter)) {
        return true;
       }
       else {
        return false;
      }
    }

    function isAlphaNumeric(inputtxt)  {
       var letterNumber = /^[0-9a-zA-Z]+$/;
       if(inputtxt.match(letterNumber)) {
         return true;
        }
        else {
         return false;
       }
    }

});