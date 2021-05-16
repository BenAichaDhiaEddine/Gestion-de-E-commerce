<?php
  $title = 'Imprimer bc';
  include '../includes/_cnx.php';
  $bc = $fun->get_one('SELECT * FROM d_bc WHERE id = '.$_GET['id']);
?>
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>dev-itgroup || <?=$title?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../node_modules/toast/toast.css">
  <link rel="stylesheet" href="../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="../node_modules/select2/dist/css/select2.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
  <style type="text/css">
    .select2-container--default .select2-results__option[aria-disabled=true] { display: none; }
  </style>
</head>

<style type="text/css">
  @media print {
    body * {
      visibility: hidden;
    }
    #section-to-print, #section-to-print * {
      visibility: visible;
    }
    .navbar-vertical.navbar-expand-md.fixed-left+.main-content{
      margin: 0!important;
    }
    #section-to-print {
      z-index: 99999999;
      position: absolute;
      left: 0;
      width: 100%;
    }
  }
  td {
    font-size: 15px !important;
    color: #000 !important;
  }
  th {
    font-size: 15px !important;
    color: #000 !important;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="document-container p-3" id="section-to-print">
          <div class="row">
            <div class="col-md-6">
              <h4>Dev-ITgroup</h4>
              <b>Tél</b> : (+216) 36 317 512<br>
              <b>Adresse</b> : Immeuble yasmine mahjoub, sousse 4001, Tunisie<br>
              <b>E-mail</b> : contact@dev-itgroup.com<br>
              <b>MF</b> : 111111/Z/Z/Z/000<br>
            </div>
            <div class="col-md-6 text-right m-auto">
              <h1>LOGO Sté</h1>
              <!-- <img src="assets/img/print.jpg" width="150"> -->
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-md-4 offset-8">
              <b>Client</b> : <?=$bc['client'];?><br>
              <b>Mobile</b> : <?=$bc['tel'];?><br>
              <b>Adresse</b> : <?=$bc['adresse'];?><br>
              <b>MF</b> : <?=$bc['mf'];?><br>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12 text-right">
              <h5>Sousse, le <?=date_format(date_create($bc['date']),"d/m/Y");?></h5><br>
            </div>
            <div class="col-md-12">
              <h3> BC N°: <?='D-'.sprintf('%06d', $bc['id']);?></h3>
            </div>
          </div>

          <div class="document-table mt-4">
            <table class="table table-bordered" width="100%">
              <thead>
                <tr>
                  <th style="font-size: 15px; font-weight: bold;">DÉSIGNATION</th>
                  <th class="text-center" style="font-size: 15px; font-weight: bold;">QUANTITÉ</th>
                  <th class="text-center" style="font-size: 15px; font-weight: bold;">PU HT</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $t = 0;
                  $ligne = $fun->get_list('SELECT * FROM d_ligne_bc WHERE id_bc = '.$_GET['id']);
                  foreach ($ligne as $key => $ls) {
                    $t += $ls['qte']*$ls['prix'];
                ?>
                  <tr>
                    <td><?=$ls['designation'];?></td>
                    <td class="text-center"><?=$ls['qte'];?></td>
                    <td class="text-center"><?=$ls['prix'];?></td>
                  </tr>
                <?php } ?>
                <tr style="border-top: 3px solid #eee">
                  <td colspan="2" class="text-right">Total</td>
                  <td class="text-center"><?=sprintf('%.3f', $t);?></td>
                </tr>
                <tr>
                  <td colspan="2" class="text-right">TVA 19%</td>
                  <td class="text-center"><?=sprintf('%.3f', ($t*19)/100);?></td>
                </tr>
                <tr>
                  <td colspan="2" class="text-right">Timbre fiscale</td>
                  <td class="text-center">0.600</td>
                </tr>
                <tr>
                  <td style="font-size: 17px;" colspan="2" class="text-right font-weight-bold">TTC</td>
                  <td style="font-size: 17px;" class="font-weight-bold text-center bg-light"><?=sprintf('%.3f', $t+(($t*19)/100)+0.6);?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-right">
            <b>(Ctrl + p) Ou </b><button class="btn btn-primary" onClick="window.print()"> <i class="fa fa-print"></i> Imprimer</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
