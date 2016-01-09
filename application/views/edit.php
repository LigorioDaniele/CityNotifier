<? $this->load->view('includes/header'); ?>
<? $this->load->view('includes/navbar'); ?>
<div class="container">
<div class="content" style="display:none">
  <div class="page-header">
    <h2>Segnalazioni</h2>
  </div>
  <div class="row">
    <div class="span9 offset1">
      <table class="table table-striped table-bordered tablesorter" id="tcontacts">
        <thead>
          <tr>
            <th><i class="icon-tags"></i> ID</th>
            <th><i class="icon-tags"></i> Tipo</th>
            <th><i class="icon-tags"></i> Sottotipo</th>
            <th><i class="icon-picture"></i> Luogo</th>
             <th><i class="icon-repeat"></i> N.notifiche</th>
              <th><i class="icon-calendar"></i> Data</th>
               <th><i class="icon-book"></i> Stato</th>
          </tr>
        </thead>
        <tbody>
        <!--<? foreach($contacts as $contact): ?>-->
          <tr>
            <td><?=$contact['Id']; ?></td>
            <td><?=$contact['Tipo']; ?></td>
            <td><?=$contact['Sottoto']; ?></td>
            <td><?=$contact['phone']; ?></td>
          </tr>
          <!--<? endforeach; ?>-->
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="<?=base_url('js/jquery-1.9.1.js'); ?>"></script>
<script src="<?=base_url('js/jquery.tablesorter.js'); ?>"></script>
<script>
$(document).ready(function() {

  $('#tcontacts').tablesorter();

  $('.content').fadeIn(1000);
});
</script>
<? $this->load->view('includes/footer'); ?>
