/** Affichage Quote Motto **/

 $(document).ready(function(){
      var myQuotes = new Array();
      myQuotes[0] = "&ldquo; Cats will turn into Lyon &bdquo;";
      myQuotes[1] = "&ldquo; Nothing's difficult, everything's a challenge &bdquo;";
	  
	  var mySource = new Array();
      mySource[0] = "Crookshanks Lyon Motto";
      mySource[1] = "Turskee Air Force Motto";
      
      var myRandom = Math.floor(Math.random()*myQuotes.length);
      $(".message").html(myQuotes[myRandom]);
	  $(".source").html(mySource[myRandom]);
	  
});

/** Validation Engine formulaire Contact **/
 
 $(document).ready(function(){ 
    $("#cform").validationEngine({
		 binded: true
         ,promptPosition : "centerRight"
        ,onAjaxFormComplete: function(status,form) {
          if (status === true) {
            return pageLoad_onsubmit();
            form.submit();
          }
         }
    });
 
});

function checkMachine() {
		if(document.getElementById('radio1').checked) {
			alert("Pas humain ? impossible de nous envoyer un message merci de changer votre statut !");
		}
		/*else {
			document.getElementById("cform").submit();
		}*/
}

/*$(document).ready(function(){
		$("#cform").submit(function(event){
			if(document.getElementById('radio1').checked) {
				alert("Pas humain ? impossible de nous envoyer un message merci de changer votre statut !");
			}
			else {
				form.submit();
			}
		});
});*/