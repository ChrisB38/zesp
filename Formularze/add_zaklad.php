<?php
	require 'common.php';
	top();
	if(isset($_POST['submitted'])){
		require 'DB.php';
		$DB=dbconnect();
		if($st=$DB->prepare('INSERT INTO Zaklad VALUES(NULL,?)')){
			if($st->execute(array($_POST['nazwa']))){
				echo 'Zakład został pomyślnie wstawiony.<br /><br />';
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu zakładu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
		}
		else{
			echo 'Nastąpił błąd przy dodawaniu zakładu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	else{
?>
<form action="add_zaklad.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="" size="16" maxlength="64" required />
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<?php
	}
	bottom();
?>