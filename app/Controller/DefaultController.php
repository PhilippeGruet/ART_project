<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\CategoriesModel;
use \Model\TestsModel;
use \Model\QuestionsModel;

class DefaultController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function home() {

		if ($this->getUser()) {
			// Récupération des catègories
			$categories_manager = new CategoriesModel();
			$categories = $categories_manager->findAll();

			// Récupération des normes
			$tests_manager = new TestsModel();
			$tests = $tests_manager->findAll();

			$this->show('default/home', [
				'categories' => $categories,
				'tests' => $tests,
			]);
		} else {
			$this->redirectToRoute('security_login');
		}

	}

	public function test($idTest) {

		$test_manager = new TestsModel();
		$test = $test_manager->find($idTest);

		$question_manager = new QuestionsModel();
		$questions = $question_manager->findAllByTest($idTest);

		$this->show('default/test', [
			'test' => $test,
			'questions' => $questions,
		]);
	}

	public function addQuestion() {
		// Default values
		$norme 		 = "";
		$newCategory = "";
		$newNorme 	 = "";
		$question 	 = "";
		$answer_1  	 = "";
		$answer_2 	 = "";
		$answer_3 	 = "";
		$answer_4 	 = "";
		$rightAnswer = "";
		$help 		 = "";
		$more_info 	 = "";

		// Messages d'erreurs
		$message    = [''];

		// Formulaire envoyé
		if ( !empty($_POST) ) {
			if ( isset( $_POST['norme'] ) ) {
				$norme 		 = trim($_POST['norme']);
			}
			$newCategory = trim($_POST['newCategory']);
			$newNorme 	 = trim($_POST['newNorme']);
			$question 	 = trim($_POST['question']);
			$answer_1  	 = trim($_POST['answer_1']);
			$answer_2 	 = trim($_POST['answer_2']);
			$answer_3 	 = trim($_POST['answer_3']);
			$answer_4 	 = trim($_POST['answer_4']);
			$rightAnswer = $_POST['optradio'];
			$help 		 = trim($_POST['help']);
			$more_info 	 = trim($_POST['more_info']);

			$errors = [];

			// Vérification des champs
			// Norme sélectionné
			if ( strlen($norme) == 0 ) {
				$errors["norme"] = "Vous devez sélectionner ou créer une norme.";
			}

			// En cas de volonté d'ajout de norme
			if ( $norme == "add" && ( empty($newCategory) || empty($newNorme) ) ) {
				$errors["addCategory"] = "Vous devez remplir ces champs.";
			}

			if ( strlen($norme) > 3 && empty($newNorme) && !is_numeric($norme) ) {
				$errors["addNorme"] = "Vous devez remplir ce champ.";

			}

			// Question
			if ( empty($question) ) {
				$errors["question"] = "Vous devez remplir le champ \"question\".";
			}

			// Réponses
			if ( empty($answer_1) || empty($answer_2) ) {
				$errors["answer_2"] = "Vous devez remplir au moins les deux premiers champs de réponses";
			}

			// Sélection de la réponse
			if ( empty( ${"answer_".$rightAnswer} ) ) {
				$errors["rightAnswer"] = "Vous devez sélectionner une des réponses que vous avez rempli.";
			}

			// Réponse 4 rempli mais 3 vide
			if ( empty($answer_3) && !empty($answer_4) ) {
				$errors["answer_4"] = "Veulliez remplir les champs dans l'ordre.";
			}

			var_dump($_POST);

			// Enregistrement en bdd, s'il n'y a pas d'erreurs
			if ( empty($errors) ) {
				if ( !is_numeric($norme) ) {
					
				}
				// Add category and norme/test
				if ($norme === "add") {
					$category_manager = new CategoriesModel();
					$id_cat = $category_manager->insert([
						'name' => $newCategory
					]);
					var_dump($id_cat);

					$norme_manager = new TestsModel();

				}

				// Add norme / test


				$question_manager = new QuestionsModel();
				// $user_manager->insert([
				// 	'lastname' => $lastname,
				// 	'firstname' => $firstname,
				// 	'email'    => $email,
				// 	'mdp' => $auth_manager->hashPassword( $password ),
				// 	'role'     => 'user',
				// 	]);
					$message = ['success'=>"La question a bien été ajouté dans la norme : ".$norme."."];
				} else {
					$message = $errors;
				}
				// Redirection

			}

			// Récupération des catègories
			$categories_manager = new CategoriesModel();
			$categories = $categories_manager->findAll();

			// Récupération des normes
			$tests_manager = new TestsModel();
			$tests = $tests_manager->findAll();

			// Affichage de la page
			$this->show('default/addQuestion', [
				'categories'  => $categories,
				'tests' 	  => $tests,
				'messages'    => $message,
				// Retour des values
				'norme'  	  => $norme,
				"newCategory" => $newCategory,
				"newNorme" 	  => $newNorme,
				"question" 	  => $question,
				"answer_1"    => $answer_1,
				"answer_2" 	  => $answer_2,
				"answer_3" 	  => $answer_3,
				"answer_4" 	  => $answer_4,
				"rightAnswer" => $rightAnswer,
				"help" 		  => $help,
				"more_info"   => $more_info,
			]);
		}


}
