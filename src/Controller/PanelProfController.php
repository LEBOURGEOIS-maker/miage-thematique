<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use \PDO;

use App\Entity\Product;
use App\Entity\Pointage;
use App\Entity\Formation;
use App\Entity\AbsencesJustifications;
use App\Entity\Cours;
use App\Entity\ProfCours;
use App\Entity\Utilisateur;

use App\Form\ProductType;
use App\Form\PointageFiltreType;
use App\Form\RecherchePointageType;
use App\Form\RechercheAnomalieType;
use App\Form\RecherchePointagePeriodeType;
use App\Form\RechercheAnomaliePeriodeType;


date_default_timezone_set('Europe/Paris');

class PanelProfController extends AbstractController
{
		public function pointageViewerTeacher(Request $request, EntityManagerInterface $em)
			{
					$listeformation = $em->getRepository(Formation::class)->findAll();
					$listecours = $em->getRepository(Cours::class)->findAll();
	//				$formation = new Formation();
	//				$newpointage = new Pointage();

					$form = $this->createForm(PointageFiltreType::class, null, ['formations' => $listeformation, 'cours' => $listecours]);
					$form->handleRequest($request);
					if ($form->isSubmitted() && $form->isValid()) {
						$cours = $form['cours']->getData();
						$listeDePointage = $em->getRepository(Pointage::class)->findPointageByUEForToday($em, $cours->getNomUe());
						$newpointage = new Pointage();
						if ($listeDePointage != null)
						{
							$newpointage = $listeDePointage[0];
							$nbpointage = count($listeDePointage);

							return $this->render('pointageViewerTeacher.html.twig', [
									'form' => $form->createView(), 'listeDePointage' => $listeDePointage, 'newpointage' => $newpointage, 'nbpointage' => $nbpointage
							]);
						}
					}

					return $this->render('pointageViewerTeacher.html.twig', [
							'form' => $form->createView(), 'listeDePointage' => null, 'newpointage' => null, 'nbpointage' => null
					]);
			}
			public function updateState(EntityManagerInterface $em, Request $request) {
 
				$id = $request->get("id");
				$absence = $request->get("absence");
				if ($absence == 1) { 
					$absence = true;
				}
				if ($absence == 0) { 
					$absence = false;
				}
				$editAbsence = $em->getRepository(Pointage::class)->find($id);
				if (!$editAbsence) {
				  throw $this->createNotFoundException(
					  "L'entité $id n'existe pas"
				  );
				}
			   $editAbsence->setAbsence( $absence );
			   $em->flush();
			   
				return new Response(
				  'Ok', 
				   Response::HTTP_OK
				);
			  }
			  public function AbsenceSendMail(Request $request) {
			
				ini_set('SMTP','smtp.partage.renater.fr'); 
			
				$id = $request->get("id");
				$nom = $request->get("etudiant");
				$email = $request->get("email");
				$absence = $request->get("absence");
			
				$objet = "[UPJV] Un pointage a recu une modification!";
				if ($absence == 0) {
					$message = "Cher etudiant, un enseignant a defini le statut de l un de vos pointages en 'present'. Vous pouvez consulter cette modification sur Chronos.";
				} elseif ($absence == 1){
				$message = "Cher etudiant, un enseignant a defini le statut de l un de vos pointages en 'absent'. Vous pouvez consulter cette modification sur Chronos.";
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
							$email = $request->get("email"); }
			
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
							echo 'Le mail a bien ete envoye.';
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

			  
			public function profListeCours(EntityManagerInterface $em, Request $request): Response
			{
			  $session = $this->get('session');
			  $user = $this->getUser();
			  $teacherId = $user->getId();

			  $listeDePointage = $em->getRepository(ProfCours::class)->findAllLessonsByTeacher($em, $teacherId);
		  
			  return $this->render('profListeCours.html.twig', array('prenom' => $user->getPrenomUtilisateur(), 
			  'nom' => $user->getNomUtilisateur(), 'listeDePointage' => $listeDePointage));
			}

			public function emargementsParCours(EntityManagerInterface $em, Request $request): Response
			{
			  $session = $this->get('session');
			  $user = $this->getUser();
			  $teacherId = $user->getId();
			  $idCours = $request->get('idCours');
			  //dd($idCours);
			  $utilisateurEtudiant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user);

			  $listeDePointage = $em->getRepository(ProfCours::class)->findHorairesParCours($em, $teacherId, $idCours);

		  
			  return $this->render('profEmargementsParCours.twig', array(
																 'listeDePointage' => $listeDePointage,
																 'prenom' => $user->getPrenomUtilisateur(), 
																 'nom' => $user->getNomUtilisateur()));
			}
			public function listeEmargementsPassesParCours(EntityManagerInterface $em, Request $request): Response
			{
			  $dateDebut = new \DateTime();
			  $dateFin = new \DateTime();
			  $dateDebut = $dateDebut->setTimestamp(strtotime('today midnight'));
			  $dateFin = $dateFin->setTimestamp(strtotime('today 23:59:59'));

			  $session = $this->get('session');
			  $user = $this->getUser();
			  $teacherId = $user->getId();
			  $idCours = $request->get('idCours');
			  $idDate = $request->get('idDate');
			  $idCreneau = $request->get('idCreneau');
			  //var_dump($idCours);
			  //var_dump($idCreneau);
			  //var_dump($idDate);
			  $utilisateurEtudiant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user);
		  
