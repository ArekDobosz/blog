$(document).ready(function() {

    rules = {
        '#name': {
            required: true,
            regExp : /[^0-9!@#\$%\^\&*\)\(+=._-]+$/g,
            message : 'To pole nie może być puste oraz może zawierać jedynie litery.'
        },
        '#email': {
            required: true,
            regExp: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
            message: 'Wprowadź prawidłowy adres email.'
        },
        '#text-msg': {
            required: true,
            value: 'Twoja wiadomość'
        }
    }

    $.fn.myValidator = function(rules) {

        function showAlert (element, message) {
            if(element.last().prev('.alert').length < 1) {
                if(!message) {
                    message = 'Popraw to pole.';
                }
                $('<div>')
                    .attr('class', 'alert alert-danger')
                    .text(message)
                    .insertBefore(element.last());

                    element.parent().addClass('has-error');      
            }
        }

        function removeAlert(element) {
            element
                .parent()
                .removeClass('has-error'); //usunięcie klasy dla formatki

            element
                .prev('.alert')
                .remove(); //usunięcie komunikatu o błędzie
        }

        return this.each(function() {

            $(this).submit(function() {
                
                var allPassed = true,
                    thisForm = $(this); 

                $.each(rules, function (element, rule) {
                    var tmpElem = $(element, thisForm),
                        tmpPassed = true;

                    var value = $.trim(tmpElem.val());
                    if(rule['required']) {
                        if(value.length < 1) {
                            tmpPassed = false;
                        }
                    }

                    if(rule['regExp']) {
                        var reg = new RegExp(rule['regExp']);
                        if(!reg.test(value)) {
                            tmpPassed = false;
                        }
                    }
                    if(rule['value'] === value) {
                        tmpPassed = false;
                    }

                    if(!tmpPassed){
                        allPassed = tmpPassed;
                        showAlert(tmpElem, rule['message']);
                    } else {
                        removeAlert(tmpElem);
                    }
                    
                });
                if(allPassed) {

                    $.ajax({
                        url: 'libs/mail.php',
                        type: 'POST',
                        data: {data: thisForm.serializeArray()},
                        success: function(data) {
                            alert(data);
                        }
                    });

                    $('#p4 form').toggle('slow');
                    $('#p4 #msg').toggle('slow');

                }
                return false;

            });
        });

    }

    var textAreaInput = $("form textarea#text-msg"),
        textAreaMsg = "Twoja wiadomość";

    textAreaInput.val(textAreaMsg);

    textAreaInput.focus(function() {
        if($(this).val() === textAreaMsg) {
            $(this).val("");
        }
    });

    textAreaInput.blur(function() {
        if($(this).val() === "") {
            $(this).val(textAreaMsg);
        }
    })

    /* VALIDACJA FORMULARZA */

    var contactForm = $(".page-four form#contact_form");
    contactForm.myValidator(rules);

    var form = $('#showForm').addClass('showBtn');

    /* PRZYCISK DO PONOWNEGO POKAZANIA FORMULARZA */

    $('.page-four #showForm').click(function() {
        $('#p4 #msg').toggle('slow');
        $('#p4 form').toggle('fast');
        return false;
    })

    /* PRZYCISK DO PRZEWIJANIA W GÓRĘ STRONY */

    function createButton () {
        var button = $('<button><i class="fa fa-arrow-up" aria-hidden="true"></i><br>up</button>');
        button.addClass('backToTop hidden');

        $('body').append(button);

        return button;
    }

    function animateScroll () {
        // var top = document.body.scrollTop();
        if (document.body.scrollTop > 0) {
            window.scrollBy(0,-15);
            setTimeout(animateScroll, 5);
        }
    }

    var btn = createButton();

    btn.click(function (e) {
        e.stopPropagation(); // wstrzymuje wykonanie innych requestów ktorych nie chcę

        animateScroll();
    });

    $(window).scroll(function (e) {
        if (document.body.scrollTop >= 800) {
            btn.removeClass('hidden');
        } else {
            btn.addClass('hidden');
        }
    });
    
    $('td.tbl_actions a').first().click(function(e) {
        confirm('Czy napewno usunąć post?');
    });
    
    
    var limit = $('#post_per_page');
    limit.find('[name="limit"]').change(function() {
            limit.submit();
    });
    
    var tagForm = $('form#tag_form');
    tagForm.find('[name="tag_name"]').change(function() {
            tagForm.submit();
    })
});