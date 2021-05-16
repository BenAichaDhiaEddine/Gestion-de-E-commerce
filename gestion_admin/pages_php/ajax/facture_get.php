<?php $id = $_GET['id']+1; ?>
<link href="./assets/dist/css/select2.min.css" rel="stylesheet" />
<hr>
<div class="form-group row">
  <label class="col-sm-1 text-right control-label col-form-label" ><?=$id;?> :</label>
  <div class="col-md-5">
    <input type="text" class="form-control" name="desg_<?=$id;?>" placeholder="Désignation">
  </div>
  <div class="col-md-2">
    <input type="number" class="form-control" name="qte_<?=$id;?>" placeholder="Quantité">
  </div>
  <div class="col-md-2">
    <input type="text" class="form-control" name="prix_<?=$id;?>" placeholder="Prix HT">
  </div>
  <div class="col-md-1" id="add_<?=$id;?>" style="margin: auto;">
    <a style="cursor: pointer;" class="btn btn-info btn-sm text-white" onclick="add(<?=$id;?>)"><i class="fa fa-plus"></i></a>
  </div>
  <div class="col-md-1" id="add_<?=$id;?>" style="margin: auto;">
    <a style="cursor: pointer;" class="btn btn-danger btn-sm text-white" onclick="supp_1(<?=$id-1;?>)"><i class="fa fa-times"></i></a>
  </div>
</div>
<input type="hidden" name="count" value="<?=$id;?>">
<div id="main_<?=$id;?>">
</div>