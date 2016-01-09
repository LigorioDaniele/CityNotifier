<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    public function getEventi($type, $subtype, $lat, $lng, $radius, $tmin, $tmax, $status) {
        if ($type != "all" and $subtype = "all") {
            $eventi = $this->db->query("SELECT Id,Type,Subtype,Lat,Lng,StartTime,Freshness,Status,Nnotifications FROM Evento WHERE (StartTime BETWEEN $tmin AND $tmax) AND TRUNCATE ( 6363 * sqrt( POW( RADIANS('" . $lat . "') - RADIANS(Lat) , 2 ) + POW( RADIANS('" . $lng . "') - RADIANS(Lng) , 2 ) ) , 3 ) < $radius AND Type='$type' AND Status='$status'");
        } else if ($type != "all" and $subtype != "all") {
            $eventi = $this->db->query("SELECT Id,Type,Subtype,Lat,Lng,StartTime,Freshness,Status,Nnotifications FROM Evento WHERE (StartTime BETWEEN $tmin AND $tmax) AND TRUNCATE ( 6363 * sqrt( POW( RADIANS('" . $lat . "') - RADIANS(Lat) , 2 ) + POW( RADIANS('" . $lng . "') - RADIANS(Lng) , 2 ) ) , 3 ) < $radius AND Type='$type'AND Subtype='$subtype'AND Status='$status'");
        } else if ($type == "all") {
            $eventi = $this->db->query("SELECT Id,Type,Subtype,Lat,Lng,StartTime,Freshness,Status,Nnotifications FROM Evento WHERE (StartTime BETWEEN $tmin AND $tmax) AND TRUNCATE ( 6363 * sqrt( POW( RADIANS('" . $lat . "') - RADIANS(Lat) , 2 ) + POW( RADIANS('" . $lng . "') - RADIANS(Lng) , 2 ) ) , 3 ) < $radius AND Status='$status'");
        } if ($eventi->num_rows() > 0) {
            foreach ($eventi->result_array() as $row) {
                $id = $row['Id'];
                $type = $row['Type'];
                $subtype = $row['Subtype'];
                $Lat = $row['Lat'];
                $Lng = $row['Lng'];
                $start_time = $row['StartTime'];
                $freshness = $row['Freshness'];
                $status = $row['Status'];
                $Nnotifications = $row['Nnotifications'];
                $locations[] = array("lat" => floatval($Lat), "lng" => floatval($Lng));
                $descriptionQuery = $this->db->query("SELECT Description FROM Notifica WHERE (Id_Evento = $id)ORDER BY UnixTime DESC LIMIT 5 ");
                if ($descriptionQuery->num_rows() > 0) {
                    foreach ($descriptionQuery->result_array() as $row) {
                         $descriptions[] = array($row['Description']);
                    }
                    //recupero assiduita e credibilita utente per trovare le reliability
                    $utenteQuery = $this->db->query("SELECT Utente.Assiduita,Utente.Credibilita FROM Utente,Notifica WHERE Notifica.Id_Evento=$id AND Utente.Id=Notifica.Id_User");
                    if ($utenteQuery->num_rows() > 0) {
                        foreach ($utenteQuery->result_array() as $row) {
                            $assiduitaUtente = $row['Assiduita'];
                            $credibilitaUtente = $row['Credibilita'];
                            $sum = 0;
                            $sum = $sum + (1 + $assiduitaUtente * $credibilitaUtente);
                        }
                        //Calcolo la reliability
                        $reliability = floatval($sum / (2 * $Nnotifications));
                      
                    }
                } else {
                    $descriptions = "nessuna descrizione";
                }
                $listaEventi[] = array(
                    "event_id" => $id,
                    "type" => array("type" => $type, "subtype" => $subtype),
                    "description" => $descriptions,
                    "start_time" => $start_time,
                    "freshness" => $freshness,
                    "status" => $status,
                    "reliability" => $reliability,
                    "Nnotifications" => $Nnotifications,
                    "locations" => $locations
                );
                //per non accumulare i valori azzero gli array
                $locations = array();
                $descriptions = array();
            }
        } else {
               $listaEventi=0;
        }
        return $listaEventi;
    }

    public function getEventiTabella($type, $subtype, $lat, $lng, $radius, $tmin, $tmax, $status) {
        $eventi = $this->db->query("SELECT Id,Type,Subtype,Lat,Lng,StartTime,Freshness,Status,Nnotifications FROM Evento WHERE (Status='open')OR (Status='closed')OR (Status='skeptical')");
        if ($eventi->num_rows() > 0) {
            foreach ($eventi->result_array() as $row) {
                $id = $row['Id'];
                $type = $row['Type'];
                $subtype = $row['Subtype'];
                $Lat = $row['Lat'];
                $Lng = $row['Lng'];
                $start_time = $row['StartTime'];
                $freshness = $row['Freshness'];
                $status = $row['Status'];
                $Nnotifications = $row['Nnotifications'];
                $locations[] = array("lat" => floatval($Lat), "lng" => floatval($Lng));
                $descriptionQuery = $this->db->query("SELECT Description FROM Notifica WHERE (Id_Evento = '$id')ORDER BY UnixTime DESC LIMIT 5 ");
                if ($descriptionQuery->num_rows() > 0) {
                    foreach ($descriptionQuery->result_array() as $row) {

                        $descriptions[] = array($row['Description']);
                    }
                }
                $listaEventi[] = array(
                    "event_id" => $id,
                    "type" => array("type" => $type, "subtype" => $subtype),
                    "description" => $descriptions,
                    "start_time" => $start_time,
                    "freshness" => $freshness,
                    "status" => $status,
                    //"reliability"=>$reliability,
                    "Nnotifications" => $Nnotifications,
                    "locations" => $locations
                );
                $locations = array();
                $descriptions = array();
            }
        } else {
            $listaEventi=0;
        }
        return $listaEventi;
    }

    public function add($idUser,$type,$subtype,$via,$indirizzo,$lat,$lng,$desc,$date,$credibilita)
    {
          $descr=mysql_real_escape_string($desc); 
     //prendo cordinate da notifica che ha stesso tipo sub e via del nuovo inserimento
     $listaIndirizzi= $this->db->query("SELECT Lat, Lng, Id_Evento FROM  `Notifica` WHERE (TYPE =  '$type')AND (Subtype =  '$subtype') AND (Indirizzo LIKE  '%$via%')");
      if ($listaIndirizzi->num_rows() > 0){
    foreach($listaIndirizzi->result_array() as $row){
      $latitudine=  floatval($row['Lat']);
      $longitudine=floatval($row['Lng']);
      $Id_Evento=$row['Id_Evento'];
// test  $this->db->query("INSERT INTO Notifica (Id_User,Type,Subtype,Indirizzo,Lat,Lng,Description,Id_Evento,UnixTime,Credibilita) values ('$Id_Evento','$latitudine','$longitudine','$indirizzo','$lat','$lng','$desc','$Id_Evento','$date','$credibilita')");
  $theta = $longitudine - $lng;
  $miles = (sin(deg2rad($latitudine)) * sin(deg2rad($lat))) + (cos(deg2rad($latitudine)) * cos(deg2rad($lat)) * cos(deg2rad($theta)));
  $miles = acos($miles);
  $miles = rad2deg($miles);
  $miles = $miles * 60 * 1.1515;
  $feet = $miles * 5280;
  $yards = $feet / 3;
  $kilometers = $miles * 1.609344;
  $meters = $kilometers * 1000;
  intval($meters);
  if($meters<"50"){
   $this->db->query("UPDATE Evento SET Freshness = $date WHERE (Id=$Id_Evento)");
          $this->db->query("UPDATE Evento SET Nnotifications = Nnotifications +1 WHERE (Id=$Id_Evento)");
        
      $this->db->query("INSERT INTO Notifica (Id_User,Type,Subtype,Indirizzo,Lat,Lng,Description,Id_Evento,UnixTime,Credibilita) values ('$idUser','$type','$subtype','$indirizzo','$lat','$lng','$descr','$Id_Evento','$date','$credibilita')");
   break 2;
  } //fine ciclo
     }
   }else{
  $this->db->query("INSERT INTO Evento(Type,Subtype,Lat,Lng,StartTime,Freshness,Status,Nnotifications,Open,Closed,Archived)VALUES('$type','$subtype','$lat','$lng','$date','$date','open',1,1,0,0);");
 $this->db->select_max('Id');
$maxid = $this->db->get('Evento');
       $row = $maxid->row();
$max=$row->Id;
 $this->db->query("INSERT INTO Notifica (Id_User,Type,Subtype,Indirizzo,Lat,Lng,Description,Id_Evento,UnixTime,Credibilita) values ('$idUser','$type','$subtype','$indirizzo','$lat','$lng','$descr','$max','$date','$credibilita')");
     }
     }
 
     public function apriStato($id) {
        $oldStato = $this->db->query("SELECT Status FROM `Evento` WHERE (Id =  '$id')");
        if ($oldStato->num_rows() > 0) {
            $row = $oldStato->row();
            $stat = $row->Status;
            if ($stat == "open") {
                $this->db->query("UPDATE Evento SET Open = Open +1 WHERE (Id='$id')");
            } else if ($stat == "skeptical") {
                $this->db->query("UPDATE Evento SET Open = Open +1 WHERE (Id='$id')");
                $openClosed = $this->db->query("SELECT Open,Closed FROM `Evento` WHERE (Id =  '$id')");
                if ($openClosed->num_rows() > 0) {
                    $row = $openClosed->row();
                    $open = $row->Open;
                    $closed = $row->Closed;
                    if ($open > $closed) {
                        $stat = "open";
                        $this->db->query("UPDATE Evento SET Status = '$stat' WHERE (Id='$id')");
                    }
                }
            } else if ($stat == "closed") {
                $stat = "skeptical";
                $this->db->query("UPDATE Evento SET Status = '$stat' WHERE (Id='$id')");
            }
        }
    }

    public function chiudiStato($id) {
        $oldStato = $this->db->query("SELECT Status FROM `Evento` WHERE (Id =  '$id')");
        if ($oldStato->num_rows() > 0) {
            $row = $oldStato->row();
            $stat = $row->Status;
            if ($stat == "open") {
                $stat = "closed";
                $this->db->query("UPDATE Evento SET Closed = Closed +1 WHERE (Id='$id')");
                $this->db->query("UPDATE Evento SET Status = '$stat' WHERE (Id='$id')");
            } else if ($stat = "skeptical") {
                $this->db->query("UPDATE Evento SET Closed = Closed +1 WHERE (Id='$id')");
                $openClosed = $this->db->query("SELECT Open,Closed FROM `Evento` WHERE (Id =  '$id')");
                if ($openClosed->num_rows() > 0) {
                    $row = $openClosed->row();
                    $open = $row->Open;
                    $closed = $row->Closed;
                    if ($open < $closed) {
                        $stat = "closed";
                        $this->db->query("UPDATE Evento SET Status = '$stat' WHERE (Id='$id')");
                    }
                }
            } else if ($stat == "closed") {
                $this->db->query("UPDATE Evento SET Closed = Closed +1 WHERE (Id='$id')");
            }
        }
    }

    public function archiviaStato($id) {
        $stat = "archived";
        $this->db->query("UPDATE Evento SET Status = '$stat' WHERE (Id='$id')");
    }

    public function multiCurl($get_par) {
        $serverList = array();
        $srvData = json_decode(file_get_contents("serverList.json", true), true);
        for ($i = 0; $i < count($srvData['server_comprati']); $i++) {
            $serverList[] = $srvData['server_comprati'][$i];
        }
        for ($i = 0; $i < count($srvData['server_altri']); $i++) {
            $serverList[] = $srvData['server_altri'][$i];
        }
        $request = array();
//Concateno la la stringa dei parametri di ricerca agli indirizzi dei server
        for ($s = 0; $s < count($serverList); $s++) {
            $request[] = $serverList[$s] . "" . $get_par;
        }
        $urlList = $request;
        $curlList = array();
        for ($i = 0; $i < count($urlList); $i++) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlList[$i]);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_ENCODING, "Accept: application/json");
            $curlList[] = $ch;
            $info = curl_getinfo($curlList[count($curlList) - 1]);
        }
        //creo il multiplecurl handle
        $mh = curl_multi_init();
        for ($i = 0; $i < count($curlList); $i++) {
            curl_multi_add_handle($mh, $curlList[$i]);
            $info = curl_getinfo($curlList[$i]);
        }
        $running = null;
        //faccio eseguire tutti
        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        $result = array();
        $resultServer = array();
        //recupero i risultati che mi sono dati in risposta
        for ($i = 0; $i < count($curlList); $i++) {
            $curlError = curl_error($curlList[$i]);
            $info = curl_getinfo($curlList[$i]);
            if ($curlError == "") {
                $result[] = curl_multi_getcontent($curlList[$i]);
                $resultServer[] = substr($info['url'], 0, 31);
            }
            curl_multi_remove_handle($mh, $curlList[$i]);
            curl_close($curlList[$i]);
        }
        //chiudo
        curl_multi_close($mh);
        $events = array();
        //vado a recuperare tutti gli eventi che sono arrivati nelle risposte dai server 
        for ($i = 0; $i < count($result); $i++) {
            $r = json_decode($result[$i], true);
            for ($k = 0; $k < count($r['events']); $k++) {
                if (isset($r['events'][$k]['event_id'])) {
                    $r['events'][$k]['event_id'] = $resultServer[$i] . "id_evento=[" . $r['events'][$k]['event_id'] . "]";
                    $events[] = $r['events'][$k];
                }
            }
        }
        //Ritorna la lista degli eventi degli altri server
        return $events;
    }

}
