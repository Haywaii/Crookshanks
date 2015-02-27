<?php
if (isset($_POST["envoyer"])){ // Si le formulaire a �t� soumis
	$etat = "erreur"; // On initialise notre etat � erreur, il sera chang� � "ok" si la v�rification du formulaire est un succ�s, sinon il reste � erreur

	// On r�cup�re les champs du formulaire, et on arrange leur mise en forme
	if (isset($_POST["son_pseudo"])) $_POST["son_pseudo"]=trim(stripslashes($_POST["son_pseudo"])); // trim()  enl�ve les espaces en d�but et fin de chaine

	if (isset($_POST["son_email"])) $_POST["son_email"]=trim(stripslashes($_POST["son_email"])); // stripslashes()  retire les backslashes ==> \' devient '

	if (isset($_POST["son_url"])) $_POST["son_url"]=trim(stripslashes($_POST["son_url"]));

	if (isset($_POST["son_objet"])) $_POST["son_objet"]=trim(stripslashes($_POST["son_objet"]));

	if (isset($_POST["son_message"])) $_POST["son_message"]=trim(stripslashes($_POST["son_message"]));

	// Apr�s la mise en forme, on v�rifie la validit� des champs
	if (empty($_POST["son_pseudo"])) { // L'utilisateur n'a pas rempli le champ pseudo
		$erreur="Vous n'avez pas entr&eacute; votre pseudo..."; // On met dans erreur le message qui sera affich�
	}
	elseif (empty($_POST["son_email"])) { // L'utilisateur n'a pas rempli le champ email
		$erreur="Nous avons besoin de votre e-mail pour vous r&eacute;pondre...";
	}
	elseif (!preg_match("$[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\.[a-z]{2,4}$",$_POST["son_email"])){ // On v�rifie si l'email est bien de la forme messagerie@domaine.tld (cf cours d'expressions r�guli�res)
		$erreur="Votre adresse e-mail n'est pas valide...";
	}
	elseif (empty($_POST["son_objet"])) { // L'utilisateur n'a pas rempli le champ objet
		$erreur="Vous devez entrer l'objet de votre message...";
	}
	elseif (empty($_POST["son_message"])) { // L'utilsateur n'a �crit aucun message
		$erreur="Merci de saisir un message...";
	}
	else { // Si tous les champs sont valides, on change l'�tat � ok
		$etat="ok";
	}
}
else { // Sinon le formulaire n'a pas �t� soumis
	$etat="attente"; // On passe donc dans l'�tat attente
}

