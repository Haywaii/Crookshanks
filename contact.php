<?php
	// Si le formulaire a été soumis
	if (isset($_POST['m_submit']))
	{ 
		echo "COUCOU LES CROOKS 1\r\n";
		$etat = "ok"; // On initialise notre etat à ok, il sera changé à "erreur" si la vérification du formulaire n'est pas un succès, sinon il reste à ok
		
		// CONDITIONS IDENTITE
		if ( (isset($_POST['identity'])) && (strlen(trim($_POST['identity'])) > 0) ):
			$identity = stripslashes(strip_tags($_POST['identity']));
		else:
			$etat="erreur";
		endif;
		
		// CONDITIONS EMAIL
		if ( (isset($_POST['mail_address'])) && (strlen(trim($_POST['mail_address'])) > 0) && (filter_var($_POST['mail_address'], FILTER_VALIDATE_EMAIL)) ):
			$email = stripslashes(strip_tags($_POST['mail_address']));
		elseif (!preg_match("$[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\.[a-z]{2,4}$",$_POST['mail_address'])):
			$etat="erreur";
		else:
			$etat="erreur";
		endif;
		
		// CONDITION TELEPHONE
		if ( (isset($_POST['telephone'])) && (strlen(trim($_POST['telephone'])) > 0) ):
			$telephone = stripslashes(strip_tags($_POST['telephone']));
		endif;
	 
		// CONDITIONS SUBJECT
		if ( (isset($_POST['choice'])) && (strlen(trim($_POST['choice'])) > 0) ):
			$subject = stripslashes(strip_tags($_POST['choice']));
		else:
			$etat="erreur";
			$erreur= "Merci de choisir un type de sujet <br />";
		endif;
	  
		// CONDITIONS MESSAGE
		if ( (isset($_POST['mail_text'])) && (strlen(trim($_POST['mail_text'])) > 0) ):
			$message = stripslashes(strip_tags($_POST['mail_text']));
		else:
			$etat="erreur";
		endif;	
		
	}
	// Sinon le formulaire n'a pas été soumis
	else 
	{ 
		echo "COUCOU LES CROOKS 2\r\n";
		$etat="attente"; // On passe donc dans l'état attente
	}
	
	
	// Le formulaire a été soumis mais il y a des erreurs (etat=erreur) OU le formulaire n'a pas été soumis (etat=attente)
	if ($etat == "erreur" || $etat == "attente")
	{ 
		echo "COUCOU LES CROOKS 3\r\n";
		// Le formulaire a été soumis mais il y a des erreurs (etat=erreur) OU le formulaire n'a pas été soumis (etat=attente)
		if ($etat=="erreur"){ // Cas où le formulaire a été soumis mais il y a des erreurs
			echo "<span style=\"color:red\">".$erreur."</span><br /><br />\n"; // On affiche le message correspondant à l'erreur
		}
	}
	
	// Sinon l'état est ok on envoie le mail
	else 
	{
		echo "COUCOU LES CROOKS 4\n";
		// PREPARATION DES DONNEES
		$ip           = $_SERVER['REMOTE_ADDR'];
		$hostname     = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$destinataire = "hbmanu@gmail.com";
		$objet        = "[Crookshanks Lyon] ".$subject;
		$contenu      = "Email : ".$email. "\r\n";
		$contenu     .= "Expediteur : ".$identity."\r\n";
		$contenu     .= "TÃ©lÃ©phone : ".$telephone."\r\n";
		$contenu     .= "\r\n"."Message : ".$message."\r\n";
		$contenu     .= "Adresse IP de l'expediteur : ".$ip."\r\n";
		$contenu     .= "DLSAM : ".$hostname;
		$mon_url = "http://www.crookshansk-lyon.com";
	  
		$headers  = 'From: '.$email."\n"; // ici l'expéditeur du mail
		$headers .= "Reply-To: ".$email."\n";
		$headers .= "Content-Type: text/plain; charset=\"UTF-8\"; DelSp=\"Yes\"; format=flowed rn";
		$headers .= "Content-Disposition: inline rn";
		$headers .= "Content-Transfer-Encoding: 8bit rn";
		$headers .= "MIME-Version: 1.0";
		
		$url_contact = "http://ehalter.com/quidditch/Crookshanks/contact.htm";
		
		
		// Mise en forme de l'accusé réception qu'il recevra
		$accuse_demandeur = "Bonjour $identity,\n
		Votre message nous a bien Ã©tÃ© envoyÃ© et nous tÃ¢cherons de vous rÃ©pondre le plus rapidement possible.\n\n
		- Votre E-mail : $email \n
		- L'objet de votre message : $subject \n
		- Votre message : $message \n\n
		Merci et Ã  bientÃ´t sur http://www.crookshanks-lyon.com !";
		
		// Si le mail a été envoyé
		if ($_POST['mail_check'] == "non" && @mail($destinataire,$objet,$contenu,$headers) && @mail($email,$objet,$accuse_demandeur,$headers))
		{ 
			echo "<p style=\"text-align:center\">Votre message a Ã©tÃ© envoyÃ©, vous recevrez une confirmation par mail.<br /><br />\n"; // On affiche un message de confirmation
			echo "<a href=\"" . $mon_url . "\">Retour</a></p>\n"; // Avec un lien de retour vers l'accueil du site
		}
		// Sinon il y a eu une erreur lors de l'envoi
		else 
		{
			echo "<p style=\"text-align:center\">Un problÃ¨me s'est produit lors de l'envoi du message.\n";
			echo "<a href=\"".$url_contact."\">RÃ©essayez</a></p>\n"; // On propose un lien de retour vers le formulaire
		}
	}	
    // Les messages d'erreurs ci-dessus s'afficheront si Javascript est désactivé
?>