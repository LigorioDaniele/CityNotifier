<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
         $this->load->helper(array('url'));
       
         if (!$this->is_logged_in()) {
            redirect('login');
        }
    }
    
    public function index()
    {

           $this->load->view('home');
          
    }
    
    public function richieste(){
             if(isset($_GET['scope'])&&isset($_GET['type'])&&isset($_GET['subtype'])&&isset($_GET['lat'])&&isset($_GET['lng'])&&isset($_GET['radius'])&&isset($_GET['status'])){
//   assegno alle variabili i valori passati tramite get 
	$scope=$_GET['scope'];
	$type=$_GET['type'];
	$subtype=$_GET['subtype'];
	$lat=$_GET['lat'];
	$lng=$_GET['lng'];
	$radius=$_GET['radius'];      
	$tmin=$_GET['timemin'];
	$tmax=$_GET['timemax'];
	$status=$_GET['status'];
        if($scope=="local"){
             $radius=$radius/1000;
       $listaEventi = $this->contact_model->getEventi($type,$subtype,$lat,$lng,$radius,$tmin,$tmax,$status);
        
                        $jsonData=array(
				"request_time"=>time(),
				"result"=>"Messaggio di servizio",
				"from_server"=>"http://ltw1323.web.cs.unibo.it",
				"events"=>$listaEventi
		);
		header('Content-Type: application/json');
               
		echo json_encode($jsonData);
        }else if($scope=="remote"){
          
		//Se lo scope contiene remote vado ad interrogare gli altri server
                //Creo la stringa dei parametri utili alla richiesta che poi verrà concatenata con gli indirizzi dei server
//$get_par="/richieste?scope=local&type=all&subtype=all&lat=44.495771&lng=11.344744&radius=50000&timemin=2678400&timemax=1418425199&status=all";
                $get_par = "/richieste?scope=local&type=$type&subtype=all&lat=$lat&lng=$lng&radius=$radius&timemin=2678400&timemax=$tmax&status=$status";
                //Vado a fare le richieste sugli altri server ricevendo gli eventi degli altri server
                
                $remote_events_receive = $this->contact_model->multiCurl($get_par);
                $remote_events = array();
                //Aggrego gli eventi remoti tra di loro
                for ($k = 0; $k < count($remote_events_receive) - 1; $k++) {
                    $control = true;
                    for ($j = $k + 1; $j < count($remote_events_receive); $j++) {
                        //COntrollo tipo e sottotipo
                        if ($remote_events_receive[$j]['type']['type'] == $remote_events_receive[$k]['type']['type'] && $remote_events_receive[$j]['type']['subtype'] == $remote_events_receive[$k]['type']['subtype']) {
                            //Recupero l'intorno spaziale
//					$r=controlTypeSubtype($remote_events_receive[$j]['type']['type'], $remote_events_receive[$j]['type']['subtype']);
                            //Controllo posizione
                            $lat_Evento = $remote_events_receive[$j]['locations'][0]['lat'];
                            $lng_Evento = $remote_events_receive[$j]['locations'][0]['lng'];
                            $lat_Evento2 = $remote_events_receive[$k]['locations'][0]['lat'];
                            $lng_Evento2 = $remote_events_receive[$k]['locations'][0]['lng'];
                            $theta = $lng_Evento - $lng_Evento2;
                            $miles = (sin(deg2rad($lat_Evento)) * sin(deg2rad($lat_Evento2))) + (cos(deg2rad($lat_Evento)) * cos(deg2rad($lat_Evento2)) * cos(deg2rad($theta)));
                            $miles = acos($miles);
                            $miles = rad2deg($miles);
                            $miles = $miles * 60 * 1.1515;
                            $feet = $miles * 5280;
                            $yards = $feet / 3;
                            $kilometers = $miles * 1.609344;
                            $meters = $kilometers * 1000;
                            $distanzaMinima = 20;
                            if ($meters <= $distanzaMinima) {
                                if($remote_events_receive[$k]['freshness']<$remote_events_receive[$j]['freshness']){
								$control=false;
							}else{
								$control=true;
							}					
					}
				}						
			if($control==true){
				$remote_events[]=$remote_events_receive[$k];			
			}
		}		
                }
           
                       $listaEventi = $this->contact_model->getEventi($type,$subtype,$lat,$lng,$radius,$tmin,$tmax,$status);
                $eventiLocaliRimossi=array();
		 $eventiRemotiRimossi=array();
                for($k=0;$k<count($remote_events);$k++){
			$control=true;
			for($j=0;$j<count($listaEventi);$j++){
                            if($listaEventi[$j]['type']['type']==$remote_events[$k]['type']['type'] && $listaEventi[$j]['type']['subtype']==$remote_events[$k]['type']['subtype']){
						$lat_Evento=$listaEventi[$j]['locations'][0]['lat'];
							$lng_Evento=$listaEventi[$j]['locations'][0]['lng'];
							$lat_Evento2=$remote_events[$k]['locations'][0]['lat'];
							$lng_Evento2=$remote_events[$k]['locations'][0]['lng'];
                                                          $miles = (sin(deg2rad($lat_Evento)) * sin(deg2rad($lat_Evento2))) + (cos(deg2rad($lat_Evento)) * cos(deg2rad($lat_Evento2)) * cos(deg2rad($theta)));
  $miles = acos($miles);
  $miles = rad2deg($miles);
  $miles = $miles * 60 * 1.1515;
  $feet = $miles * 5280;
  $yards = $feet / 3;
  $kilometers = $miles * 1.609344;
  $meters = $kilometers * 1000;
  $distanzaMinima=20;
					if($meters<=$distanzaMinima){
							if($remote_events[$k]['freshness']<$listaEventi[$j]['freshness']){
                                                            $eventiRemotiRimossi[]=$remote_events[$k]['event_id'];							
							}else{								
                                                                $eventiLocaliRimossi[]=$listaEventi[$j]['event_id'];
							}
						}
				}								
                        }
		}
                       		$jsonData=array(
				"request_time"=>time(),
				"result"=>"Messaggio di servizio",
				"from_server"=>"http://ltw1323.web.cs.unibo.it",
				"events"=>$remote_events
				
		);                
		header('Content-Type: application/json');
		echo json_encode($jsonData);		
                }else{
//	Invio il json contenente un messaggio di errore relativo alla richiesta fatta
	header('Content-Type: application/json');
	echo json_encode(array("request_time"=>time(),"result"=>"Errore nel passaggio dei parametri"));
}
    }
    }
    public function richiesteTabella(){
                if(isset($_GET['scope'])&&isset($_GET['type'])&&isset($_GET['subtype'])&&isset($_GET['lat'])&&isset($_GET['lng'])&&isset($_GET['radius'])&&isset($_GET['status'])){
//   assegno alle variabili i valori passati tramite get 
	$scope=$_GET['scope'];
	$type=$_GET['type'];
	$subtype=$_GET['subtype'];
	$lat=$_GET['lat'];
	$lng=$_GET['lng'];
	$radius=$_GET['radius'];      
	$tmin=$_GET['timemin'];
	$tmax=$_GET['timemax'];
	$status=$_GET['status'];      
             $radius=$radius/1000;
       $listaEventi = $this->contact_model->getEventiTabella($type,$subtype,$lat,$lng,$radius,$tmin,$tmax,$status);   
                       
       //Vado a fare le richieste sugli altri server ricevendo gli eventi degli altri server
                $get_par="/richieste?scope=local&type=all&subtype=all&lat=44.495771&lng=11.344744&radius=50000&timemin=2678400&timemax=1418425199&status=all";

                $remote_events_receive = $this->contact_model->multiCurl($get_par);
                $listaEventi= $listaEventi+$remote_events_receive;
       
       $jsonData=array(
				"request_time"=>time(),
				"result"=>"Messaggio di servizio",
				"from_server"=>"localhost/Citynotify",
				"events"=>$listaEventi
		);
		header('Content-Type: application/json');              
		echo json_encode($jsonData);      
                
                }else{
//	Invio il json contenente un messaggio di errore relativo alla richiesta fatta
	header('Content-Type: application/json');
	echo json_encode(array("request_time"=>time(),"result"=>"Errore nel passaggio dei parametri"));
}
    }
    public function add()
    {
        if(isset($_POST['jsonResponse'])){
         $username=$this->session->userdata('Username');
         $idUser= $this->user_model->get_id($username);
        $segnala=$_POST['jsonResponse'];        
	$typeData=$segnala['type'];
	$type=$typeData['type'];
	$subtype=$typeData['subtype'];
        $via=$segnala['via'];
        $indirizzo=$segnala['indirizzo'];
	$lat=$segnala['lat'];
	$lng=$segnala['lng'];
	$desc=$segnala['description'];
	$date=time();  
       $credibilita=$this->user_model->getCredibilita($idUser);      
        $this->user_model->aumentaAssiduita($idUser);
        $this->contact_model->add($idUser,$type,$subtype,$via,$indirizzo,$lat,$lng,$desc,$date,$credibilita);
    }else{
        header('Content-Type: application/json');
	echo json_encode(array("event_id"=>0,"result"=>"ops! prova a reinserire la notifica") );
    }    
    }
    public function apriStato()
    {
        if(isset($_POST['jsonResponse'])){
             $updateStato=$_POST['jsonResponse']; 
             $id=$updateStato['id'];          
            $this->contact_model->apriStato($id);            
        }else{
            header('Content-Type: application/json');
	echo json_encode(array("event_id"=>0,"result"=>"ops! non ho un id per aggiornare l'evento") );
        }            
    }
       public function chiudiStato()
    {
        if(isset($_POST['jsonResponse'])){
             $updateStato=$_POST['jsonResponse']; 
             $id=$updateStato['id'];          
            $this->contact_model->chiudiStato($id);            
        }else{
            header('Content-Type: application/json');
	echo json_encode(array("event_id"=>0,"result"=>"ops! non ho un id per aggiornare l'evento") );
        }            
    }
       public function archiviaStato()
    {
        if(isset($_POST['jsonResponse'])){
             $updateStato=$_POST['jsonResponse']; 
             $id=$updateStato['id'];
            
            $this->contact_model->archiviaStato($id);             
        }else{
            header('Content-Type: application/json');
	echo json_encode(array("event_id"=>0,"result"=>"ops! non ho un id per aggiornare l'evento") );
        }           
    }
  public function isAdmin(){
        $username=$this->session->userdata('Username');
            $response=  $this->user_model->admin($username);
               echo json_encode($response);
		header('Content-Type: application/json');
  }
   public function profile()
    {
        $this->load->view('profile');
    }   
    public function change_password()
    {
        sleep(1);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('curpwd', 'Current Password', 'required|max_length[20]|alpha_numeric');
        $this->form_validation->set_rules('newpwd', 'New Password', 'required|max_length[20]|alpha_numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $message = "<strong>Changing</strong> failed!";
            $this->json_response(FALSE, $message);
        } else {
            $pwd_valid = $this->user_model->check_password(
                $this->session->userdata('uid'), $this->input->post('curpwd'));
            
            if ($pwd_valid) {
                $this->user_model->update_password(
                    $this->session->userdata('uid'), $this->input->post('newpwd'));

                $message = "<strong>Password</strong> has been changed!";
                $this->json_response(TRUE, $message);
            } else {
                $message = "<strong>Current Password</strong> is wrong!";
                $this->json_response(FALSE, $message);
            }
        }
    }
    
    private function is_logged_in()
    {
        return $this->session->userdata('is_logged_in');
    }

    private function json_response($successful, $message)
    {
        echo json_encode(array(
            'isSuccessful' => $successful,
            'message' => $message
        )); 
    }

    public function alpha_dash_space($str)
    {
        return ( ! preg_match("/^([-a-z0-9_ ])+$/i", $str)) ? FALSE : TRUE;
    }
}
/* End of file site.php */
