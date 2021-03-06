<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\CategoriesModel;
use \Model\TestsModel;
use \Model\QuestionsModel;
use \Model\User_progression_testModel;

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

		$progression_manager = new User_progression_testModel();
		$progression = $progression_manager->findByUserID($idTest, 1);
		// var_dump($progression);
		$this->show('default/test', [
			'progression' => $progression,
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

			// Enregistrement en bdd, s'il n'y a pas d'erreurs
			if ( empty($errors) ) {

				$normeToAddIn = is_numeric($norme) ? $norme : "newNorme" ;

				// Add category and norme/test
				if ( substr($norme, 0, 3) === "add" ) {
					$id_cat = "";
					// Create new category
					if ( strlen($norme) == 3 ) {
						$category_manager = new CategoriesModel();
						$id_cat = $category_manager->insert([
							'name' => $newCategory
						]);
						$id_cat = $id_cat["id_category"];
					} else {
						$id_cat = substr($norme, 4);
					}
					// Create new norme/test
					$norme_manager = new TestsModel();
					$id_norme = $norme_manager->insert([
							'name' => $newNorme,
							'id_category' => $id_cat
					]);
					$normeToAddIn = $id_norme["id_test"];
				}

				// Add question
				$question_manager = new QuestionsModel();
				$question_manager->insert([
						"question"		=> $question,
						"answer_1" 		=> $answer_1,
						"answer_2" 		=> $answer_2,
						"answer_3" 		=> $answer_3,
						"answer_4" 		=> $answer_4,
						"good_answer" 	=> $rightAnswer,
						"id_test" 		=> $normeToAddIn,
						"help" 			=> $help,
						"more_info" 	=> $more_info,
				]);
				$message = ['success'=>"La question a bien été ajouté."];
			} else {
				$message = $errors;
			}
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