if ($etat!="ok"){ // Le formulaire a �t� soumis mais il y a des erreurs (etat=erreur) OU le formulaire n'a pas �t� soumis (etat=attente)
	if ($etat=="erreur"){ // Cas o� le formulaire a �t� soumis mais il y a des erreurs
		echo "<span style=\"color:red\">".$erreur."</span><br /><br />\n"; // On affiche le message correspondant � l'erreur
	}
	?>

	<!-- Formulaire HTML qu'on affiche dans l'�tat attente ou erreur -->
	<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>"> <!-- Les donn�es du formulaire seront r�cup�r�e avec la m�thode POST, et action correspond � la page contenant le formulaire -->
	<p style="text-align:left">
	<label for="son_pseudo">Pseudo *</label><br /> <!-- Intitul� du champ pseudo -->
	<input type="text" size="40" name="son_pseudo" id="son_pseudo" value="<?php
		if (!empty($_POST["son_pseudo"])) {
		// le pseudo de l'exp�diteur a �t� saisi --> le r�afficher
		echo htmlspecialchars($_POST["son_pseudo"],ENT_QUOTES); // htmlspecialchars() convertit les caract�res sp�ciaux en leurs code html, exemple : & devient &amp;
		}
		?>" />

	<br />

	<label for="son_email">E-mail *</label><br /> <!-- Intitul� du champ e-mail -->
	<input type="text" size="40" name="son_email" id="son_email" value="<?php
		if (!empty($_POST["son_email"])) {
		// l'e-mail de l'exp�diteur a �t� saisi --> le r�afficher
		echo htmlspecialchars($_POST["son_email"],ENT_QUOTES);
		}
		?>" />

	<br />

	<label for="son_url">URL de votre site</label><br /> <!-- Intitul� du champ url (facultatif) -->
	<input type="text" size="40" name="son_url" id="son_url" value="<?php
		if (!empty($_POST["son_url"])) {
		// l'url a �t� saisi --> la r�afficher
		echo htmlspecialchars($_POST["son_url"],ENT_QUOTES);
		}
		?>" />

	<br />

	<label for="son_objet">Objet *</label><br /> <!-- Intitul� du champ objet -->
	<input type="text" size="40" name="son_objet" id="son_objet" value="<?php
		if (!empty($_POST["son_objet"])) {
		// l'objet du message a �t� saisi --> le r�afficher
		echo htmlspecialchars($_POST["son_objet"],ENT_QUOTES);
		}
		?>" />

	<br />

	<label for="son_message">Message *</label><br /> <!-- Intitul� du champ message -->
	<textarea name="son_message" id="son_message" cols="60" rows="25"><?php
	if (isset($_POST["son_message"])) {
		// le message a �t� saisi --> le r�afficher
		echo htmlspecialchars($_POST["son_message"],ENT_QUOTES);
	}
	?>


	</textarea>

	<br />

	<input type="submit" name="envoyer" value="Envoyer" /><input type="reset" name="reset" value="Effacer" />
	</p>
	</form>
	<!-- FIN du formulaire HTML -->

	<?php
}
else { // Sinon l'�tat est ok donc on envoie le mail
	$son_pseudo = $_POST["son_pseudo"]; // On stocke les variables r�cup�r�es du formulaire
	$son_email = $_POST["son_email"];
	$son_url = $_POST["son_url"];
	$son_objet = $_POST["son_objet"];
	$son_message = $_POST["son_message"];

	$mon_email = "***"; // Mise en forme du message que vous recevrez
	$mon_pseudo = "***";
	$mon_url = "***";
	$msg_pour_moi = "- Son pseudo : $son_pseudo \n
	- Son E-mail : $son_email \n
	- Son site : $son_url \n
	- Objet du message : $son_objet \n
	- Message : \n $son_message \n\n";

	// Mise en forme de l'accus� r�ception qu'il recevra
	$accuse_pour_lui = "Bonjour $son_pseudo,\n
	Votre message nous a bien �t� envoy� et nous t�cherons de vous r�pondre le plus rapidement possible.\n\n
	- Votre E-mail : $son_email \n
	- Votre site : $son_url \n
	- L'objet de votre message : $son_objet \n
	- Votre message : \n $son_message \n\n
	Merci et � bient�t sur http://creer-un-site.fr !";

	// Envoie du mail
	$entete = "From: " . $mon_pseudo . " <" . $mon_email . ">\n"; // On pr�pare l'ent�te du message
	$entete .='Content-Type: text/plain; charset="iso-8859-1"'."\n"; 
	$entete .='Content-Transfer-Encoding: 8bit';

	if (@mail($mon_email,$son_objet,$msg_pour_moi,$entete) && @mail($son_email,$son_objet,$accuse_pour_lui,$entete)){ // Si le mail a �t� envoy�
		echo "<p style=\"text-align:center\">Votre message a &eacute;t&eacute; envoy&eacute;, vous recevrez une confirmation par mail.<br /><br />\n"; // On affiche un message de confirmation
		echo "<a href=\"" . $mon_url . "\">Retour</a></p>\n"; // Avec un lien de retour vers l'accueil du site
	}
	else { // Sinon il y a eu une erreur lors de l'envoi
		echo "<p style=\"text-align:center\">Un probl�me s'est produit lors de l'envoi du message.\n";
		echo "<a href=\"".$_SERVER["PHP_SELF"]."\">R�essayez...</a></p>\n"; // On propose un lien de retour vers le formulaire
	}
}
?> 