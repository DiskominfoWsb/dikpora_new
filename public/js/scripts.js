/*!
* Start Bootstrap - Blog Home v5.0.8 (https://startbootstrap.com/template/blog-home)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-blog-home/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

$(document).on('mouseover', 'ul.navbarku > li', function(){
    $(this).children('a').addClass('bg-warning');
    $(this).children('a').addClass('rounded-pill');
    $(this).children('table').show();
});
$(document).on('mouseleave', 'ul.navbarku > li', function(){
    $(this).children('a').removeClass('bg-warning');
    $(this).children('a').removeClass('rounded-pill');
    $(this).children('table').hide();
});

$(document).on('mouseover', '.induk-semang', function(){
    $(this).children('.anak-semang').css('border-radius','.6rem');
    $(this).children('.anak-semang').show();
});
$(document).on('mouseleave', '.induk-semang', function(){
    $(this).children('.anak-semang').hide();
});

$('article img[alt="img-full-width"]').css('width','100%');
$('article img[alt="img-full-width"]').css('max-width','100%');
$('article img[alt="img-full-width"]').css('height','auto');

$(window).on('scroll', function() {
    var y  = $(window).scrollTop(),
        e1 = $('#tools'),
        e2 = $('#navku'),
        vi = e1.offset().top < (y + $(window).height()) && (e1.offset().top + e1.height()) > y;
    e2.toggle(!vi);


    var x  = $(window).scrollTop(),
        f1 = $('#tools'),
        f2 = $('#toolsku'),
        wi = f1.offset().top < (x + $(window).height()) && (f1.offset().top + f1.height()) > x;
    f2.toggle(!wi);

    /**
    var m  = $(window).scrollTop(),
        n1 = $('#tools'),
        n2 = $('#chatku'),
        oi = n1.offset().top < (m + $(window).height()) && (n1.offset().top + n1.height()) > m;
    n2.toggle(!oi); */

    $('#navku').removeClass('d-none');
    $('#toolsku').removeClass('d-none');
    //$('#chatku').removeClass('d-none');
});

//menu responsive
//mobile version
$('.menu-toggler').click(function() {
    $(this).prev('ul.navbarku').addClass('toggled-menu').slideDown();
    $(this).prev('ul.navbarku').children('li').addClass('parent-nav');
});
$(document).on('click', 'li.parent-nav', function() {
    $(this).children('table').addClass('table-normal');
});

//chat pojok kanan bawah
function chatku(a) {
    icon1 = '<i class="bi bi-whatsapp text-light animate__animated animate__heartBeat"></i>';
    icon2 = '<i class="bi bi-chat-right-text-fill text-light animate__animated animate__heartBeat"></i>';
    icon3 = '<i class="bi bi-telegram text-light animate__animated animate__heartBeat"></i>';
    icon4 = '<i class="bi bi-envelope text-light animate__animated animate__heartBeat"></i>';
    setInterval(function (){
        if($(a).html() == icon2) {
            $(a).html(icon1);
        }else if($(a).html() == icon1) {
            $(a).html(icon3);
        }else if($(a).html() == icon3) {
            $(a).html(icon4);
        }else {
            $(a).html(icon2);
        }
    }, 2000);
}
chatku('#chatku a');

$(function () {
    'use strict';
	var popover = new bootstrap.Popover(document.querySelector('#chatku>a'), {
		container: 'body'
    });

    /**
     * Responsive element
     */
    function responsiveMe() {
        $('.clear-px').removeClass('pe-1 pe-2 pe-3 pe-4 pe-5 ps-1 ps-2 ps-3 ps-4 ps-5');
        $('.carousel-col').removeClass('pe-1 pe-2 pe-3 pe-4 pe-5 ps-1 ps-2 ps-3 ps-4 ps-5');
        $('.carousel-col').addClass('col-lg-4 col-md-4 col-sm-12 col-12 mb-3 px-3');

        $('#container-pengumuman').addClass('container');
        $('#container-pengumuman div').addClass('px-2');
        $('#container-pengumuman div img').addClass('rounded');

        $('.tools-row').addClass('gx-2');

        $('#footer-warning-1,#footer-warning-3').removeClass('pe-1 pe-2 pe-3 pe-4 pe-5 ps-1 ps-2 ps-3 ps-4 ps-5');
        $('#footer-warning-1,#footer-warning-3').css('border-bottom', '1px solid #d69e04');
        $('#footer-warning-1 a h5,#footer-warning-1 a p,#footer-warning-3 a h5,#footer-warning-3 a p').addClass('ps-3');

        $('.little-px').addClass('px-4');

        $('.chatku').css('margin-right', '20px').css('margin-bottom', '25px');
    }

    var width = $(window).width();
    if(width < 576) responsiveMe();
    $(window).resize(function(){
        if($(this).width() < 576) responsiveMe();
    });

});