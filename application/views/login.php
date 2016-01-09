<? $this->load->view('includes/header'); ?>
<? $this->load->view('includes/nli_navbar'); ?>
 
<div class="container">
    

 

      <div class="google-map-canvas" id="map-canvas">-</div>


  <? if (isset($error)): ?>

      <div class="alert alert-error">
        <strong>Login</strong> fallito!.
      </div>
  
 <? endif; ?>

 
</div>
    
<script src="<?=base_url('js/jquery-1.9.1.js'); ?>"></script>
<script>
$(document).ready(function() {
  $('.content').fadeIn(1000);
});
</script>
<? $this->load->view('includes/footer'); ?>
