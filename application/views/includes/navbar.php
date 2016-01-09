
<div class="navbar navbar-margin">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?= site_url('site') ?>"><img src="<?= base_url('css/img/eteam.png'); ?>"></a>
             <ul class="nav pull-right" >
                <li class="divider-vertical"></li>
            
                 <li class="dropdown"><a class="dropdown-toggle" href="#myModal" onclick="ricercaTabella()" data-toggle="modal">Tabella<strong class="caret"></strong></a></li> 
        
         <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3 id="myModalLabel">Eventi</h3>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered tablesorter"  id="tcontacts">
                    <thead>
                        <tr>
                            <th> ID</th>
                            <th> Tipo</th>
                            <th> Sottotipo</th>
                            <th> Data</th>
                            <th>Stato</th> 
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
               
            </div>
        </div>

        <!--sezione di Ricerca-->      
        <li class="dropdown"><a class="dropdown-toggle" onclick="decod()"id="bar_search" href="./landing.html" title="Cerca Evento" data-toggle="dropdown">Cerca <strong class="caret"></strong></a>
            <div id="sign_drop" class="dropdown-menu">
                <form  class="well">
                    <div class="controls">  
                        <select id="ceType" onchange="selectTypes(this.options[this.selectedIndex].value)">

                            <option value="0">all</option>
                            <option value="1">Emergenze Sanitarie</option>
                            <option value="2">Problemi Stradali</option>
                            <option value="3">Problemi Ambientali</option>
                            <option value="4">Reati</option>
                            <option value="5">Eventi Publici</option>
                        </select>
                        <select id="ceSub"> </select>
                    </div>
                    <div class="input-group">
                        <div>Data:<input id="ceData" type="text" class="form-control"></div>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="showData()">calcola intervallo 24ore </button>
                        </span>
                        <div>Raggio in metri:<input id="ceRaggio" type="text"  value="200"  class="form-control" ></div>
                        <div>Indirizzo:<input id="ceAddress" type="text"  class="form-control" onChange="getCordinateRichieste()"></div>

                        </span>
                        <div>Latitudine:<input class="lat" id="ceLat" type="text" name="lat" size="9" disabled readonly></div>
                        <div>Longitudine: <input class="lon" id="ceLon" type="text" name="lon" size="9" disabled readonly></div>
                        <div>
                        </div>
                        Stato:</div><div>
                        <select id="ceStato" autocomplete="off">	                  
                            <option value="1" selected="" >Open</option>
                            <option value="2">closed</option>
                            <option value="3">skeptical</option>	                    
                        </select>
                    </div>	                                                 
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="richiesta()">Cerca </button>
                    </span>
                </form>
             </div>
        </li>
                  
                  
                  
          <!--Notifica-->

                  <li class="dropdown"><a class="dropdown-toggle" id="bar_sign"onclick="decodSegnalazione()" href="./landing.html" title="Segnala un Evento" data-toggle="dropdown">Segnala <strong class="caret"></strong></a>
                   <div id="sign_drop" class="dropdown-menu">
                       <div id="form_message"></div>
      <form  class="well" >
                   
                       
                       
          <select id="noType"  onchange="selectTypes1(this.options[this.selectedIndex].value)">
                                <option value="0" selected="selected">Seleziona un Problema:</option>
                                <option value="1">Emergenze Sanitarie</option>
                                <option value="2">Problemi Stradali</option>
                                <option value="3">Problemi Ambientali</option>
                                <option value="4">Reati</option>
                                <option value="5">Eventi Publici</option>
                            </select>
                             <select id="noSub"></select>
                  
                 <div>Latitudine:<input class="latLngInput" id="noLat" type="text" name="latitudine" size="9" disabled readonly></input></div>
          	        <div>Longitudine: <input class="latLngInput" id="noLon" type="text" name="longitudine" size="9" disabled readonly></input></div>
<div>Indirizzo:<input id="indirizzo" type="text"  class="form-control" onblur="getCordinateSegnalazione()"></div>
  <div>Via: <input class="latLngInput" id="via" type="text" name="via" size="9" disabled readonly></input></div>
                            <label class="control-label" for="descrizione">Descrizione</label>  
                        <textarea id="noDes" class="form-control " rows="3"></textarea>
                       
         <button class="btn btn-default" type="button" onclick="inviaNotifica()">Segnala! </button>
                </form>
                    </div>
                  </li>
            
             
      <div class="pull-right">
        <small id="utenteLabel" class="navbar-text  ">User: <?=anchor('site/profile', $this->session->userdata('Username')); ?> </small>
        <a href="<?=site_url('login/logout'); ?>" class="btn btn-primary"><i class="icon-road icon-white"></i> Logout</a>
      </div>
                  
                </ul>

              </div>
            </div>
          </div>
        </div>
 