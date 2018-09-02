$(document).ready(function() {

    // Инициализация arcticModal (всплывающие окна)
    $('.reviews__frame-overlay, .reviews__text-link').click( function(e) {
        e.preventDefault();
        $('#modal-btn').arcticmodal({
            overlay: {
                css: {
                    backgroundColor: '#131731',
                    opacity: .93
                }
            }
        });
        $('#modal-btn').html('<img src="'+this.href+'" />');
    });


    // Инициализация слайдера - проекты
    $('.gallery__slider').slick({
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

    // Инициализация слайдера - отзывы
    $('.reviews__slider').slick({
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

});
