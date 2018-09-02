$(document).ready(function() {

    // Плавная прокрутка по ссылкам внутри страницы
    $(".info-btn,a[rel='m_PageScroll2id'],a.PageScroll2id").mPageScroll2id({
        highlightSelector:"nav a"
    });
    
    // Параллакс фона
    var objWindow = $(window),
        speed = 3;

    if (objWindow.width() > 960)
    { 
        $('#header').each(function() {
            objWindow.scroll(function() {
                var yPos = -(objWindow.scrollTop() / speed); 
                var coords = '50% '+ yPos + 'px';
                $('#header').css({ backgroundPosition: coords });
            }); 
        });    
    };

    // Инициализация arcticModal (всплывающие окна)
    $('.modal-btn').click( function(e) {
        e.preventDefault();
        $('#modal-btn').arcticmodal({
            overlay: {
                css: {
                    backgroundColor: '#131731',
                    opacity: .93
                }
            }
        });
    });

    // Инициализация слайдера
    $('.slider-box').slick({
        dots: true,
        infinite: true,
        autoplay: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
        responsive: [
        {
            breakpoint: 768,
            settings: {
                arrows: false
            }
        }]    
    }); 

    // Фиксация навигации
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1){  
            $('.nav-bar').addClass("sticky");
        }
        else{
            $('.nav-bar').removeClass("sticky");
        }
    });   

    // Hamburger для навигации
    $('.bars').click(function (e) {
        e.preventDefault();
        $('.menu-collapse').toggleClass('menu-open');
        $('.menu').toggleClass('menu-mod');
        $('.bars_close').toggleClass('bars-close');
    }); 

});
