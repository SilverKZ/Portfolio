$(document).ready(function(){

  	// Создаем переменые для кнопки и для меню
	var pull = $(".nav__link--table");
	var nav = $(".nav");

  	// Описываем событие при нажатии на кнопку
	$(pull).on("click", function(e){
        
    	// Отменяем стандартное поведение ссылки в браузере
		e.preventDefault();
		
		// Меняем цвет панели навигации
		if(nav.css("display") == "block") {
			pull.css("background", "#38383a");
		}
		else {
			pull.css("background", "#16385f");
		}
    	
    	// Открываем/Скрываем меню
		$(nav).slideToggle();
	
	});


  // При изменении размера окна, в большую сторону, 
  // если меню было скрыто, показываем его.
	$(window).resize(function(){
		var w = $(window).width();
		if(w > 991) {
		    nav.removeAttr('style');
		    pull.css("background", "#38383a");
		}
	});

	// Скрыть меню при клике на ссылку (для мобайл)
	$('nav .nav a').on("click", function(){
		if($(window).width() < 992) {
			nav.slideToggle(); 
			pull.css("background", "#38383a");
		}
	});
	
	// Вызов слайдера owl-carousel
	$("#owl-example").owlCarousel({
		items: 1, // Кол-во отображаемых элементов в слайдере
		loop: true, // Бесконечное зацикливание слайдера
        nav: true, // Отображение кнопок вперед\назад
        autoplay: true, // Автоматическое пролистывание
        autoplaySpeed: 1000, // Скорость автоматического пролистывания
        smartSpeed: 600, //Время движения слайда
		autoplayTimeout: 5000, //Время смены слайда
		navText: ["",""],
		dots: true
	});

	// pagescroll2id - плавная прокрутка по ссылкам внутри страницы
	$("nav .nav a,a[href='#top'],a[rel='m_PageScroll2id'],a.PageScroll2id").mPageScroll2id({
	    highlightSelector:"nav .nav a"
	});


});
