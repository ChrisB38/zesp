<?php

require 'common.php';
require 'DB.php';
require_once 'user.class.php';
top();

if ($_POST['send'] == 1) {
    // Zabezpiecz dane z formularza przed kodem HTML i ewentualnymi atakami SQL Injection
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $pass_v = $_POST['pass_v'];

    $errors = ''; // Zmienna przechowująca listę błędów które wystąpiły


    // Sprawdź, czy nie wystąpiły błędy
    if (!$login  || !$pass || !$pass_v  ) $errors .= '- Musisz wypełnić wszystkie pola<br />';
    if ($existsLogin[0] >= 1) $errors .= '- Ten login jest zajęty<br />';
    if ($pass != $pass_v)  $errors .= '- Hasła się nie zgadzają<br />';

    /**
     * Jeśli wystąpiły jakieś błędy, to je pokaż
     */
    if ($errors != '') {
        echo 'Rejestracja nie powiodła się, popraw następujące błędy:<br />'.$errors.'';
    }

    else {

        $pass = password_hash($pass, PASSWORD_DEFAULT);
		
		$DB=dbconnect();
		if($st=$DB->prepare("INSERT INTO Uzytkownicy VALUES(0,?,?)")){
			if($st->execute(array($_POST['login'],$pass))){
				echo 'Użytkownik został pomyślnie wstawiony.<br /><br />';
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
		}
		else{
			echo 'Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
    }
}
?>

<form method="post" action="">
 <label for="login">Login:</label>
 <input type="text" name="login" id="login" /><br />

 <label for="pass">Hasło:</label>
 <input type="password" name="pass" id="pass" /><br />

 <label for="pass_again">Hasło (ponownie):</label>
 <input type="password" name="pass_v" id="pass_again" /><br>


 <input type="hidden" name="send" value="1" />
 <input type="submit" value="Zarejestruj" />
</form>
