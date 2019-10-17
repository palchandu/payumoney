$(document).ready(function () {
  $.validator.addMethod("captcha_match", function(value, element) {
    var text=$("#basic-addon2").text();
  return this.optional(element) || value==text;
}, "Please eneter valid captcha");

    $('#register_form').validate({ // initialize the plugin

        rules: {
            firstname: {
                required: true,
                minlength: 5
            },
            phone: {
                required: true,
                minlength: 10,
                number:true,
            }
            ,
            whatsapp: {
                required: true,
                minlength: 10
            }
            ,
            udf3: {
                required: true
            }
            ,
            email: {
                required: true,
                email: true
            }
            ,
            address: {
                required: true,
            },
            captcha:{
              required: true,
              captcha_match:true
            }

        },
        messages: {
            firstname: {
                required: 'Name is mandatory',
                minlength: 'Name will be minimum 5 character'
            },
            phone: {
                required: 'Phone Numner is mandatory',
                minlength: 'Phone Number will be minimum 10 character',
                number:"Phone number will be number"
            }
            ,
            whatsapp: {
                required: 'WhatsApp Number is mandatory ',
                minlength: 'Phone Number will be minimum 10 character'
            }
            ,
            udf3: {
                required: 'State is mandatory'
            }
            ,
            email: {
                required: 'Email is mandatory',
                email: 'Please enter valid email'
            }
            ,
            address: {
                required: 'Address is required',
            }
            ,
            captcha: {
                required: 'Captcha is required',
            }

        },
        submitHandler: function (form) { // for demo
            //alert('valid form submitted'); // for demo
            return true; // for demo
        }
    });

});
