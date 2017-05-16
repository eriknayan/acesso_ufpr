window.onload = function() {
    var $form = $('#payment-form');

    /* Fancy restrictive input formatting via jQuery.payment library*/
    $('input[name=cardNumber]').payment('formatCardNumber');
    $('input[name=cardCVC]').payment('formatCardCVC');
    $('input[name=cardExpiry').payment('formatCardExpiry');

    /* Form validation using Stripe client-side validation helpers */
    jQuery.validator.addMethod("cardNumber", function(value, element) {
        return this.optional(element) || $.payment.validateCardNumber($('input[name=cardNumber]').val());
    }, "Número de cartão de crédito inválido.");

    jQuery.validator.addMethod("cardName", function(value, element) {
        return this.optional(element) || $form.find('input[name=cardName]').val().length > 0;
    }, "Insira aqui o nome que aparece no cartão.");

    jQuery.validator.addMethod("cardExpiry", function(value, element) {
        /* Parsing month/year uses jQuery.payment library */
        value = $.payment.cardExpiryVal(value);
        return this.optional(element) || $.payment.validateCardExpiry(value['month'], value['year']);
    }, "Data de validade inválida.");

    jQuery.validator.addMethod("cardCVC", function(value, element) {
        return this.optional(element) || $.payment.validateCardCVC($('input[name=cardCVC]').val());
    }, "CVC inválido.");

    validator = $form.validate({
        rules: {
            cardNumber: {
                required: true,
                cardNumber: true
            },
            cardName: {
                required: true,
                cardName: true
            },
            cardExpiry: {
                required: true,
                cardExpiry: true
            },
            cardCVC: {
                required: true,
                cardCVC: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-control').removeClass('success').addClass('error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-control').removeClass('error').addClass('success');
        },
        errorPlacement: function(error, element) {
            $(element).closest('.form-group').append(error);
        }
    });

    paymentFormReady = function() {
        if ($form.find('[name=cardNumber]').hasClass("success") &&
            $form.find('[name=cardName]').hasClass("success") &&
            $form.find('[name=cardExpiry]').hasClass("success") &&
            $form.find('[name=cardCVC]').val().length > 1) {
            return true;
        } else {
            return false;
        }
    }

    $form.find('.subscribe').prop('disabled', true);
    var readyInterval = setInterval(function() {
        if (paymentFormReady()) {
            $form.find('.subscribe').prop('disabled', false);
            clearInterval(readyInterval);
        }
    }, 250);

    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo é obrigatório.",
    });
}