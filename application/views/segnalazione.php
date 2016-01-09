<? $this->load->view('includes/header'); ?>
<? $this->load->view('includes/navbar'); ?>


<div class="container">
<div class="content" style="display:none">
    <div class="page-header">
    <h2>Benvenuto</h2>
  </div>
  
  <div class="page-header">
         <div class="google-map-canvas" id="map-canvas">-</div>
    <h2>Segnalazioni</h2>
     <div class="row">
    <div class="span9 offset1">
      <table class="table table-striped table-bordered tablesorter" id="teventi">
        <thead>
          <tr>
            <th><i class="icon-tags"></i> ID</th>
            <th><i class="icon-user"></i> Tipo</th>
            <th><i class="icon-envelope"></i> Sottotipo</th>
            <th><i class="icon-headphones"></i> Inizio</th>
              <th><i class="icon-headphones"></i> Freschezza</th>
                <th><i class="icon-headphones"></i> Stato</th>
                  <th><i class="icon-headphones"></i> Numero di notifiche</th>
          </tr>
        </thead>
        <tbody>
          

        </tbody>
      </table>

    </div>
            
  </div>
  </div>
 
</div>
<script src="<?=base_url('js/jquery-1.9.1.js'); ?>"></script>
<script src="<?=base_url('js/jquery.tablesorter.js'); ?>"></script>

<script>
$(document).ready(function() {

  $('#teventos').tablesorter();

  $('.content').fadeIn(1000);
});
</script>


<? $this->load->view('includes/footer'); ?>
