
<!--modal supprimer --> 
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteModal" class="modal zoomIn">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Confirmer la suppression</h5>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr !!!</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form method="POST">
                    <button class="btn btn-secondary" data-dismiss="modal" name="annuler">Annuler</button>
                    <button class="btn btn-primary" id="btn-sup" type="submit" name="supprimer_element">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function supprimer(id) {
        $("#btn-sup").val(id);
    }
</script>      
      
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; <?=date('Y');?>
        </div>
        <div class="footer-right">
          Made with love for <b>nom ste</b> - version 1.0.0 | Support technique <a href="mailto:contact@dev-itgroup.com">contact@dev-itgroup.com</a>
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="../assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="../node_modules/toast/toast.js"></script>
  <script src="../node_modules/dataTables.min.js"></script>
  <script src="../node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>

  <!-- Template JS File -->
  <script src="../assets/js/scripts.js"></script>
  <script src="../assets/js/custom.js"></script>
  <script src="../node_modules/select2/dist/js/select2.full.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="../assets/js/page/modules-datatables.js"></script>
  <?php 
    if (isset($msg_del) == 1) {
      echo "
        <script>
          new Toast({
            message: 'Suppression effectuée avec <strong>succès</strong>',
            type: 'info'
          });
        </script>
      ";
    }
  ?>
</body>
</html>