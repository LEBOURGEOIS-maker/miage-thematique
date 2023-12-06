<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Product;
use App\Entity\AbsencesJustifications;
use App\Entity\Pointage;
use App\Entity\Utilisateur;

use App\Form\ProductType;
use App\Form\RecherchePointageType;
use App\Form\RechercheAnomalieType;
use App\Form\RecherchePointagePeriodeType;
use App\Form\RechercheAnomaliePeriodeType;

use DateTimeImmutable;
date_default_timezone_set('Europe/Paris');

class PanelAdminAbsencesController extends AbstractController
{
  public function AbsenceUpdateState(EntityManagerInterface $em, Request $request) {
 
    $id = $request->get("id");
    $valider = $request->get("valider");
    $absencesJustifications = $em->getRepository(AbsencesJustifications::class)->find($id);
    if (!$absencesJustifications) {
      throw $this->createNotFoundException(
          "L'entité $id n'existe pas"
      );
    }
   $absencesJustifications->setValider( $valider ); // à condition que setValider() existe dans l'entité
   $em->flush();
 
    return new Response( 
       Response::HTTP_OK
    );
  }


  public function AbsenceSendMail(Request $request) {

    ini_set('SMTP','smtp.partage.renater.fr');

    $id = $request->get("id");
    $nom = $request->get("etudiant");
    $email = $request->get("email");
    $valider = $request->get("valider");

    $objet = "[UPJV] Une justification d absence a recu une reponse!";
    if ($valider == 0) {
      $message = "Cher etudiant,  l administration MIAGE a defini 'en attente' l une de vos justifications d'absences. Vous pouvez consulter cette modification sur Chronos.";
    } elseif ($valider == 1){
       $message = "Cher etudiant, l administration MIAGE a refuse l une de vos justifications d'absences. Vous pouvez consulter cette modification sur Chronos.";
    } elseif ($valider == 2){
      $message = "Cher etudiant, l administration MIAGE a valide l une de vos justifications d'absences.Vous pouvez consulter cette modification sur Chronos.";
      } 
        /*
    	********************************************************************************************
    	CONFIGURATION
    	********************************************************************************************
    */
    // destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
    $destinataire = 'x@hotmail.fr';
     
    // copie ? (envoie une copie au visiteur)
    $copie = 'oui';
     
    // Action du formulaire (si votre page a des paramètres dans l'URL)
    // si cette page est index.php?page=contact alors mettez index.php?page=contact
    // sinon, laissez vide
    $form_action = '';
     
    // Messages de confirmation du mail
    //$message_envoye = "Votre message nous est bien parvenu !";
    $message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
     
    // Message d'erreur du formulaire
    $message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.";
     
    /*
    	********************************************************************************************
    	FIN DE LA CONFIGURATION
    	********************************************************************************************
    */
     
    /*
     * cette fonction sert à nettoyer et enregistrer un texte
     */
    function Rec($text)
    {
    	$text = htmlspecialchars(trim($text), ENT_QUOTES);
    	if (1 === get_magic_quotes_gpc())
    	{
    		$text = stripslashes($text);
    	}
     
    	$text = nl2br($text);
    	return $text;
    };
     
    /*
     * Cette fonction sert à vérifier la syntaxe d'un email
     */
    function IsEmail($email)
    {
    	$value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
    	return (($value === 0) || ($value === false)) ? false : true;
    }
     
    // formulaire envoyé, on récupère tous les champs.
    /*
    $nom     = (isset($_POST['nom']))     ? Rec($_POST['nom'])     : '';
    $email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
    $objet   = (isset($_POST['objet']))   ? Rec($_POST['objet'])   : '';
    $message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';
    */
    
    // On va vérifier les variables et l'email ...
    $email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erroné, soit il vaut l'email entré
    $err_formulaire = false; // sert pour remplir le formulaire en cas d'erreur si besoin
     

			if ($email == '') { 
        $email = "admin@u-picardie.fr"; }

    	if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
    	{
    		// les 4 variables sont remplies, on génère puis envoie le mail
    		$headers  = 'From:'.$nom.' <'.$email.'>' . "\r\n";
    		//$headers .= 'Reply-To: '.$email. "\r\n" ;
    		//$headers .= 'X-Mailer:PHP/'.phpversion();
     
    		// envoyer une copie au visiteur ?
    		if ($copie == 'oui')
    		{
    			$cible = $destinataire.';'.$email;
    		}
    		else
    		{
    			$cible = $destinataire;
    		};
     
    		// Remplacement de certains caractères spéciaux
    		$message = str_replace("&#039;","'",$message);
    		$message = str_replace("&#8217;","'",$message);
    		$message = str_replace("&quot;",'"',$message);
    		$message = str_replace('&lt;br&gt;','',$message);
    		$message = str_replace('&lt;br /&gt;','',$message);
    		$message = str_replace("&lt;","&lt;",$message);
    		$message = str_replace("&gt;","&gt;",$message);
    		$message = str_replace("&amp;","&",$message);
     
    		// Envoi du mail
    		$num_emails = 0;
    		$tmp = explode(';', $cible);
    		foreach($tmp as $email_destinataire)
    		{
    			if (mail($email_destinataire, $objet, $message, $headers))
    				$num_emails++;
    		}
     
    		if ((($copie == 'oui') && ($num_emails == 2)) || (($copie == 'non') && ($num_emails == 1)))
    		{
    			echo 'le mail a bien été envoyé';
    		}
    		else
    		{
    			echo '<p>'.$message_non_envoye.'</p>';
    		};
    	}
    	else
    	{
    		// une des 3 variables (ou plus) est vide ...
    		echo '<p>'.$message_formulaire_invalide.'</p>';
    		$err_formulaire = true;
    	};
     

    return new Response(
      $email, 
       Response::HTTP_OK
    );
  }

