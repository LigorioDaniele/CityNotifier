<? $this->load->view('includes/header'); ?>
<? $this->load->view('includes/navbar'); ?>
<div class="container">
    <div class="content" style="display:none">
        <div class="page-header">
            <h2>Segnala</h2>
        </div>
        <div class="row">
            <div class="span4">
               <div id="formricerca" style="display: none">
<form>
<select id="ricercatipo2" onChange="selectTypes(this.options[this.selectedIndex].value)">
<option value="e">Seleziona il tipo:</option>
<option value="1">Emergenze Sanitarie</option>
<option value="2">Problemi stradali</option>
<option value="3">Reati</option>
<option value="4">Problemi ambientali</option>
<option value="5">Eventi pubblici</option>
</select>

<select id="subsegnalazione">
<option value="e">Seleziona il sottotipo:</option>
</select>
    <form>
        <select id="raggio">
            <option value="all">all</option>
            <option value="">Emergenze Sanitarie</option>
            <option value="2">Problemi stradali</option>
            <option value="3">Reati</option>
        </select>
    </form>
Descrizione: <input type="text" id="descrizione">
<p> <input type="button" value="invia I dati" onClick="inseriscisegnalazione(segnalazione.value, subsegnalazione.value, descrizione.value)"> </p>
</form>


</div>

                <form  class="well" accept-charset="utf-8" >
                    <div class="control-group">  
                        <label class="control-label" for="typegroups">Contesto e tipo di segnalazione</label>  
                        <div class="controls">  
                            <select id="typegroups" onchange="selectTypes(this.options[this.selectedIndex].value)">
                                <option value="" selected="selected">Seleziona un Problema:</option>
                                <option value="1">Emergenze Sanitarie</option>
                                <option value="2">Problemi Stradali</option>
                                <option value="3">Reati</option>
                                <option value="4">Problemi Ambientali</option>
                                <option value="5">Eventi Publici</option>
                            </select>


                            <select id="subtype"></select>
                        </div>
                
         
       <div class="input-group">
       
          
      <span class="input-group-btn">
          <button class="btn btn-default" onclick="getLat()" type="button">Go!</button>
      </span>
      <input type="text" id="posizione" class="form-control" onClick="inseriscisegnalazione(segnalazione.value, subsegnalazione.value, descrizione.value)">
    
                        <label class="control-label" for="commenti">Commenti</label>  
                        <textarea id="commenti" class="form-control " rows="3"></textarea>
                        </div>
                        <input type="text" name="name" class="input-block-level" value="Name" placeholder="Name" required maxlength="40" autofocus />
                        <input type="email" name="email" class="input-block-level" placeholder="Email" required maxlength="40" />
                        <input type="text" name="phone" class="input-block-level" placeholder="Phone" required maxlength="15" />
                        <button type="submit" class="btn btn-success btn-large">
                            <i class="icon-plus icon-white"></i>Invia segnalazione</button>
            </div>
        </div>
        <div id="success" class="row" style="display: none">
            <div class="span4">
                <div id="successMessage" class="alert alert-success"></div>
            </div>
        </div>
        <div id="error" class="row" style="display: none">
            <div class="span4">
                <div id="errorMessage" class="alert alert-error"></div>
            </div>
        </div>

        <div id="map-canvas"></div>
    </div>
</div>
</div>
<script src="<?= base_url('js/jquery-1.9.1.js'); ?>"></script>
<script>
$(document).ready(function() {

    $('#formAdd').submit(function() {

      var form = $(this);
      form.children('button').prop('disabled', true);
      $('#success').hide();
      $('#error').hide();

      var faction = '<?=site_url('site/add'); ?>';
      var fdata = form.serialize();

      $.post(faction, fdata, function(rdata) {
          var json = jQuery.parseJSON(rdata);
          if (json.isSuccessful) {
              $('#successMessage').html(json.message);
              $('#success').show();
          } else {
              $('#errorMessage').html(json.message);
              $('#error').show();
          }

          form.children('button').prop('disabled', false);
          form.children('input[name="name"]').select();
      });

      return false;
    });

    $('#nav-add').addClass('active');

    $('.content').fadeIn(1000);
});
</script>
<? $this->load->view('includes/footer'); ?>
