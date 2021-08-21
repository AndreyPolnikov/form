(function ($) {

    $(document).ready(function (){
        uploadImage();
    })

    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function validatePhoneNumber(phone)
    {
        const re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

        return re.test(phone);
    }

    function validate(name, phone, email) {
        if  (!name.length) {
            $("#name").addClass('error').after('<span class="error-txt">Name can not be empty</span>');
            return false;
        }

        if  (!phone.length) {
            $("#phone").addClass('error').after('<span class="error-txt">Phone can not be empty</span>');
            return false;
        } else if(!validatePhoneNumber(phone)) {
            $("#phone").addClass('error').after('<span class="error-txt">Phone is not valid</span>');
            return false;
        }

        if (!validateEmail(email)) {
            $("#email").addClass('error').after('<span class="error-txt">Email is not valid</span>');
            return false;
        }

        return true;
    }

    $(document).on('click', '.error', function (){
        $(this).removeClass('error');
        $(this).siblings('.error-txt').remove()
    })

    $(document).on('submit', '#form', function (e) {
        e.preventDefault();

        const $name = $('#name').val();
        const $last_name = $('#surname').val();
        const $phone = $('#phone').val();
        const $email = $('#email').val();
        const $validate = validate($name, $phone, $email);
        const formdata = new FormData();
        const images = $('.img');

        for (let i = 0; i <= images.length; i++) {
            formdata.append("photo_" + i , $(images).attr('rel'));
        }

        formdata.append("name", $name);
        formdata.append("last_name", $last_name);
        formdata.append("email", $email);
        formdata.append("phone", $phone);
        formdata.append("action", 'send_form_data');

        if ($validate) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: formdata,
                async: true,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function () {
                    $("#form")[0].reset();
                    $('#form .button-row').html('<span class="sent_success">Form successfully sent</span>');
                    $('.img').remove();
                },
            })
        }
    })

    $(document).on('click', '#form', function (){
        if ($('.sent_success').length) {
            $('#form .button-row').html('<button>Submit Form</button>')
        }
    })

    function uploadImage() {
        const button = $('.images .pic')
        const uploader = $('<input type="file" accept="image/*" />')
        const images = $('.images')

        button.on('click', function () {
            if ($('.img').length <= 3) {
                uploader.click()
            }
        })

        uploader.on('change', function () {
            const reader = new FileReader()

            reader.onload = function(event) {
                $('.images p').after('<div class="img" rel="'+ encodeURI(event.target.result) +'">'+uploader[0].files[0].name+'<span class="remove-img"> x</span></div>')
            }

            reader.readAsDataURL(uploader[0].files[0])

        })

        images.on('click', '.img', function () {
            $(this).remove()
        })

    }



}(jQuery));