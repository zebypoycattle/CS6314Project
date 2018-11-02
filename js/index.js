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

});