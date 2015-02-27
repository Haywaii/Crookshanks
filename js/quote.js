/** Affichage Quote Motto **/

 $(document).ready(function(){
      var myQuotes = new Array();
      myQuotes[0] = "&ldquo; Cats will turn into Lyon &bdquo;";
      myQuotes[1] = "&ldquo; Nothing’s difficult, everything’s a challenge &bdquo;";
	  
	  var mySource = new Array();
      mySource[0] = "Crookshanks Lyon Motto";
      mySource[1] = "Turskee Air Force Motto";
      
      var myRandom = Math.floor(Math.random()*myQuotes.length);
      $(".message").html(myQuotes[myRandom]);
	  $(".source").html(mySource[myRandom]);
	  
});