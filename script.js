
// ---------------- JQUERY DOCUMENT READY ----------------

$(document).ready(function () {

    // Phone number: allow only digits
    $('input[name="phone"]').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    // PIN code: allow only digits
    $('input[name="pincode"]').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    });


    // Highlight selected gender
    $('input[name="gender"]').on('change', function () {
        $('.gender-card').css({
            'border-color': '#e5e7ef',
            'background': 'white'
        });

        $(this).closest('.gender-card').css({
            'border-color': '#5145e5',
            'background': '#f2f1ff'
        });
    });


    // ---------------- FORM VALIDATION ----------------

    $('#registrationForm').on('submit', function (event) {

        let valid = true;

        $('.field-error').text('');

        $('.form-group input[required], .form-group select[required], .form-group textarea[required]')
            .each(function () {

                if ($(this).val().trim() === '') {

                    valid = false;

                    $(this).next('.field-error')
                        .text('This field is required.');

                }
            });


        // Validate email
        let email = $('input[name="email"]').val().trim();

        let emailPattern =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {

            valid = false;

            $('input[name="email"]')
                .next('.field-error')
                .text('Enter a valid email address.');
        }


        // Validate phone
        let phone = $('input[name="phone"]').val();

        if (!/^[0-9]{10}$/.test(phone)) {

            valid = false;

            $('input[name="phone"]')
                .next('.field-error')
                .text('Enter a valid 10-digit phone number.');
        }


        // Validate PIN code
        let pin = $('input[name="pincode"]').val();

        if (!/^[0-9]{6}$/.test(pin)) {

            valid = false;

            $('input[name="pincode"]')
                .next('.field-error')
                .text('Enter a valid 6-digit PIN code.');
        }


        // Validate gender
        if (!$('input[name="gender"]:checked').length) {
            valid = false;
            alert('Please select your gender.');
        }


        // Validate terms
        if (!$('input[name="terms"]').is(':checked')) {
            valid = false;
            alert('Please accept the terms and conditions.');
        }


        // Stop submission if invalid
        if (!valid) {

            event.preventDefault();

            $('html, body').animate({
                scrollTop: $('.error-box').length
                    ? $('.error-box').offset().top - 100
                    : $('.form-card').offset().top
            }, 400);

        } else {

            $('.submit-btn').html(
                '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...'
            );

            $('.submit-btn').prop('disabled', true);
        }

    });


    // ---------------- RESET FORM ----------------

    $('.reset-btn').on('click', function () {

        $('.field-error').text('');

        $('.gender-card').css({
            'border-color': '#e5e7ef',
            'background': 'white'
        });

    });


    // ---------------- INPUT INTERACTION ----------------

    $('input, textarea, select').on('focus', function () {
        $(this).closest('.form-group').find('.field-error').text('');
    });

});
