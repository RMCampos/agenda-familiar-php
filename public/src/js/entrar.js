"use strict";

var main = function() {
    $('#entrarPass').click(function() {
        $(this).find('i').toggleClass('fa-eye-slash').toggleClass('fa-eye');
        $(this).parent().find('input').prop('type', $(this).find('i').hasClass('fa-eye-slash')? 'password' : 'text' );
    });
    $('[data-toggle="popover"]').popover({
        container: 'body'
    });
};

$(document).ready(main);