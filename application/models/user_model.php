<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

   

    public function get_id($username)
    {
        $row = $this->db->get_where('Utente', array('Username' => $username))->row();        
        return $row->Id;
    }

    public function get_Username()
    {
        $users = $this->db->select('Username')
            ->order_by('Username')
            ->get('Utente')
            ->result_array();

        return $users;
    }
//metodo per la registrazione
    public function add($username, $password){
         $query = $this->db->get_where('Utente', array('Username' => $username));
          if ($query->num_rows == 1) {
                return FALSE;
          }
          $this->db->insert('Utente', array('Username' => $username, 'Password' => md5($password)));
          return TRUE;
    }
     public function check_password($idutente, $password)
    {
        $check = $this->db->get_where('Utente', array('Id' => $idUtente, 'Password' => md5($password)));
        
        return ($check->num_rows == 1) ? TRUE : FALSE;
    }
     public function is($username, $password)
    {
   
        $query = $this->db->get_where('Utente', array('Username' => $username, 'Password' => $password));
         return ($query->num_rows == 1) ? TRUE : FALSE;
    }
    public function admin($username){
            $tipologia= $this->db->query("SELECT Tipologia FROM Utente WHERE (Username='$username') ");
          if ($tipologia->num_rows() > 0){
             $row = $tipologia->row(); 
$tipo=  $row->Tipologia;
return $tipo;
          }
          
}
     public function getCredibilita($idUser) {
         
     $credibilit = $this->db->query("SELECT Credibilita FROM Utente WHERE (id=$idUser)");    
      $row = $credibilit->row(); 
$credibilita=  $row->Credibilita;

     return $credibilita;
    }
    
    public function aumentaAssiduita($idUser){
             $assiduit = $this->db->query("SELECT Assiduita FROM Utente WHERE (id=$idUser)");
              $row =  $assiduit->row(); 
 $assiduita=  $row->Assiduita;
         $newassiduita=floatval($assiduita)+0.01;
$this->db->query("UPDATE Utente SET Assiduita=$newassiduita WHERE (id=$idUser)");
    }
}
      
    
     


