$(document).ready(function() {

    //slide2id - плавная прокрутка по ссылкам внутри страницы
    $("nav a,.offer a,a[rel='m_PageScroll2id'],a.PageScroll2id").mPageScroll2id({
        highlightSelector:"nav a"
    });
    
});