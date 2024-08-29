$(document).ready(function(){
    
    (function($) {
        "use strict";

    
    jQuery.validator.addMethod('answercheck', function (value, element) {
        return this.optional(element) || /^\bcat\b$/.test(value)
    }, "type the correct answer -_-");

    // validate contactForm form
    $(function() {
        $('#contactForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                subject: {
                    required: true,
                    minlength: 4
                },
                number: {
                    required: true,
                    minlength: 5
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true,
                    minlength: 20
                },
                comment:{
                    required: true,
                    minlength: 1
                }
            },
            messages: {
                name: {
                    required: "Come on, you have a name, don't you?",
                    minlength: "Your name must consist of at least 2 characters"
                },
                subject: {
                    required: "Come on, you have a subject, don't you?",
                    minlength: "Your subject must consist of at least 4 characters"
                },
                number: {
                    required: "Come on, you have a number, don't you?",
                    minlength: "Your Number must consist of at least 5 characters"
                },
                email: {
                    required: "No email, No message"
                },
                message: {
                    required: "Um...yea, you have to write something to send this form.",
                    minlength: "Thats all? really?"
                },
                comment: {
                    required: "Um...yea, you have to write something to comment.",
                    minlength: "Thats all? really?"
                }
            }
        })
    })
        
 })(jQuery)
})