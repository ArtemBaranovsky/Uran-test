function onSubmit(token) {
    document.getElementById("form").submit();
}

document.addEventListener('DOMContentLoaded', function(){
    $('.form').on('submit', function (e) {
        var response = grecaptcha.getResponse();
        //recaptcha failed validation
        if(response.length == 0) {
            e.preventDefault();
            $('#errors p').text('* Вы не прошли проверку "Я не робот"');
            $('#errors').removeClass('d-none');
        }
        //recaptcha passed validation
        else {
            $('#errors p').text('');
            $('#errors').addClass('d-none');
        }
        if (e.isDefaultPrevented()) {
            return false;
        } else {
            return true;
        }
    });
});