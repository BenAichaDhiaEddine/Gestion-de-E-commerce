<?php
$title = 'Livreurs';
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
      <?php

      //if ajout livreur
      if (isset($_POST['save'])) {
        $raison = addslashes($_POST['raison']);
        $email = $_POST['email'];
        if (empty($_FILES['img']['name'])) {
          $img = 'p-250.png';
        } else {
          $img = time() . '__' . $_FILES['img']['name'];
        }
        $tel = $_POST['tel'];
        $date_ajout = date('Y-m-d');
        $id_exist = $fun->get_count('SELECT * FROM d_livreur WHERE email = "' . $email . '"');
        if (!$id_exist) {
          $req = $fun->all_in_one("INSERT INTO `d_livreur`(`raison`, `email`, `logo`, `tel`, `date_ajout`) VALUES ('$raison', '$email', '$img', '$tel', '$date_ajout')");
          if ($req) {
            move_uploaded_file($_FILES['img']['tmp_name'], '../assets/img/img_livreurs/' . $img);
            $msg_cl = 1;
          }
        } else {
          $msg_cl = 2;
        }
      }
      //if update fournisseur
      if (isset($_POST['update-btn'])) {
        $date_ajout = date('Y-m-d');
        if (isset($_POST["raison"]) and (!empty($_POST["raison"]))) {
          $date_ajout = date('Y-m-d');
          $sql = 'UPDATE d_livreur SET raison="'. $_POST['raison']. '",date_ajout = "'.$date_ajout.'"  WHERE id="' . $_POST["update-btn"] . '"';
          $fun->update($sql);
        }
        if (isset($_POST["email"]) and (!empty($_POST["email"]))) {
          $sql = 'UPDATE d_livreur SET email="' . $_POST['email'] . '",date_ajout = "'.$date_ajout.'"  WHERE id="' . $_POST["update-btn"] . '"';
          $fun->update($sql);
        }
        if (isset($_POST["tel"])) {
          $sql = 'UPDATE d_livreur SET tel="' . $_POST['tel'] . '",date_ajout = "'.$date_ajout.'"  WHERE id="' . $_POST["update-btn"] . '"';
          $fun->update($sql);
        }
        if (!empty($_FILES['img']['name'])) {
          $img = time() . '__' . $_FILES['img']['name'];
          $sql = 'UPDATE d_livreur SET logo="' . $_POST['img'] . '",date_ajout = "'.$date_ajout.'"  WHERE id="' . $_POST["update-btn"] . '"';
          $fun->update($sql);
          move_uploaded_file($_FILES['img']['tmp_name'], '../assets/img/img_livreurs/' . $img);
        }
        $msg_update = 1;
      }

      //if supprimer livreur
      if (isset($_POST['supprimer_element'])) {
        $id_c = $fun->get_one('SELECT * FROM d_livreur WHERE id = ' . $_POST['supprimer_element']);
        $req = $fun->all_in_one('DELETE FROM `d_livreur` WHERE id = ' . $_POST['supprimer_element']);
        if ($req) {
          unlink('../assets/img/img_livreurs/' . $id_c['img']);
          $msg_del = 1;
        }
      }
      ?>
      <div class="float-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Ajouter nouveau </button>
      </div>
      <h2 class="section-title"><?= $title; ?></h2>
      <p class="section-lead"> Liste des Livreur </p>
      <div class="row">
        <div class="col-12">
          <div class="card card-info">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th>Nom Ou Raison sociale</th>
                      <th>Logo</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Date</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $d_c = $fun->get_list('SELECT * FROM d_livreur');
                    foreach ($d_c as $ls_c) { ?>
                      <tr>
                        <td><?= $ls_c['raison']; ?></td>
                        <td><img src="../assets/img/img_livreurs/<?= $ls_c['logo']; ?>" class="rounded-circle" width="35"></td>
                        <td><?= $ls_c['email']; ?></td>
                        <td><?= $ls_c['tel']; ?></td>
                        <td><?= date_format(date_create($ls_c['date_ajout']), 'd/m/Y'); ?></td>
                        <td class="text-center">
                          <a href="#" class="btn btn-icon icon-left btn-sm btn-info" title="Modifier" data-toggle="modal" data-target="#updateModal_<?= $ls_c['id']; ?>" onclick="update(<?= $ls_c['id']; ?>)"><i class="fa fa-edit"></i></a>
                          <a href="#" class="btn btn-icon icon-left btn-sm btn-danger" title="Supprimer" data-toggle="modal" data-target="#deleteModal" onclick="supprimer(<?= $ls_c['id']; ?>)"><i class="fa fa-trash"></i></a>
                          <button class="btn btn-icon icon-left btn-sm btn-secondary" onclick="_details_(<?= $ls_c['id']; ?>)" title="Détail"><i class="fa fa-eye"></i></button>
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
<!--modal ajout -->
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
          <label>Nom Ou Raison sociale *</label>
          <input type="text" class="form-control" name="raison" required>
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
$first = $fun->get_one('SELECT id FROM `d_livreur` ORDER BY id ASC LIMIT 1');
$last = $fun->get_one('SELECT id FROM `d_livreur` ORDER BY id DESC LIMIT 1');
for ($i = $first['id']; $i <= $last['id']; $i++) : $user = $fun->get_one('SELECT * FROM d_livreur WHERE id =' . $i); ?>
  <div class="modal fade" id="updateModal_<?php echo $i; ?>">
  <div class="modal-dialog" role="document">
    <form class="modal-content" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Formulaire de modification </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="update">
        <div class="form-group">
          <label>Nom Ou Raison sociale *</label>
          <input type="text" class="form-control" name="raison" value="<?= $user['raison']; ?>">
        </div>
        <div class="form-group">
          <label>Email *</label>
          <input type="text" class="form-control" name="email" value="<?= $user['email']; ?>" >
        </div>
        <div class="form-group">
          <label>Logo (100px x 100px)</label>

            <!-- diplay img -->
            <?php if ($user["logo"] == "p-250.png") {
              $img_user = '../assets/img/img_livreurs/p-250.png';
            } else {
              $img_user = '../assets/img/img_livreurs/' . $user['logo'];
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
            <input type="file" name="img" class="custom-file-input" id="site-logo-update">
            <label class="custom-file-label px-3 py-1">Choose File</label>
          </div>
        </div>
        <div class="form-group">
          <label>Mobile *</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">+216</div>
            </div>
            <input type="text" class="form-control phone-number" name="tel" value="<?= $user['tel']; ?>" >
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
        <h5 class="modal-title">details Fournisseur </h5>
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
          message: 'Fournisseurs à été ajouter avec <strong>succès</strong>',
          type: 'success'
        });
      </script>
    ";
} elseif (isset($msg_cl) and ($msg_cl == 2)) {
  echo "
      <script>
        new Toast({
          message: 'Ce fournisseur existe déjà !!!',
          type: 'warning'
        });
      </script>
    ";
}

if(isset($fun) and ($fun) and ($msg_update==1)){
  echo "
  <script>
    new Toast({
      message: 'Fournisseurs à été modifier avec <strong>succès</strong>',
      type: 'success'
    });
  </script>
";
}
?>
<script>
  function _details_(id) {
    $.ajax({
      url: 'ajax/livreur_detail.php',
      type: 'POST',
      dataType: "html",
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