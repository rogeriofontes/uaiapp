$(document).ready(function () {
    // Carregando WOW JS
    new WOW().init();
});

jQuery(document).ready(function ($) {
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 700);
    });
});

// BOTÃO VOLTAR AO TOPO
function handleBackToTop() {
	$('#back-to-top').on("click", function(){
	    $('html, body').animate({scrollTop:0}, 'slow');
	    return false;
	});
}

function showHidebackToTop() {
	if ($(window).scrollTop() > $(window).height() / 2 ) {
		$("#back-to-top").removeClass('gone').addClass('visible');
	} else {
		$("#back-to-top").removeClass('visible').addClass('gone');
	}	
}

$(document).ready(function() {
	handleBackToTop();
	showHidebackToTop();
});

$(window).scroll(function() {
	showHidebackToTop();
});