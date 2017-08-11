$(document).ready(function(){

  // Мобильное меню
  var navToggle = $("#navigation__button");
  var navLink = $("a.nav__link");
  var navOpen = $('.nav__open');
  var navList = $('.nav__list');

  // При клике на иконку
  navToggle.on('click', function(e){
  	e.preventDefault();
    if (navToggle.hasClass("active")) {
      navToggle.removeClass("active");
      navOpen.addClass('nav__open--none');
      navList.removeClass('nav__list--open');
    } else {
      navToggle.addClass("active");
      navOpen.removeClass('nav__open--none');
      navList.addClass('nav__list--open');
    }
  });

  // При клике на ссылку
  navLink.on('click', function(){
    navToggle.removeClass("active");
  	navOpen.addClass('nav__open--none');
  	navList.removeClass('nav__list--open');
  });

  // При изменении размера окна, в большую сторону, 
	$(window).resize(function(){
		var w = $(window).width();
		if(w > 767) {
      navToggle.removeClass("active");
      $('.nav__list').removeClass('nav__list--open');
		 	navOpen.addClass('nav__open--none');   
		}
	});

  // Переключатель кнопок фильтрации
  var btnFiltre = $(".button");
  var btnFiltreActive = "button--active";

  btnFiltre.on('click', function(){
    btnFiltre.removeClass(btnFiltreActive);
    $(this).toggleClass(btnFiltreActive);
  });

	// slide2id - плавная прокрутка по ссылкам внутри страницы
	$("nav a,header a,a[href='#top'],a[rel='m_PageScroll2id'],a.PageScroll2id").mPageScroll2id({
	    highlightSelector:"nav a"
	});

  // mixItUp - фильтрация работ в портфолио
  $('#works').mixItUp();

  // fancybox - галерея работ в портфолио
  $(".fancybox").fancybox({
      // Default - with fix from scroll to top
            helpers: {
                overlay: {
                    locked: false
                },
                overlayShow : true,
                overlayOpacity : 0.8
            }
    });

  // Валидация формы (jQuery Validate JS)
  $('#contact-form').validate({
    rules: {
      name: {required: true},
      email: {required: true, email: true},
      // skype:  {required: true},
      // tel:  {required: true},
      msg: {required: true}
    },

    messages: {
      name: "Пожалуйста, введите свое имя",
      email: {
        required: "Пожалуйста, введите свой email",
        email: "Email адрес должен быть в формате name@domain.com"
      },
      msg: "Пожалуйста, введите текст сообщения"
    },

    submitHandler: function(form) {
      ajaxFormSubmit();
    }
    
  });
  	
  // Функция AJAX запрса на сервер
  function ajaxFormSubmit() {
    var string = $("#contact-form").serialize(); // Сохраняем данные введенные в форму в строку. 

    // Формируем ajax запрос
    $.ajax({
      type: "POST", // Тип запроса - POST
      url: "php/mail.php", // Куда отправляем запрос
      data: string, // Какие даные отправляем, в данном случае отправляем переменную string
      
      // Функция если все прошло успешно
      success: function(html){
        $("#contact-form").slideUp(800);
        $('#answer').html(html);
      }
    });

    // Чтобы по Submit больше ничего не выполнялось - делаем возврат false чтобы прервать цепчку срабатывания остальных функций
    return false; 
  }

});
