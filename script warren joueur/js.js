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
var separ_menu = 5; // Pixels séparation entre élément menu

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

/****************
 * PARTIE CADRE *
 ****************/

var main_center = 0.5*(parseInt($('body').width()) - parseInt($('#main').width()) + parseInt($('.menu').width())); // Centre du cadre principal entre menu et bord de droite
$('#main').css({left : main_center}); // Centrer le cadre #main (cadre principal)

$('body').css({backgroundPosition : main_center+50+"px 0px, 0px"}); // Simplification pratique du calcul (permet de sauvegarder une bonne ligne) qui annule l'autocalcul si changement de width de #main. @@NUMBER_VALUE_MANUAL

$('#background, body').css({width : iW, height : window.innerHeight}); // Donner à l'image de cover 100% de hauteur et de largeur

$('.parallax').css({width : iW});

$('#news').css({marginTop : iH-100});
$('#news_header').css({width : iW-300-2*parseInt($('#news_header').css('paddingLeft'))});


/***********************
 * PARTIE POPUP JOUEUR *
 ***********************/

$('.player').click(function() { // Lors du click sur un joueur, faire
	$('#pl_list').fadeIn(1000); // Apparaitre un cadre "retour au clic (qui contient tous les joueurs, BTW)"
	pl_id = parseInt($(this).attr('id')); // Chercher l'attribute id, ne prendre que le premier chiffre/nombre (c'est pas très catholique)
	$('.pl_info:nth-child(' + pl_id + ')').each(function() { $(this).css({display : 'block'}); }); // pour le n-ème joueur concerné, afficher sa fiche
});

$('#pl_list').each(function() { // Définit la taille du cadre qui contient tous les joueurs (typiquement 100% de la page)
	$(this).css({height : window.innerHeight, width : window.innerWidth}).fadeOut(0);
}).click(function() { // Au clique, faire
	$(this).fadeOut(1000);
});

$('.pl_info').each(function() { // Définit la taille d'une fiche (ici 80% centré)
	$(this).css({height : 0.8 * window.innerHeight, width : 0.8 * window.innerWidth, left : 0.1 * window.innerWidth, top : 0.1 * window.innerHeight}).fadeOut(0);
});