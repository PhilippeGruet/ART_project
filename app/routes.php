<?php

	$w_routes = array(
		// Accueil
		['GET', 	 '/', 				'Default#home', 'default_home'],

		// QCM
		['GET', 	 '/test/[:idTest]', 'Default#test', 'default_test'],

		// User
		['GET|POST', '/register', 		'Security#register', 'security_register'],
		['GET|POST', '/login', 			'Security#login', 'security_login'],
		['GET|POST', '/forget', 		'Security#forget', 'security_forget'],
		['GET|POST', '/profil', 		'Security#profil', 'security_profil'],
		['GET|POST', '/profil/update', 	'Security#updateProfil', 'security_update'],
		['GET',		 '/logout', 		'Security#logout', 'security_logout'],

		// Admin
		['GET|POST', '/addQuestion', 	'Default#addQuestion', 'default_addQuestion'],
	);
