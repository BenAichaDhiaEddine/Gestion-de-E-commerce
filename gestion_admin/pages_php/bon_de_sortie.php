<?php
$title = 'bs';
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
      //if ajouter bs 
      if (isset($_POST['save'])) {
        $client = addslashes($_POST['client']);
        $adresse = addslashes($_POST['adresse']);
        $tel = $_POST['tel'];
        $mf = $_POST['mf'];
        $date = date('Y-m-d H:i:s');
        $req = $fun->all_in_one("INSERT INTO `d_bs`(`client`, `mf`, `tel`, `adresse`, `date`) VALUES ('$client', '$mf', '$tel', '$adresse', '$date')");
        $id_client = $fun->get_one('SELECT id FROM d_bs ORDER BY id DESC LIMIT 1');
        if (!isset($_POST['count'])) {
          $_POST['count'] = 1;
        }
        for ($i = 1; $i <= $_POST['count']; $i++) {
          $fun->all_in_one('INSERT INTO d_ligne_bs(id_bs, designation, prix, qte) VALUES ("' . $id_client['id'] . '" ,"' . $_POST['desg_' . $i] . '","' . $_POST['prix_' . $i] . '", "' . $_POST['qte_' . $i] . '")');
        }
        if ($req) {
          $msg_cl = 1;
        }
      }

      //if supprimer bs
      if (isset($_POST['supprimer_element'])) {
        $dell = $fun->all_in_one('DELETE FROM d_bs WHERE id = ' . $_POST['supprimer_element']);
        $dell_ligne = $fun->all_in_one('DELETE FROM d_ligne_bs WHERE id_bs = ' . $_POST['supprimer_element']);
        if ($dell and $dell_ligne) {
          $msg_del = 1;
        }
      }
      ?>
      <div class="float-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Ajouter nouveau </button>
      </div>
      <h2 class="section-title"><?= $title; ?></h2>
      <p class="section-lead"> Liste des BS </p>

      <!-- html de tableau -->
      <div class="row">
        <div class="col-12">
          <div class="card card-info">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th> BS N° </th>
                      <th> Client</th>
                      <th> Mobile</th>
                      <th> Adresse</th>
                      <th> Matricule fiscale </th>
                      <th> Date de BS </th>
                      <th class="text-center"> Actions </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $bs = $fun->get_list('SELECT * FROM d_bs');
                    foreach ($bs as $key => $list) { ?>
                      <tr>
                        <td><?= 'D-' . sprintf('%09d', $list['id']); ?></td>
                        <td><?= $list['client']; ?></td>
                        <td><?= $list['tel']; ?></td>
                        <td><?= $list['adresse']; ?></td>
                        <td><?= $list['mf']; ?></td>
                        <td><?= $list['date']; ?></td>
                        <td class="text-center" style="padding: 0.75rem;">
                          <button class="btn btn-sm btn-danger text-white" onclick="supprimer(<?= $list['id']; ?>)" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button>
                          <a class="btn btn-sm btn-primary text-white" target="_blank" href="Imprimer_bs?id=<?= $list['id']; ?>"><i class="fa fa-print"></i> / <i class="fa fa-eye"></i></a>
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
  <div class="modal-dialog modal-lg" role="document">

    <!--formulaire d'ajout -->
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
          <label class="custom-switch mt-2">
            <input type="checkbox" id="show_passager" name="custom-switch-checkbox" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">Passager</span>
          </label>
        </div>

        <!--details client -->
        <div id="show_passager">
          <div class="form-group row">

            <!--show input (if passager )-->
            <div class="col-md-6" id="show_input" style="display: none;">
              <input type="text" class="form-control" name="mf" placeholder="Matricule fiscale">
            </div>

            <!--show select (if not passager ) -->
            <div class="col-md-6" id="show_select">
              <select name="mf" class="form-control select2" style="width: 100%; height: 15px !important">
                <?php
                $d_bs = $fun->get_list('SELECT * FROM d_bs');
                foreach ($d_bs as $ls) {
                ?>
                  <option value="<?= $ls["mf"]; ?>">
                    <?= sprintf('%s', $ls["mf"]); ?>
                  </option>
                <?php
                }
                ?>
                <option disabled="" selected="">-- Veuillez choisir --</option>
              </select>
            </div>




            <div class="col-md-6">
              <input type="text" class="form-control" name="client" required placeholder="Nom & Prénom">
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
        </div>

        <hr style="border: 3px solid #eee">
        <h2 class="section-title">Détail Bon De Commande</h2>

        <!--details bs -->
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

<?php include '_footer.php'; ?>
<?php
if (isset($msg_cl) and ($msg_cl == 1)) {
  echo "
      <script>
        new Toast({
          message: 'Bon De Commande à été créé avec <strong>succès</strong>',
          type: 'success'
        });
      </script>
    ";
}
?>

<!-- details bs add supp   -->
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

<!-- details client passager  -->
<script type="text/javascript">
  $(document).ready(function() {
    $('#show_passager').change(function() {
      if (this.checked) {
        $('#show_input').show();
        $('#show_select').hide();
      } else {
        $('#show_select').show();
        $('#show_input').hide();
      }
    });
  });
</script>