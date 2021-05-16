<?php
	include '../../includes/_cnx.php';
	$row = $fun->get_one("SELECT * FROM d_fournisseur WHERE id = ".$_POST['id']);
	$raison = $row['raison'];
	if($row["logo"]=="p-250.png"){
		$logo = '../assets/img/img_four/p-250.png';
	}
	else{
		$logo = '../assets/img/img_four/'.$row['logo'];
	}
	$email = $row['email'];
	$tel = $row['tel'];
	echo '
		<br>
		<div class="form-group">
			<label>Nom Ou Raison sociale *</label>
			<input type="text" class="form-control" readonly value="'.$raison.'">
		</div>
		<div class="form-group">
			<label>Email *</label>
			<input type="text" class="form-control" readonly value="'.$email.'">
		</div>
		<div class="form-group">
			<label>Logo</label>
			<div class="custom-file">
			<img src="'.$logo.'" height="100" readonly>
			</div>
		</div>
		<div class="form-group">
			<label>Mobile *</label>
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text">+216</div>
				</div>
				<input type="text" class="form-control phone-number" readonly value="'.$tel.'">
			</div>
		</div>
	';
?>