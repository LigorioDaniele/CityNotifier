<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Citynotifier</title>
  <meta name="description" content="vivi la città anche in digitale">
  <meta name="author" content="DanieleLigorio">
  <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  <!-- Le styles -->
  <link href="<?=base_url('css/bootstrap.css'); ?>" rel="stylesheet" type="text/css">
  <link href="<?=base_url('css/bootstrap-responsive.css'); ?>" rel="stylesheet" type="text/css">  
  <link href="<?=base_url('css/yourcontacts.css'); ?>" rel="stylesheet" type="text/css">
  <link href="<?=base_url('css/tablesorter.css'); ?>" rel="stylesheet" type="text/css">
  <!-- Le fav and touch icons -->
  <link href="<?=base_url('css/ico/favicon.ico'); ?>" rel="shortcut icon">
   <link href="<?=base_url('css/datepicker.css'); ?>"rel="stylesheet"type="text/css">  
  <style>
      html, body, #map-canvas {
          height: 800px;
        margin: 10px;
        padding: 0px
      }
  </style>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcMgx10E_fStR2qDcaA1mxeT5g5fO722E&sensor=true"></script>
<script src="<?=base_url('js/Mappa.js'); ?>"></script> 
<script src="<?=base_url('js/jquery-1.9.1.js'); ?>"></script>
<script src="<?=base_url('js/bootstrap.min.js'); ?>"></script>
<script src="<?=base_url('js/bootstrap-dropdown.js'); ?>"></script> 
<script src="<?=base_url('js/select.js' ); ?> "></script>
<script src="<?=base_url('js/richieste.js' ); ?> "></script>
<script src="<?=base_url('js/segnalazione.js' ); ?> "></script>

  
</head>

 <body onload="initialize()">
