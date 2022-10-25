<?php 
	/* *** instructions ***

		This code is what might be the beginning of view logic to help build a display of 
		search results. The code is short, and so may not look too bad, but it shows a lot of 
		examples of bad practice. 
		
		Please refactor this file using an object-oriented style. You can ignore "gatherer.php", 
		just imagine that it's a third-party library you're using. You should consider how the 
		following concepts are not exhibited in the code:
		
		- separation of concerns (i.e. keeping presentation code separate from data logic)
		- self documenting code (is it clear from function/variable names & organization what is going on?)
		- Single-responsibility principle (is too much being done in one place, or one function?)

		You may change anything to reorganized the code, create more php files, rename variables
		and methods, and move code around. You don't need to improving the actual implimentation, 
		that is, the output does not need to change. The challenge is about making the code clearer 
		and more maintainable. Do not use libraries or frameworks.


		Here are some good resources on object-oriented programming in PHP:
		https://www.phptutorial.net/php-oop/php-typed-properties/
		https://www.w3schools.com/php/php_oop_what_is.asp



		If you have PHP installed, you can run a php test server with these commands:

		$cd [path to the folder where you unzipped the files]
		$php -S localhost:8000

		And then open a browser (you might need to try a few, I had trouble with Vivaldi Browser)
		localhost:8000/refactor.php

		But you can do this work without actually seeing the output.

	*/


	//don't change this, imagine it's your connection to a real database.
	require("gatherer.php");

	//Also leave this as is: imagine that we had received user input from a search query
	$searchTerm = "brass";




	

	//-----------------------------------------------------
	//everything from here on is what you should refactor.
	//-----------------------------------------------------


	$jsonData = Gatherer::RetrieveJson("/some-url-to-api?count=5");




	function prep($description, $searchWord, $startingElement, $endingElement, $trimCharLength, $trimEndingStr = "..."){
		
		$temp = $startingElement . $searchWord . $endingElement;
		$temp2 = str_replace($searchWord, $temp, $description);
		$temp3 = substr($temp2, 0, $trimCharLength);

		return $temp3 . $trimEndingStr;
	}




	function parseData($jsonData, $searchTerm){

		$data = json_decode($jsonData, true);

		foreach($data as $key => $value){

			if(isset($value['published']) && $value['published'] === true){

				print "<div><h2>" . $key . "</h2>";

				$image = $value['image'];

				//look for images from the copyrighted folders
				if(strpos($image, '/images2') !== false){

					if(strpos($image, "_lg.jpg") !== false){
						print '<img src="/path/to/copyrighted/logo.jpg"/>' . "\n";
						print "<p><b>This image only available if you login.</b></p>\n";
					} else {
						print '<img src="/path/to/copyrighted/logo.jpg"/>' . "\n";
						print "<img src=\"" . $value['image'] . "\"/>\n";
					}

				} else {
					print "<img src=\"" . $value['image'] . "\"/>\n";
				}

				if(isset($value['description'])) $description = prep($value['description'], $searchTerm, "<b class=\"hilite\">", "</b>", 160 );
				print "<p class=\"description\">" . $description . "</p>\n";
				print "</div>\n";
			}

		}
	}


?>
<html>
<head>
	<style>
		/* Don't worry about the css */
		div {
			max-width: 500px;
			clear: both;
		}
		img {
			float: right; 
			max-width: 300px;
		}

		.hilite {
			background: yellow;
		}

	</style>
</head>
<body>
	<? echo parseData($jsonData, $searchTerm);?>
</body>
</html>
