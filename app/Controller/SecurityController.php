<?php

namespace Controller;

use \W\Controller\Controller;
use Model\UserModel;

class SecurityController extends Controller
{
    /**
    * Inscription
    */
    public function register() {

        if ($this->getUser()) {
            $this->redirectToRoute('default_home');
            
        } else {
            $lastname   = '';
            $firstname   = '';
            $email      = '';
            $password   = '';
            $cfpassword = '';

            $message    = [''];

            // Formulaire envoyé
            if (!empty($_POST)) {
                $lastname   = trim($_POST['lastname']);
                $firstname  = trim($_POST['firstname']);
                $email      = trim($_POST['email']);
                $password   = trim($_POST['password']);
                $cfpassword = trim($_POST['cfpassword']);
                $errors = [];

                // Vérification des champs
                $user_manager = new UserModel();

                // Presence de l'email en bdd ?
                if ( $user_manager->emailExists($email) ) {
                    $errors['email'] = "L'email existe deja.";
                }

                // Nom et prenom
                if (empty($lastname) || empty($firstname)) {
                    $errors['firstname'] = "Veuillez remplir les champs \"nom\" et \"prénom\".";
                }

                // Champ valide
                if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
                    $errors['email'] = "L'email n'est pas valide.";
                }

                // Correspondance des mots de passe
                if ( strlen($password) < 4 ) {
                    $errors['password'] = "Veuillez choisir un mot de passe d'au moins 4 caractères.";
                }

                // Correspondance des mots de passe
                if ($password != $cfpassword) {
                    $errors['cfpassword'] = "Les mots de passe ne correspondent pas.";
                }

                // Enregistrement en bdd, s'il n'y a pas d'erreurs
                if ( empty($errors) ) {
                    $auth_manager = new \W\Security\AuthentificationModel();
                    $user_manager->insert([
                        'lastname'  => $lastname,
                        'firstname' => $firstname,
                        'email'     => $email,
                        'mdp'       => $auth_manager->hashPassword( $password ),
                        'role'      => 'user',
                        ]);
                        $message = ['success'=>"Vous etes bien inscrit, vous pouvez maintenant vous connecter."];
                } else {
                    $message = $errors;
                }
            }

            // Affichage de la page
            $this->show('security/register', [
                'messages'  => $message,
                'lastname'  => $lastname,
                'firstname' => $firstname,
                'email'     => $email,
            ]);            
        }
    }


    /**
    * Connexion
    */
    public function login() {

        if ($this->getUser()) {
            $this->redirectToRoute('default_home');
            
        } else {
            $username   = '';
            $message    = [''];

            if (!empty($_POST)) {
                $username   = trim($_POST['username']);
                $password   = trim($_POST['password']);

                $auth_manager = new \W\Security\AuthentificationModel();

                // Ca marche en php
                if ( $user_id = $auth_manager->isValidLoginInfo($username, $password) ) {
                    $user_manager = new UserModel();
                    $user = $user_manager->find($user_id);
                    $auth_manager->logUserIn($user);

                    // Redirection
                    $this->redirectToRoute('default_home');
                } else {
                    $message['error'] = "Mauvais Identifiant ou mot de passe";
                }
            }
            $this->show('security/login', [
                'message'=>$message,
                'username'=>$username,
            ]);
        }
    }


    /**
    * Reset password
    */
    public function forget() {
                // Redirection si l'utilisateur est deja connecté
        if ($this->getUser()) {
            $this->redirectToRoute('user_update');
        } else {
            $message = [];
            $user_manager = new UserModel();

            // S'il n'y a pas de token
            if ( empty($_GET) ) {
                // On demande son identifiant à l'utilisateur
                if ( empty($_POST) ) {
                    $this->show('security/forget', [
                        'messages' => $message,
                        'display' => "mail",
                    ]);
                } else {
                    // Le login a été rentré, on cherche son mail
                    $res = $user_manager->getUserByUsernameOrEmail($_POST["login"]);

                    if ($res) {
                        // Si on trouve l'utilisateur
                        // On lui genere une clé unique valable 48h max
                        $tomorrow = date('m').( date('d') + 1 );
                        $encrypt = $tomorrow.md5(( 1290*3+$res['id_user']) );

                        //
                        // echo "Clé : " . $tomorrow.( 1290*3+$res['id']) . "<br>";
                        // echo "Token : " . $encrypt."<br>";

                        // Ajout du token dans la bdd
                        $newData['token'] = $encrypt;
                        $user_manager->update($newData, $res['id_user']);

                        // Préparation du mail :
                        // Création de l'url de reset password
                        $url = $_SERVER['HTTP_REFERER'];
                        $url .= "?token=".$encrypt;

                        // Contenu du mail
                        $message = "
                        <html>
                            <head>
                                <title>Créez votre nouveau mot de passe</title>
                            </head>
                            <body>
                                  <p>Bonjour ".$res['firstname']." ".$res['lastname'].",</p>

                                <p>Vous avez demandé un nouveau mot de passe afin d'accéder à votre compte.</p>

                                <p>Pour définir votre nouveau mot de passe, cliquez sur ce lien</p>
                                <p><a href='".$url."'>".$url."</a></p>

                                <p>Pour des raisons de sécurité, ce lien de changement de mot de passe expirera dans 2 jours (ou après que vous ayez créé votre nouveau mot de passe).</p>
                            </body>
                        </html>";

                        // Header du mail
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                        // Envoie du mail
                        mail($res['email'], 'Créez votre nouveau mot de passe', $message, $headers);
                        var_dump($message);

                        $this->show('security/forget', [
                            'display' => "mailSent",
                            'mail' => $url,
                        ]);
                    } else {
                        $this->show('security/forget', [
                            'messages' => ["Identifiant invalide"],
                            'display' => "mail",
                        ]);
                    }
                }

            // Si on a un parametre dans l'url
            } else {
                if ( isset($_GET['token']) ) {
                    $errors = [];

                    // Formulaire de mot de passe envoyé
                    if ( !empty($_POST) ) {
                        $password   = trim($_POST['password']);
                        $cfpassword = trim($_POST['cfpassword']);
                        $auth_manager = new \W\Security\AuthentificationModel();

                        // Vérif. mot de passe
                        if ( $password !== $cfpassword ) {
                            $errors['cfpassword'] = "Les mots de passe ne correspondent pas.";
                        } elseif ( strlen($password) < 8 ) {
                            $errors['password'] = "Le mot de passe doit contenir au moins 8 caractéres.";
                        } elseif ( !ctype_alnum($password) ) {
                            $errors['password'] = "Le mot de passe doit contenir au moins un chiffre et une lettre.";
                        }
                        $newData['password'] = $auth_manager->hashPassword( $password );

                        // S'il n'y a pas d'erreur
                        if ( empty($errors) ) {
                            // On cherche le token dans la table users
                            $result = $user_manager->search( ['token' => $_GET['token']] );
                            foreach ($result as $value) {
                                if ($value['token'] == $_GET['token']){
                                    // On récupére l'user avec le token exact
                                    $user = $value;
                                }
                            }
                            // Si l'utilisateur a été trouvé
                            if (isset($user)) {
                                // Token validity
                                // echo substr($user['token'], 0, 4);
                                // echo date('md');

                                // On détruit le token
                                $newData['token'] = "";

                                // Si le token a expiré
                                if (substr($user['token'], 0, 4) < date('md')) {
                                    unset($newData['password']);

                                    // On supprime le token sans changer le mot de passe
                                    $user_manager->update($newData, $user['id']);
                                    $this->show('security/forget', [
                                        'DefaultModel' => $DefaultModel,
                                        'display' => "error",
                                        'message' => "Le lien n'est plus valide.",
                                    ]);
                                } else {
                                    // On modifie le mot de passe
                                    $user_manager->update($newData, $user['id']);
                                    $this->redirectToRoute('user_login');
                                    echo "Modif. password";
                                }
                            } else {
                                // Si on n'a pas trouvé l'utilisateur
                                $this->show('security/forget', [
                                    'display' => "error",
                                    'message' => "Le lien n'est pas valide.",
                                ]);
                            }
                        } else {
                            $message['error'] = "Mot de passe incorect";
                        }
                    }
                    $DefaultModel->refreshTimer();
                    $this->show('security/forget', [
                        'messages' => $message,
                        'errors' => $errors,
                        'display' => "password",
                    ]);
                }
            }
        }
        $this->show('security/forget', [
            'display' => "error",
            'message' => "Le lien n'est pas valide.",
        ]);
    }


    /**
    * Profil
    */
    public function profil() {
        $this->show('security/profil');
    }

    /**
    * Update
    */
    public function updateProfil() {
        $this->show('security/updateProfil');
    }


    /**
    * Déconnexion
    */
    public function logout() {
        $auth_manager = new \W\Security\AuthentificationModel();
        $auth_manager->logUserOut();
        $this->redirectToRoute('default_home');
    }



}
