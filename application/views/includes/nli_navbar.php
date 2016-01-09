<div class="navbar navbar-static-top">
  <div class="navbar-inner">
    <div class="container">
        
      <a class="brand" href="<?=site_url('site'); ?>"><img src="<?=base_url('css/img/eteam.png'); ?>"></a>
        <a href="<?=site_url('signup'); ?>" class="btn btn-info"><i class="icon-arrow-right icon-white"></i> Registrati ora!</a>
     <ul class="nav pull-right">
        
      <li class="dropdown pull-right" id="menu1">
             <a class="dropdown-toggle " data-toggle="dropdown" href="#menu1">
               Login
                <b class="caret"></b>
             </a>
             <div class="dropdown-menu ">
               <form style="margin: 0px" accept-charset="UTF-8" action="<?=site_url('login/check'); ?>" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="authenticity_token" type="hidden" value="4L/A2ZMYkhTD3IiNDMTuB/fhPRvyCNGEsaZocUUpw40=" /></div>
                 <fieldset class='textbox' style="padding:10px">
                   <input style="margin-top: 8px" name="Username" type="text" placeholder="Username" />
                   <input style="margin-top: 8px" name="Password" type="password" placeholder="Passsword" />
                   <input class="btn-primary" name="commit" type="submit" value="Log In" />
                 </fieldset>
               </form>
             </div>
           </li>
     </ul>
    </div>
  </div>
</div>