  public function justificationsAbsences(EntityManagerInterface $em, Request $request)
  {
    $dateDebut = new \DateTime();
    $dateFin = new \DateTime();
    $dateDebut = $dateDebut->setTimestamp(strtotime('today midnight'));
    $dateFin = $dateFin->setTimestamp(strtotime('today 23:59:59'));

    $countPointages = $em->getRepository(Pointage::class)->CountAnomalieByDate($em, $dateDebut, $dateFin);
    $countRetard = $em->getRepository(Pointage::class)->CountRetardByDate($em, $dateDebut, $dateFin);
    $countDepartAvance = $em->getRepository(Pointage::class)->CountPartiAvanceByDate($em, $dateDebut, $dateFin);
    $listeDePointage = $em->getRepository(AbsencesJustifications::class)->findAllJustifiedAbsences($em);

    $formPointage=$this->createForm(RecherchePointageType::class);
    $formAnomalie=$this->createForm(RechercheAnomalieType::class);
    $formPeriode=$this->createForm(RecherchePointagePeriodeType::class);
    $formPeriodeAnomalie=$this->createForm(RechercheAnomaliePeriodeType::class);
    $formPointage->handleRequest($request);
    $formAnomalie->handleRequest($request);
    $formPeriode->handleRequest($request);
    $formPeriodeAnomalie->handleRequest($request);

    if ($formPointage->isSubmitted()) {
      $dateDebutCustom = date_create();
      date_isodate_set($dateDebutCustom, $formPointage['annee']->getData(), $formPointage['semaine']->getData(), 1);
      $dateFinCustom = date_create();
      date_isodate_set($dateFinCustom, $formPointage['annee']->getData(), $formPointage['semaine']->getData(), 7);
      return $this->redirectToRoute('panelAdminSemaine', array('dateD' => $dateDebutCustom->format('Y.m.d'), 'dateF' => $dateFinCustom->format('Y.m.d')));
    } else if ($formAnomalie->isSubmitted()) {
      $dateDebutCustom = date_create();
      date_isodate_set($dateDebutCustom, $formAnomalie['annee']->getData(), $formAnomalie['semaine']->getData(), 1);
      $dateFinCustom = date_create();
      date_isodate_set($dateFinCustom, $formAnomalie['annee']->getData(), $formAnomalie['semaine']->getData(), 7);
      return $this->redirectToRoute('panelAdminSemaineAnomalie', array('dateD' => $dateDebutCustom->format('Y.m.d'), 'dateF' => $dateFinCustom->format('Y.m.d')));
    } else if ($formPeriode->isSubmitted() && $formPeriode->isValid()) {
      $periode = $formPeriode['periode']->getData();
      $periode = str_replace('/', '.', $periode);
      $dates = explode("-", $periode);
      return $this->redirectToRoute('panelAdminPeriode', array('dateD' => $dates[0], 'dateF' => $dates[1]));
    } else if ($formPeriodeAnomalie->isSubmitted() && $formPeriodeAnomalie->isValid()) {
      $periode = $formPeriodeAnomalie['periode']->getData();
      $periode = str_replace('/', '.', $periode);
      $dates = explode("-", $periode);
      return $this->redirectToRoute('panelAdminPeriodeAnomalie', array('dateD' => $dates[0], 'dateF' => $dates[1]));
    }

    return $this->render('panelAdminJustificationAbsence.html.twig', array('formPointage' => $formPointage->createView(),
                                                       'formAnomalie' => $formAnomalie->createView(),
                                                       'formPeriode' => $formPeriode->createView(),
                                                       'formPeriodeAnomalie' => $formPeriodeAnomalie->createView(),
                                                       'listeDePointage' => $listeDePointage,
                                                       'pointage' => $countPointages,
                                                       'retard' => $countRetard,
                                                       'avance' => $countDepartAvance));
  }
}
