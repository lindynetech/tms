$(document).ready(function () {

    // CSRF Protection
    $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
        var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
        }
    });

    $('#contactForm :submit').click(function (e) {
        e.preventDefault();

        var name = $("#contactForm input[name='name']");
        var email = $("#contactForm input[name='email']");
        var subject = $("#contactForm input[name='subject']");
        var message = $("#contactForm [name='message']");
        var _token = $("#contactForm [name='_token']").val();
        //var recaptcha = $("#contactForm [name='g-recaptcha-response']").val();

        //alert(message);

        if (name.val() == '') {
            name.css('border', '1px solid #F93D66');
            return false;
        } else {
            name.css('border', '1px solid #ddd');
        }

        if (email.val() == '' || !isEmail(email.val())) {
            email.css('border', '1px solid #F93D66');
            return false;
        } else {
            email.css('border', '1px solid #ddd');
        }

        if (subject.val() == '') {
            subject.css('border', '1px solid #F93D66');
            return false;
        } else {
            subject.css('border', '1px solid #ddd');
        }

        if (message.val() == '') {
            message.css('border', '1px solid #F93D66');
            return false;
        } else {
            message.css('border', '1px solid #ddd');
        }

        var data = {
            name: name.val(),
            email: email.val(),
            subject: subject.val(),
            message: message.val(),
            _token: _token
        };

        $.ajax({
            url: "/contact",
            method: "POST",
            data: data,
            cache: false
        })
        .done(function(r){
            $('#contactstatus').text('We have received your message and will contact you shortly!').fadeOut(10000);;
            $('#contactForm')[0].reset();
            //grecaptcha.reset();
        })
        .fail(function() {
            $('#contactstatus').text('There was an error processing your request, please try again.');
        })
    });

});

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
