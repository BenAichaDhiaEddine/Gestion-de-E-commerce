<?php
$title = 'Utilisateurs';
include '_head.php';
include '_aside.php';
?>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?= $title; ?></h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="accueil">Tableau de bord</a></div>
        <div class="breadcrumb-item"><?= $title; ?></div>
      </div>
    </div>

    <div class="section-body">
      <!--if ajouter nouveau -->
      <?php

      if (isset($_POST['save'])) {
        $nom_prenom = addslashes($_POST['nom_prenom']);
        $password = addslashes($_POST['password']);
        $email = $_POST['email'];
        $type = $_POST['type'];
        if (empty($_FILES['img']['name'])) {
          $img = 'p-250.png';
        } else {
          $img = time() . '__' . $_FILES['img']['name'];
        }
        $tel = $_POST['tel'];
        $date_ajout = date('Y-m-d');
        $id_exist = $fun->get_count('SELECT * FROM d_user WHERE email = "' . $email . '"');
        if ($id_exist == 0) {
          $req = $fun->all_in_one("INSERT INTO `d_user`(`type`, `nom_prenom`, `email`, `tel`, `img`, `password`, `date_ajout`) VALUES ('$type', '$nom_prenom', '$email', '$tel', '$img', '$password', '$date_ajout')");
          if ($req) {
            if (!empty($_FILES['img']['name'])) {
              move_uploaded_file($_FILES['img']['tmp_name'], '../assets/img/img_user/' . $img);
            }
            $msg_cl = 1;
          }
        } else {
          $msg_cl = 2;
        }
      }


      //if update user
      if (isset($_POST['update-btn'])) {
        $date_ajout = date('Y-m-d');
        if (isset($_POST["type"]) and (!empty($_POST["type"]))) {
          $sql = 'UPDATE d_user SET type="' . $_POST['type'] . '",date_ajout = "' . $date_ajout . '"  WHERE id="' . $_POST["update-btn"] . '"';
          $fun->update($sql);
        }
        if (isset($_POST["nom_prenom"]) and (!empty($_POST["nom_prenom"]))) {
          $sql = 'UPDATE d_user SET nom_prenom="' . $_POST['nom_prenom'] . '",date_ajout = "' . $date_ajout . '"  WHERE id="' . $_POST["update-btn"] . '"';
          $fun->update($sql);
        }
        if (isset($_POST["email"]) and (!empty($_POST["email"]))) {
          $sql = 'UPDATE d_user SET email="' . $_POST['email'] . '",date_ajout = "' . $date_ajout . '"  WHERE id="' . $_POST["update-btn"] . '"';
          $fun->update($sql);
        }
        if (isset($_POST["tel"]) and (!empty($_POST["tel"]))) {
          $sql = 'UPDATE d_user SET tel="' . $_POST['tel'] . '",date_ajout = "' . $date_ajout . '"  WHERE id="' . $_POST["update-btn"] . '"';
          $fun->update($sql);
        }
        if (isset($_POST["password"]) and (!empty($_POST["password"]))) {
          $sql = 'UPDATE d_user SET password ="' . $_POST['password'] . '"' . '",date_ajout = "' . $date_ajout . '"  WHERE id="' . $_POST["update-btn"] . '"';
          $fun->update($sql);
        }
        if (!empty($_FILES['img']['name'])) {
          $img = time() . '__' . $_FILES['img']['name'];
          $sql = 'UPDATE d_user SET img="' . $_POST['img'] . '"' . '",date_ajout = "' . $date_ajout . '"  WHERE id="' . $_POST["update-btn"] . '"';
          $fun->update($sql);
          move_uploaded_file($_FILES['img']['tmp_name'], '../assets/img/img_user/' . $img);
        }
        $msg_update = 1;
      }

      // if supprimer user
      if (isset($_POST['supprimer_element'])) {
        $id_c = $fun->get_one('SELECT * FROM d_user WHERE id = ' . $_POST['supprimer_element']);
        $req = $fun->all_in_one('DELETE FROM `d_user` WHERE id = ' . $_POST['supprimer_element']);
        if ($req) {
          if ($id_c['img'] != 'avatar.png') {
            unlink('../assets/img/img_user/' . $id_c['img']);
          }
          $msg_del = 1;
        }
      }
      ?>

      <!-- html tableau -->
      <div class="float-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Ajouter nouveau </button>
      </div>
      <h2 class="section-title"><?= $title; ?></h2>
      <p class="section-lead"> Liste des Utilisateurs </p>
      <div class="row">
        <div class="col-12">
          <div class="card card-info">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th>Type</th>
                      <th>Nom & Prénom</th>
                      <th>Image</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Date</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $d_c = $fun->get_list('SELECT * FROM d_user');
                    foreach ($d_c as $ls_c) { ?>
                      <tr>
                        <td><?= $ls_c['type']; ?></td>
                        <td><?= $ls_c['nom_prenom']; ?></td>
                        <td><img src="../assets/img/img_user/<?= $ls_c['img']; ?>" class="rounded-circle" width="35"></td>
                        <td><?= $ls_c['email']; ?></td>
                        <td><?= $ls_c['tel']; ?></td>
                        <td><?= date_format(date_create($ls_c['date_ajout']), 'd/m/Y'); ?></td>
                        <td class="text-center">
                          <a href="#" class="btn btn-icon icon-left btn-sm btn-info" title="Modifier" data-toggle="modal" data-target="#updateModal_<?= $ls_c['id']; ?>" onclick="update(<?= $ls_c['id']; ?>)"><i class="fa fa-edit"></i></a>
                          <a href="#" class="btn btn-icon icon-left btn-sm btn-danger" title="Supprimer" data-toggle="modal" data-target="#deleteModal" onclick="supprimer(<?= $ls_c['id']; ?>)"><i class="fa fa-trash"></i></a>
                          <button class="btn btn-icon icon-left btn-sm btn-secondary" title="Détails" onclick="_details_(<?= $ls_c['id']; ?>)"><i class="fa fa-eye"></i></button>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- modal ajout  -->
<div class="modal fade" id="exampleModal">
  <div class="modal-dialog" role="document">
    <form class="modal-content" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Formulaire d'ajout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Type *</label>
          <div class="selectgroup selectgroup-pills w-100">
            <label class="selectgroup-item">
              <input type="radio" name="type" value="Admin" class="selectgroup-input" checked="">
              <span class="selectgroup-button">Admin</span>
            </label>
            <label class="selectgroup-item">
              <input type="radio" name="type" value="User" class="selectgroup-input">
              <span class="selectgroup-button">User</span>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label>Nom & Prénom *</label>
          <input type="text" class="form-control" name="nom_prenom" required>
        </div>
        <div class="form-group">
          <label>Email *</label>
          <input type="text" class="form-control" name="email" required>
        </div>
        <div class="form-group">
          <label>Logo (100px x 100px)</label>
          <div class="custom-file">
            <style type="text/css">
              .custom-file-label:after {
                height: auto;
                line-height: initial;
              }
            </style>
            <input type="file" name="img" class="custom-file-input" id="site-logo">
            <label class="custom-file-label px-3 py-1">Choose File</label>
          </div>
        </div>
        <div class="form-group">
          <label>Mobile *</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">+216</div>
            </div>
            <input type="text" class="form-control phone-number" name="tel" required>
          </div>
        </div>
        <div class="form-group">
          <label>Mot de passe *</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fa fa-key"></i></div>
            </div>
            <input type="password" class="form-control" name="password" required>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="submit" name="save" class="btn btn-primary">Valider</button>
      </div>
    </form>
  </div>
</div>

<!--modal UPDATE -->
<?php
$first = $fun->get_one('SELECT id FROM `d_user` ORDER BY id ASC LIMIT 1');
$last = $fun->get_one('SELECT id FROM `d_user` ORDER BY id DESC LIMIT 1');
for ($i = $first['id']; $i <= $last['id']; $i++) : $user = $fun->get_one('SELECT * FROM d_user WHERE id =' . $i); ?>
  <div class="modal fade" id="updateModal_<?php echo $i; ?>">

    <div class="modal-dialog" role="document">
      <form class="modal-content" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Formulaire de Modification </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="update">
          <div class="form-group">
            <label>Type *</label>
            <div class="selectgroup selectgroup-pills w-100">
              <label class="selectgroup-item">
                <input type="radio" name="type" class="selectgroup-input" <?php if ($user["type"] == "Admin") {
                                                                            echo "Checked";
                                                                          } ?>>
                <span class="selectgroup-button">Admin</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="type" value="User" class="selectgroup-input" <?php if ($user["type"] == "User") {
                                                                                          echo "Checked";
                                                                                        } ?>>
                <span class="selectgroup-button">User</span>
              </label>
            </div>
          </div>
          <div class="form-group">
            <label>Nom & Prénom *</label>
            <input type="text" class="form-control" value="<?= $user['nom_prenom']; ?>" name="nom_prenom">
          </div>
          <div class="form-group">
            <label>Email *</label>
            <input type="text" class="form-control" value="<?= $user['email']; ?>" name="email">
          </div>
          <div class="form-group">
            <label>Logo (100px x 100px)</label>

            <!-- diplay img -->
            <?php if ($user["img"] == "p-250.png") {
              $img_user = '../assets/img/img_user/p-250.png';
            } else {
              $img_user = '../assets/img/img_user/' . $user['img'];
            }
            ?>
            <br>
            <?php echo "<img src=\"$img_user\" height=\"100\" width=\"100\" style= \"  margin-bottom: 20px;; \"/> <br> " ?>

            <div class="custom-file">
              <style type="text/css">
                .custom-file-label:after {
                  height: auto;
                  line-height: initial;
                }
              </style>
              <br>
              <input type="file" name="img" class="custom-file-input" id="site-logo">
              <label class="custom-file-label px-3 py-1">Choose File</label>
            </div>
          </div>
          <div class="form-group">
            <label>Mobile *</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">+216</div>
              </div>
              <input type="text" class="form-control phone-number" value="<?= $user['tel']; ?>" name="tel">
            </div>
          </div>
          <div class="form-group">
            <label>Mot de passe *</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-key"></i></div>
              </div>
              <input type="password" class="form-control" name="password">
            </div>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          <button type="submit" name="update-btn" id="update-btn" class="btn btn-primary">Valider</button>
        </div>
      </form>
    </div>
  </div>
<?php endfor; ?>

<!-- modal details -->
<div class="modal fade" id="empModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Details Responsable </h5>
      </div>
      <div class="modal-body" id="empModal">

      </div>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</div>

<?php include '_footer.php'; ?>
<?php
if (isset($msg_cl) and ($msg_cl == 1)) {
  echo "
      <script>
        new Toast({
          message: 'Utilisateurs à été ajouter avec <strong>succès</strong>',
          type: 'success'
        });
      </script>
    ";
} elseif (isset($msg_cl) and ($msg_cl == 2)) {
  echo "
      <script>
        new Toast({
          message: 'Cet utilisateur existe déjà !!!',
          type: 'warning'
        });
      </script>
    ";
}

if (isset($fun) and ($fun) and ($msg_update == 1)) {
  echo "
      <script>
        new Toast({
          message: 'Responsable a été modifier avec <strong>succès</strong>',
          type: 'success'
        });
      </script>
    ";
}
?>

<script>
  function _details_(id) {
    $.ajax({
      url: 'ajax/user_detail.php',
      type: 'post',
      data: {
        id: id
      },
      success: function(response) {
        $('.modal-body#empModal').html(response);
        $('#empModal').modal('show');
      }
    });
  }

  function update(id) {
    $("#update-btn").val(id);
  }
</script>