			  $listeDePointage = $em->getRepository(ProfCours::class)->findAllEmargementsPassesParCours($em, $teacherId, $idCours, $idDate, $idCreneau);
			  //$pasdePointage = $em->getRepository(ProfCours::class)->findEtudiantPasPointer($em, $teacherId, $idCours, $idDate, $idCreneau);
			  $pasdePointage = $this->pasPointer($idCours, $idDate, $idCreneau);
			  $tousLesInscrits = $this->tousLesInscrits($idCours, $idDate, $idCreneau);
			  //var_dump($pasdePointage);

			  return $this->render('panelProfListeEmargements.twig', array(
																 'listeDePointage' => $listeDePointage,
																 'pasdePointage' => $pasdePointage,
																 'tousLesInscrits' => $tousLesInscrits,
																 'prenom' => $user->getPrenomUtilisateur(), 
																 'nom' => $user->getNomUtilisateur()));
			}
			public function pasPointer($idCours, $idDate, $idCreneau) {
				try { $bdd = new \PDO('mysql:host=localhost;dbname=chronos_gr2_2019-2020', 'chronos_assiduite', 'miagem2prothem', array (PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));}
				catch (Exception $e) {
					die('Erreur : ' . $e->getMessage()) ; }
				$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$requestPasPointer = "SELECT ec.etudiant, u.prenom_utilisateur, u.nom_utilisateur, u.numero_etudiant
				FROM etudiant_cours ec
				inner JOIN utilisateur u on u.id = ec.etudiant         
				left JOIN pointage po 
					inner JOIN cours_planning cp 
					   on cp.id = po.cours_id 
					  and cp.cours = :idCours
					  and cp.plage_horaire_id = :idCreneau
					  and cp.date_cours = :idDate
				  ON po.utilisateur_etudiant_id = ec.etudiant
				where po.utilisateur_etudiant_id is null
				;";				
				$exectPasPointer = $bdd->prepare( $requestPasPointer );
				$exectPasPointer->execute( array( 
				':idCours' => $idCours,
				':idDate' => $idDate,
				':idCreneau' => $idCreneau
				));
				return $exectPasPointer;
			}
			public function tousLesInscrits($idCours, $idDate, $idCreneau) {
				try { $bdd = new \PDO('mysql:host=localhost;dbname=chronos_gr2_2019-2020', 'chronos_assiduite', 'miagem2prothem', array (PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));}
				catch (Exception $e) {
					die('Erreur : ' . $e->getMessage()) ; }
				$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$requestPointer = "SELECT DISTINCT ec.etudiant, u.prenom_utilisateur, u.nom_utilisateur, u.numero_etudiant
				FROM etudiant_cours ec
				inner JOIN utilisateur u on u.id = ec.etudiant         
				left JOIN pointage po 
					inner JOIN cours_planning cp 
					   on cp.id = po.cours_id 
					  and cp.cours = :idCours
					  and cp.plage_horaire_id = :idCreneau
					  and cp.date_cours = :idDate
				  ON po.utilisateur_etudiant_id = ec.etudiant
				;";				
				$requestPointer = $bdd->prepare( $requestPointer );
				$requestPointer->execute( array( 
				':idCours' => $idCours,
				':idDate' => $idDate,
				':idCreneau' => $idCreneau
				));
				return $requestPointer;
			}

}
