/*
Auteur : Warren Madanamoothoo
E-mail : kingdomdesire@gmail.com
Site web : http://ashiette.rd-h.com

jQuery sous licence GPL
*/

/***************
 * PARTIE MENU *
 **************/

var iW = window.innerWidth;
var iH = window.innerHeight;

var compteur_menu = 5; // Pixels début premier élément menu
var separ_menu = 0; // Pixels séparation entre élément menu

$('nav a').each( function() { // Pour chaque élément du menu, faire
	$(this).css({top : compteur_menu}); // Mettre à hauteur compteur_menu
	compteur_menu += parseInt($('nav a').height()) + separ_menu; // Mettre le prochain élément à compteur_menu + separ_menu de hauteur
});

var navi_height = 0.5*(0.45*parseInt($('body').width()) - compteur_menu) // Définir hauteur du menu à partir du calcul où une fenetre navigateur sera de ratio 20:9
$('nav').css({height : compteur_menu, width : $('nav a').width() + 50, top : navi_height }); // Définir hauteur de nav

$('nav a').hover(function() { // Lors du survol d'un élément du menu
	$(this).animate({width:250},400, function() {
		$('.navlink', this).fadeIn(250);
	});
}, function(){
	$('.navlink').fadeOut(250)
	$(this).delay(250).animate({width : 50}, 400);
});
