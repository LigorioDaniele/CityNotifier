<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class curl extends CI_Model {
 function __construct()
    {
        parent::__construct();
    }

function multiCurl($get_par){
	$serverList=array();
	
	//Carico la lista dei server dal file xml
	$srvData=json_decode(file_get_contents("serverList.json",true),true);
	for($i=0;$i<count($srvData['server_comprati']);$i++){
		$serverList[]=$srvData['server_comprati'][$i];
			
	}
	
	for($i=0;$i<count($srvData['server_altri']);$i++){
		$serverList[]=$srvData['server_altri'][$i];
	}
	
	$request = array();

	//Concateno la la stringa dei parametri di ricerca agli indirizzi dei server
	for($s=0;$s<count($serverList);$s++){
		$request[]=$serverList[$s]."".$get_par;
	}
	$urlList=$request;
	$curlList=array();
	for($i=0;$i<count($urlList);$i++){
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $urlList[$i]);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-type: application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING,"Accept: application/json");
		$curlList[]=$ch;
		$info = curl_getinfo($curlList[count($curlList)-1]);
	}
	//creo il multiplecurl handle
	$mh = curl_multi_init();
	for($i=0;$i<count($curlList);$i++){
		curl_multi_add_handle($mh,$curlList[$i]);
		$info = curl_getinfo($curlList[$i]);
	}
	$running=null;
	//faccio eseguire tutti
	do {
		curl_multi_exec($mh,$running);
	} while($running > 0);
	
	$result=array();
	$resultServer=array();
	
	//recupero i risultati che mi sono dati in risposta
	for($i=0;$i<count($curlList);$i++){
		$curlError = curl_error($curlList[$i]);
		$info = curl_getinfo($curlList[$i]);
		if($curlError == "") {
			$result[]=curl_multi_getcontent($curlList[$i]);
			$resultServer[]=substr($info['url'],0,31);
		}
		curl_multi_remove_handle($mh,$curlList[$i]);	
		curl_close($curlList[$i]);
	}
	//chiudo
	curl_multi_close($mh);
	$events=array();
	//vado a recuperare tutti gli eventi che sono arrivati nelle risposte dai server 
	for($i=0;$i<count($result);$i++){
		$r=json_decode($result[$i],true);
		for($k=0;$k<count($r['events']);$k++){
			if(isset($r['events'][$k]['event_id'])){
				$r['events'][$k]['event_id']=$resultServer[$i]."id_evento=[".$r['events'][$k]['event_id']."]";
				$events[]=$r['events'][$k];
			}
		}
	}
	//Ritorna la lista degli eventi degli altri server
        echo $events;
	return $events;
	
}
}