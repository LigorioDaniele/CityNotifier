<? $this->load->view('includes/header'); ?>
<? $this->load->view('includes/navbar'); ?>

  <div class="google-map-canvas" id="map-canvas">-</div>

<script src="<?=base_url('js/jquery-1.9.1.js'); ?>"></script>
<script src="<?=base_url('js/jquery.tablesorter.js'); ?>"></script>

<script>
$(document).ready(function() {
  $('#teventos').tablesorter();
  $('.content').fadeIn(1000);

          
              
          
});
</script>


<? $this->load->view('includes/footer'); ?>
