<?php
	include '../../includes/_cnx.php';
	$row = $fun->get_one("SELECT * FROM d_user WHERE id = ".$_POST['id']);
    $type = $row['type'];
    $nom_prenom=$row["nom_prenom"];
    $email = $row['email'];
	$tel = $row['tel'];
	if($row["img"]=="p-250.png"){
		$img = '../assets/img/img_user/p-250.png';
	}
	else{
		$img = '../assets/img/img_user/'.$row['img'];
	}
	echo '
        <br>
        <div class="form-group">
			<label>Type *</label>
			<input type="text" class="form-control" readonly value="'.$type.'">
		</div>
		<div class="form-group">
			<label>Nom Et Prenom *</label>
			<input type="text" class="form-control" readonly value="'.$nom_prenom.'">
		</div>
		<div class="form-group">
			<label>Email *</label>
			<input type="text" class="form-control" readonly value="'.$email.'">
		</div>
		<div class="form-group">
			<label>Logo</label>
			<div class="custom-file">
			<img src="'.$img.'" height="100" readonly>
			</div>
        </div>
        <br>
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