<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Segnalazione_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
//    $idUser,$type,$subtype,$lat,$lng,$desc,$date,$credibilita
     public function inserisciNotifica($idUser,$type,$subtype,$lat,$lng,$desc,$date,$credibilita)
    {
//        $notifica = "insert into Notifica (Id,Id_User,Type,Subtype,Lat,Lng,Description,Id_Evento,UnixTime,Credibilita) values ('3','$idUser','$type','$subtype','$lat','$lng','$desc','',$date','$credibilita')";
        $notifica = "insert into Notifica (Id,Id_User,Type,Subtype,Lat,Lng,Description,Id_Evento,UnixTime,Credibilita) values ('3','1','$type','$subtype','2','22','ddd','1','1','1')";
        $this->db->query($notifica);
    }
    
    
}