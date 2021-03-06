<?php
	session_start();
	require 'user.class.php';
	require 'common.php';
	require 'DB.php';
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['id'])){
			top(array('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css'));
			$DB=dbconnect();
			if($st=$DB->prepare('SELECT * FROM Sprzet WHERE id=?')){
				if($st->execute(array($_POST['id']))){
					$row=$st->fetch(PDO::FETCH_ASSOC);
?>
<form action="view_sprzet.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return check_if_number(document.getElementById('wartosc').value)">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_data_zakupu" value="<?php echo $row['data_zakupu']; ?>" />
	<input type="hidden" name="old_data_uruchom" value="<?php echo $row['data_uruchom']; ?>" />
	<input type="hidden" name="old_wartosc" value="<?php echo $row['wartosc']; ?>" />
	<input type="hidden" name="old_opis" value="<?php echo $row['opis']; ?>" />
	<input type="hidden" name="old_projekt" value="<?php echo $row['projekt']; ?>" />
	<input type="hidden" name="old_laboratorium" value="<?php echo $row['laboratorium']; ?>" />
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="100" maxlength="512" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<?php
		$data_zakupu=explode('-',$row['data_zakupu']);
	?>
	<div>
		<fieldset>
			<legend>Data zakupu</legend>
			<label for="data_zakupu_dzien">Dzień: </label>
			<select name="data_zakupu_dzien" id="data_zakupu_dzien">
				<option value=""<?php if(!isset($data_zakupu[2])) echo ' selected="selected"'; ?>>-</option>
				<?php
					for($i=1;$i<32;++$i){
						echo '<option value="'.$i.'"';
						if(isset($data_zakupu[2])){
							if(intval($data_zakupu[2])===$i) echo ' selected="selected"';
						}
						echo '>'.$i.'</option>';
					}
				?>
			</select>
			<label for="data_zakupu_miesiac"> Miesiąc: </label>
			<select name="data_zakupu_miesiac" id="data_zakupu_miesiac" onchange="day_switch_with_required_year('data_zakupu_dzien','data_zakupu_miesiac','data_zakupu_rok')">
				<option value=""<?php if(!isset($data_zakupu[1])) echo ' selected="selected"'; ?>>-</option>
				<?php
					$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
					for($i=0;$i<12;++$i){
						$val=$i+1;
						echo '<option value="'.$val.'"';
						if(isset($data_zakupu[1])){
							if(intval($data_zakupu[1])===$val) echo ' selected="selected"';
						}
						echo '>'.$months[$i].'</option>';
					}
				?>
			</select>
			<label for="data_zakupu_rok"> Rok<span class="color_red">*</span>: </label>
			<select name="data_zakupu_rok" id="data_zakupu_rok" onchange="day_switch_with_required_year('data_zakupu_dzien','data_zakupu_miesiac','data_zakupu_rok')" required="required">
				<option value="">-</option>
				<?php
					$curdecade=(intval(date('Y'))+1)-(intval(date('Y'))+1)%10;
					echo '<optgroup label="'.$curdecade.' - '.(intval(date('Y'))+1).'">';
					for($i=intval(date('Y'))+1;$i>=1950;--$i){
						if($curdecade!=$i-$i%10){
							$curdecade=$i-$i%10;
							echo '</optgroup><optgroup label="'.$curdecade.' - '.($curdecade+9).'">';
						}
						echo '<option value="'.$i.'"';
						if(intval($data_zakupu[0])===$i) echo ' selected="selected"';
						echo '>'.$i.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>';
					}
					echo '</optgroup>';
				?>
			</select>
		</fieldset>
	</div>
	<?php
		$data_uruchom=explode('-',$row['data_uruchom']);
	?>
	<div>
		<fieldset>
			<legend>Data uruchomienia</legend>
			<label for="data_uruchom_dzien">Dzień: </label>
			<select name="data_uruchom_dzien" id="data_uruchom_dzien">
				<option value=""<?php if(!isset($data_uruchom[2])) echo ' selected="selected"'; ?>>-</option>
				<?php
					for($i=1;$i<32;++$i){
						echo '<option value="'.$i.'"';
						if(isset($data_uruchom[2])){
							if(intval($data_uruchom[2])===$i) echo ' selected="selected"';
						}
						echo '>'.$i.'</option>';
					}
				?>
			</select>
			<label for="data_uruchom_miesiac"> Miesiąc: </label>
			<select name="data_uruchom_miesiac" id="data_uruchom_miesiac" onchange="day_switch_with_optional_year('data_uruchom_dzien','data_uruchom_miesiac','data_uruchom_rok')">
				<option value=""<?php if(!isset($data_uruchom[1])) echo ' selected="selected"'; ?>>-</option>
				<?php
					$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
					for($i=0;$i<12;++$i){
						$val=$i+1;
						echo '<option value="'.$val.'"';
						if(isset($data_uruchom[1])){
							if(intval($data_uruchom[1])===$val) echo ' selected="selected"';
						}
						echo '>'.$months[$i].'</option>';
					}
				?>
			</select>
			<label for="data_uruchom_rok"> Rok: </label>
			<select name="data_uruchom_rok" id="data_uruchom_rok" onchange="day_switch_with_optional_year('data_uruchom_dzien','data_uruchom_miesiac','data_uruchom_rok')">
				<option value=""<?php if($data_uruchom[0]==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					$curdecade=(intval(date('Y'))+1)-(intval(date('Y'))+1)%10;
					echo '<optgroup label="'.$curdecade.' - '.(intval(date('Y'))+1).'">';
					for($i=intval(date('Y'))+1;$i>=1950;--$i){
						if($curdecade!=$i-$i%10){
							$curdecade=$i-$i%10;
							echo '</optgroup><optgroup label="'.$curdecade.' - '.($curdecade+9).'">';
						}
						echo '<option value="'.$i.'"';
						if(intval($data_uruchom[0])===$i) echo ' selected="selected"';
						echo '>'.$i.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>';
					}
					echo '</optgroup>';
				?>
			</select>
		</fieldset>
	</div>
	<div>
		<label for="wartosc">Wartość: </label>
		<input type="number" name="wartosc" id="wartosc" value="<?php echo $row['wartosc']; ?>" min="0" step="1" max="9223372036854775807" maxlength="19" size="19" onchange="check_if_number(this.value)" />gr
		<div id="numerror"></div>
	</div>
	<div>
		<label for="opis">Opis<span class="color_red">*</span>: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required="required"><?php echo $row['opis']; ?></textarea>
		<span id="opis_counter"></span>
	</div>
	<div>
		<label for="projekt">Projekt: </label>
		<select name="projekt" id="projekt">
			<option value=""<?php if($row['projekt']==="") echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Projekt ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.strtoupper($first_letter).'">';
						foreach($rows as $row2){
							if($first_letter!==$row2['nazwa'][0]){
								$first_letter=$row2['nazwa'][0];
								echo '</optgroup><optgroup label="'.strtoupper($first_letter).'">';
							}
							echo '<option value="'.$row2['id'].'"';
							if($row['projekt']===$row2['id']) echo ' selected="selected"';
							echo '>'.$row2['nazwa'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<label for="laboratorium">Laboratorium: </label>
		<select name="laboratorium" id="laboratorium">
			<option value=""<?php if($row['laboratorium']==="") echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Laboratorium ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.strtoupper($first_letter).'">';
						foreach($rows as $row2){
							if($first_letter!==$row2['nazwa'][0]){
								$first_letter=$row2['nazwa'][0];
								echo '</optgroup><optgroup label="'.strtoupper($first_letter).'">';
							}
							echo '<option value="'.$row2['id'].'"';
							if($row['laboratorium']===$row2['id']) echo ' selected="selected"';
							echo '>'.$row2['nazwa'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
					bottom(array('js/day_switch.js','https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js','js/modernizr.js','js/js-webshim/minified/polyfiller.js','js/remaining_char_counter.js','js/sprzet_form.js'));
				}
				else{
					echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
					bottom();
				}
			}
			else{
				echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
				bottom();
			}
		}
		else{
			top();
			echo 'Nie podano sprzętu do edycji.';
			bottom();
		}
	}
	else {
		top();
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
