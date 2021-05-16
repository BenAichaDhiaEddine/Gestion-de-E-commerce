<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">Dev-ITgroup</a>
    </div>
    <ul class="sidebar-menu">

      <li <?php if ($title == 'Utilisateurs') { echo 'class="active"'; } ?>><a class="nav-link" href="utilisateurs"><i class="fa fa-users"></i> <span>Responsable</span></a></li>
      <li <?php if ($title == 'Clients') { echo 'class="active"'; } ?>><a class="nav-link" href="clients"><i class="fa fa-user-circle"></i> <span>Clients</span></a></li>
      <li <?php if ($title == 'Fournisseurs') { echo 'class="active"'; } ?>><a class="nav-link" href="fournisseurs"><i class="fa fa-address-card"></i> <span>Fournisseurs</span></a></li>
      <li <?php if ($title == 'Livreurs') { echo 'class="active"'; } ?>><a class="nav-link" href="livreurs"><i class="fa fa-truck"></i> <span>Livreurs</span></a></li>
      <li class="nav-item dropdown <?php if (($title == 'Factures') OR ($title == 'Devis')) { echo 'active'; } ?>">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-address-book" aria-hidden="true"></i><span>Ventes</span></a>
        <ul class="dropdown-menu">
          <li <?php if ($title == 'Devis') { echo 'class="active"'; } ?>><a class="nav-link" href="devis"><i class="fa fa-list"></i> <span>Devis</span></a></li>
          <li <?php if ($title == 'bc') { echo 'class="active"'; } ?>><a class="nav-link" href="bonDeCommande"><i class="fa fa-list"></i> <span>Bon De Commande</span></a></li>
          <li <?php if ($title == 'bs') { echo 'class="active"'; } ?>><a class="nav-link" href="bonDeSortie"><i class="fa fa-list"></i> <span>Bon De Sortie</span></a></li>
          <li <?php if ($title == 'Factures') { echo 'class="active"'; } ?>><a class="nav-link" href="factures"><i class="fa fa-list-alt  "></i> <span>Factures</span></a></li>
        </ul>
    </ul>
  </aside>
</div>