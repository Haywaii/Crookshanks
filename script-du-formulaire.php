<?php
if (isset($_POST["envoyer"])){ // Si le formulaire a été soumis
	$etat = "erreur"; // On initialise notre etat à erreur, il sera changé à "ok" si la vérification du formulaire est un succès, sinon il reste à erreur

	// On récupère les champs du formulaire, et on arrange leur mise en forme
	if (isset($_POST["son_pseudo"])) $_POST["son_pseudo"]=trim(stripslashes($_POST["son_pseudo"])); // trim()  enlève les espaces en début et fin de chaine

	if (isset($_POST["son_email"])) $_POST["son_email"]=trim(stripslashes($_POST["son_email"])); // stripslashes()  retire les backslashes ==> \' devient '

	if (isset($_POST["son_url"])) $_POST["son_url"]=trim(stripslashes($_POST["son_url"]));

	if (isset($_POST["son_objet"])) $_POST["son_objet"]=trim(stripslashes($_POST["son_objet"]));

	if (isset($_POST["son_message"])) $_POST["son_message"]=trim(stripslashes($_POST["son_message"]));

	// Après la mise en forme, on vérifie la validité des champs
	if (empty($_POST["son_pseudo"])) { // L'utilisateur n'a pas rempli le champ pseudo
		$erreur="Vous n'avez pas entr&eacute; votre pseudo..."; // On met dans erreur le message qui sera affiché
	}
	elseif (empty($_POST["son_email"])) { // L'utilisateur n'a pas rempli le champ email
		$erreur="Nous avons besoin de votre e-mail pour vous r&eacute;pondre...";
	}
	elseif (!preg_match("$[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\.[a-z]{2,4}$",$_POST["son_email"])){ // On vérifie si l'email est bien de la forme messagerie@domaine.tld (cf cours d'expressions régulières)
		$erreur="Votre adresse e-mail n'est pas valide...";
	}
	elseif (empty($_POST["son_objet"])) { // L'utilisateur n'a pas rempli le champ objet
		$erreur="Vous devez entrer l'objet de votre message...";
	}
	elseif (empty($_POST["son_message"])) { // L'utilsateur n'a écrit aucun message
		$erreur="Merci de saisir un message...";
	}
	else { // Si tous les champs sont valides, on change l'état à ok
		$etat="ok";
	}
}
else { // Sinon le formulaire n'a pas été soumis
	$etat="attente"; // On passe donc dans l'état attente
}

if ($etat!="ok"){ // Le formulaire a été soumis mais il y a des erreurs (etat=erreur) OU le formulaire n'a pas été soumis (etat=attente)
	if ($etat=="erreur"){ // Cas où le formulaire a été soumis mais il y a des erreurs
		echo "<span style=\"color:red\">".$erreur."</span><br /><br />\n"; // On affiche le message correspondant à l'erreur
	}
	?>

	<!-- Formulaire HTML qu'on affiche dans l'état attente ou erreur -->
	<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>"> <!-- Les données du formulaire seront récupérée avec la méthode POST, et action correspond à la page contenant le formulaire -->
	<p style="text-align:left">
	<label for="son_pseudo">Pseudo *</label><br /> <!-- Intitulé du champ pseudo -->
	<input type="text" size="40" name="son_pseudo" id="son_pseudo" value="<?php
		if (!empty($_POST["son_pseudo"])) {
		// le pseudo de l'expéditeur a été saisi --> le réafficher
		echo htmlspecialchars($_POST["son_pseudo"],ENT_QUOTES); // htmlspecialchars() convertit les caractères spéciaux en leurs code html, exemple : & devient &amp;
		}
		?>" />

	<br />

	<label for="son_email">E-mail *</label><br /> <!-- Intitulé du champ e-mail -->
	<input type="text" size="40" name="son_email" id="son_email" value="<?php
		if (!empty($_POST["son_email"])) {
		// l'e-mail de l'expéditeur a été saisi --> le réafficher
		echo htmlspecialchars($_POST["son_email"],ENT_QUOTES);
		}
		?>" />

	<br />

	<label for="son_url">URL de votre site</label><br /> <!-- Intitulé du champ url (facultatif) -->
	<input type="text" size="40" name="son_url" id="son_url" value="<?php
		if (!empty($_POST["son_url"])) {
		// l'url a été saisi --> la réafficher
		echo htmlspecialchars($_POST["son_url"],ENT_QUOTES);
		}
		?>" />

	<br />

	<label for="son_objet">Objet *</label><br /> <!-- Intitulé du champ objet -->
	<input type="text" size="40" name="son_objet" id="son_objet" value="<?php
		if (!empty($_POST["son_objet"])) {
		// l'objet du message a été saisi --> le réafficher
		echo htmlspecialchars($_POST["son_objet"],ENT_QUOTES);
		}
		?>" />

	<br />

	<label for="son_message">Message *</label><br /> <!-- Intitulé du champ message -->
	<textarea name="son_message" id="son_message" cols="60" rows="25"><?php
	if (isset($_POST["son_message"])) {
		// le message a été saisi --> le réafficher
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
else { // Sinon l'état est ok donc on envoie le mail
	$son_pseudo = $_POST["son_pseudo"]; // On stocke les variables récupérées du formulaire
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

	// Mise en forme de l'accusé réception qu'il recevra
	$accuse_pour_lui = "Bonjour $son_pseudo,\n
	Votre message nous a bien été envoyé et nous tâcherons de vous répondre le plus rapidement possible.\n\n
	- Votre E-mail : $son_email \n
	- Votre site : $son_url \n
	- L'objet de votre message : $son_objet \n
	- Votre message : \n $son_message \n\n
	Merci et à bientôt sur http://creer-un-site.fr !";

	// Envoie du mail
	$entete = "From: " . $mon_pseudo . " <" . $mon_email . ">\n"; // On prépare l'entête du message
	$entete .='Content-Type: text/plain; charset="iso-8859-1"'."\n"; 
	$entete .='Content-Transfer-Encoding: 8bit';

	if (@mail($mon_email,$son_objet,$msg_pour_moi,$entete) && @mail($son_email,$son_objet,$accuse_pour_lui,$entete)){ // Si le mail a été envoyé
		echo "<p style=\"text-align:center\">Votre message a &eacute;t&eacute; envoy&eacute;, vous recevrez une confirmation par mail.<br /><br />\n"; // On affiche un message de confirmation
		echo "<a href=\"" . $mon_url . "\">Retour</a></p>\n"; // Avec un lien de retour vers l'accueil du site
	}
	else { // Sinon il y a eu une erreur lors de l'envoi
		echo "<p style=\"text-align:center\">Un problème s'est produit lors de l'envoi du message.\n";
		echo "<a href=\"".$_SERVER["PHP_SELF"]."\">Réessayez...</a></p>\n"; // On propose un lien de retour vers le formulaire
	}
}
?> 