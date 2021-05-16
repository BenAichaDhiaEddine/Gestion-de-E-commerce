<?php
$title = 'Factures';
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
      //if ajout nouveau facture
      if (isset($_POST['save'])) {
        $client = addslashes($_POST['client']);
        $adresse = addslashes($_POST['adresse']);
        $tel = $_POST['tel'];
        $mf = $_POST['mf'];
        $date = date('Y-m-d H:i:s');
        $req = $fun->all_in_one("INSERT INTO `d_facture`(`client`, `mf`, `tel`, `adresse`, `date`) VALUES ('$client', '$mf', '$tel', '$adresse', '$date')");
        $id_facture = $fun->get_one('SELECT id FROM d_facture ORDER BY id DESC LIMIT 1');
        if (!isset($_POST['count'])) {
          $_POST['count'] = 1;
        }
        for ($i = 1; $i <= $_POST['count']; $i++) {
          $fun->all_in_one("INSERT INTO `d_ligne_facture`(`id_facture`, `designation`, `prix`, `qte`) VALUES ('" . $id_facture['id'] . "', '" . $_POST['desg_' . $i] . "', '" . $_POST['prix_' . $i] . "', '" . $_POST['qte_' . $i] . "')");
        }
        if ($req) {
          $msg_cl = 1;
        }
      }

      //if importer devis 
      if(isset($_POST['importer'])){
        for ($i=0; $i < count($_POST["id_devis"]); $i++) { 
        $devis=$fun->get_one('SELECT * FROM d_devis WHERE id= "'.$_POST["id_devis"][$i].'"');
        $date = date('Y-m-d');
        $req=$fun->all_in_one("INSERT INTO d_facture (`client`,`mf`,`tel`,`adresse`,`date`) VALUES ('".$devis['client']. "', '" .$devis['mf']. "', '".$devis['tel']. "', '".$devis['adresse']. "','".$date."')");
        $ligne_devis=$fun->get_list('SELECT * FROM d_ligne_devis WHERE id_devis = "'.$_POST["id_devis"][$i].'"');
        $count=$fun->get_count('SELECT * FROM d_ligne_devis WHERE id_devis = "'.$_POST["id_devis"][$i].'"');
        $id_facture=$fun->get_one('SELECT id FROM d_facture ORDER BY id DESC LIMIT 1');
        foreach($ligne_devis as $list) {
          $fun->all_in_one("INSERT INTO `d_ligne_facture`(`id_facture`, `designation`, `prix`, `qte`) VALUES ('" . $id_facture['id'] . "', '" . $list['designation'] . "', '" . $list['prix'] . "', '" . $list['qte'] . "')");
        }
        
        if ($req) {
          $msg_cl = 1;
        }
      }

      }

      //if supprimer facture
      if (isset($_POST['supprimer_element'])) {
        $dell = $fun->all_in_one('DELETE FROM d_facture WHERE id = ' . $_POST['supprimer_element']);
        $dell_ligne = $fun->all_in_one('DELETE FROM d_ligne_facture WHERE id_facture = ' . $_POST['supprimer_element']);
        if ($dell and $dell_ligne) {
          $msg_del = 1;
        }
      }
      ?>
      <div class="float-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Ajouter nouveau </button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#devisModal"><i class="fa fa-upload"></i> Importer devis </button>
      </div>
      <h2 class="section-title"><?= $title; ?></h2>
      <p class="section-lead"> Liste des facture </p>
      <div class="row">
        <div class="col-12">
          <div class="card card-info">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th> Facture N° </th>
                      <th> Client</th>
                      <th> Mobile</th>
                      <th> Adresse</th>
                      <th> Matricule fiscale </th>
                      <th> Date de facture </th>
                      <th class="text-center"> Actions </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $facture = $fun->get_list('SELECT * FROM d_facture');
                    foreach ($facture as $key => $list) { ?>
                      <tr>
                        <td><?= 'F-' . sprintf('%09d', $list['id']); ?></td>
                        <td><?= $list['client']; ?></td>
                        <td><?= $list['tel']; ?></td>
                        <td><?= $list['adresse']; ?></td>
                        <td><?= $list['mf']; ?></td>
                        <td><?= $list['date']; ?></td>
                        <td class="text-center" style="padding: 0.75rem;">
                          <button class="btn btn-sm btn-danger text-white" onclick="supprimer(<?= $list['id']; ?>)" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button>
                          <a class="btn btn-sm btn-primary text-white" target="_blank" href="Imprimer_facture?id=<?= $list['id']; ?>"><i class="fa fa-print"></i> / <i class="fa fa-eye"></i></a>
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

<!--modal importer devis -->
<div class="modal fade" id="devisModal">
  <div class="modal-dialog modal-lg" role="document">
    <form class="modal-content" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Formulaire d'ajout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body section">
        <h2 class="section-title">Liste des devis</h2>
        <div class="form-group row">
          <div class="col-md-12">
            <select class="form-control select2" multiple style="width: 100%" name="id_devis[]">
              <?php $d_devis = $fun->get_list('SELECT * FROM d_devis');
              foreach ($d_devis as $ls) { ?>
                <option value="<?= $ls['id']; ?>"><?= 'D-' . sprintf('%09d', $ls['id']); ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="submit" name="importer" class="btn btn-primary">Valider</button>
      </div>
    </form>
  </div>
</div>

<!--modal ajout facture -->
<div class="modal fade" id="exampleModal">
  <div class="modal-dialog modal-lg" role="document">
    <form class="modal-content" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Formulaire d'ajout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body section">
        <h2 class="section-title">Détail client</h2>
        <div class="form-group row">
          <div class="col-md-6">
            <input type="text" class="form-control" name="client" required placeholder="Nom & Prénom">
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" name="mf" required placeholder="Matricule fiscale">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
            <input type="text" class="form-control" name="tel" required placeholder="Mobile">
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" name="adresse" required placeholder="Adresse">
          </div>
        </div>
        <hr style="border: 3px solid #eee">
        <h2 class="section-title">Détail facture</h2>
        <div class="form-group row">
          <label class="col-sm-1 text-right control-label col-form-label">1 :</label>
          <div class="col-md-5">
            <input type="text" class="form-control" name="desg_1" placeholder="Désignation">
          </div>
          <div class="col-md-2">
            <input type="number" class="form-control" name="qte_1" placeholder="Quantité">
          </div>
          <div class="col-md-2">
            <input type="number" class="form-control" name="prix_1" placeholder="Prix HT">
          </div>
          <div class="col-md-1" id="add_1" style="margin: auto;">
            <a style="cursor: pointer;" class="btn btn-info btn-sm text-white" onclick="add(1)"><i class="fa fa-plus"></i></a>
          </div>
          <input type="hidden" name="count" value="1">
        </div>
        <div id="main_1"></div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="submit" name="save" class="btn btn-primary">Valider</button>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="empModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Deatil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<?php include '_footer.php'; ?>
<?php
if (isset($msg_cl) and ($msg_cl == 1)) {
  echo "
      <script>
        new Toast({
          message: 'Facture à été créé avec <strong>succès</strong>',
          type: 'success'
        });
      </script>
    ";
}
?>
<script>
  function _deatil_(id) {
    $.ajax({
      url: 'ajax/facture_detail.php',
      type: 'post',
      data: {
        id: id
      },
      success: function(response) {
        $('.modal-body').html(response);
        $('#empModal').modal('show');
      }
    });
  }
</script>
<script type="text/javascript">
  function add(i) {
    $('#main_' + i).load("ajax/facture_get.php?id=" + i);
    document.getElementById('add_' + i).style.display = "none";
    document.getElementById('main_' + i).style.display = "block";
  }
</script>
<script type="text/javascript">
  function supp_1(i) {
    document.getElementById('add_' + i).style.display = "block";
    document.getElementById('main_' + i).style.display = "none";
  }
</script>