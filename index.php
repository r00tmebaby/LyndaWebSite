<?php
@session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT']."/inc/functions.php");
if(!defined('access')) {
          header('HTTP/2.0 403 Forbidden');
          exit;
}
if(isset($_GET['download'])){
	require("inc/download.php");
}
 
?>

<script>
function hidebg() {
  document.getElementById('foo').style.opacity = '0';
  document.getElementById('foo').style.transition = 'all 1s'; 
}

function showbg() {
   document.getElementById('foo').style.opacity = '1';
   document.getElementById('foo').style.transition = 'all 1s';
   window.setTimeout(function(){location.reload()},1000)
}
function showmenu() {
   document.getElementById('top-menu').style.display = 'table';
   document.getElementById('top-menu').style.transition = 'all 1s';
}
 function showmenu1() {
document.getElementById('user_menu').style.display = 'table';
   document.getElementById('user_menu').style.transition = 'all 3s';
}     
function off() {
   document.getElementById('info_coursem').style.display = 'none';
   document.getElementById('get_videom').style.display = 'none';
   document.getElementById('materialsm').style.display = 'none';
}
function removemenu1() {
   document.getElementById('user_menu').style.display = 'none';
   document.getElementById('user_menu').style.transition = 'all 3s';
}
function removemenu() {
   document.getElementById('top-menu').style.display = 'none';
   document.getElementById('top-menu').style.transition = 'all 3s';
}

function remove_video() {
  document.getElementById('get_videom').style.display = 'none';
  $('video').trigger('pause');
}
function remove_info() {
  document.getElementById('info_coursem').style.display = 'none';
  document.getElementById('get_videom').style.display = '';
}
function show_info() {
  document.getElementById('info_coursem').style.display = '';
  document.getElementById('get_videom').style.display = 'none';
}
function functions(func,itemid,id,specs,name,archives){
    var str = $('#'+func).serialize();
    $.ajax({
        url: 'inc/jax.php?loader='+func+'&item='+itemid+'&id='+id+'&specdir='+specs+'&name='+name,
        type: "POST",
        data: ''+str+'',
        success: function(msgc)
        {
            $('#'+func+'m').empty().append(""+msgc+"").hide().fadeIn("fast");
	            $(document).ajaxStart(function() {			
                 $("#loading").show();
			    
                
                }).ajaxStop(function() {
                 $("#loading").hide();
				
				  
                });
        }
    });
	
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

</script>

<head>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css"/>
	<link rel="stylesheet" href="./css/icons.css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>	
	<link rel="icon" type="image/png"  href="favicon.png">
</head>

<?php

$error = array();
if(!logged()){

 ?>
         
	<div class="col-lg-12 container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
					
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
					<div></div>
                    <div class="panel-body">  
					<div id="loginm" style="position:absolute" ></div>
                        <form method="post" id="login" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="username" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="button" onclick="functions('login')" value="Login" class="btn btn-lg btn-success btn-block"/>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <div>
<?php
}
else{

	
?>	

<div id="top-menu" onmouseover="showmenu()" onmouseout="removemenu()">    
       <div class="col-sm-4">
	        <div id="menum"></div>
	   </div>
       <div class="col-lg-8">
	       <div id="menu_subm"></div>
	   </div>
	 
</div>

<div id="loading">						 
    <img class="error images-loader" src="./media/blackdove_spinner.gif">							
</div>	

<div class="top-nav">
    <div class="container ">
        <ul class="primary-nav list-unstyled">	    	
            <li class="bg-color"><a onclick="showbg()" href="#">Home</a></li>		
			<li class="bg-color"><a onmouseover="functions('menu'),showmenu()">Menu</a></li>
		     
            <li style="width:100px;color:white;padding:5px 5px;font-weight:900;text-align:center;" onmouseover="showmenu1()" onmouseout="removemenu1()" class="bg-color pull-right"><span style="font-size:20px;text-align:center;color:white;" class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $_SESSION['username']?></li>
				<div onmouseover="showmenu1()" onmouseout="removemenu1()"  id="user_menu">
				     <li class="nae" onclick="functions('user_menu')"><a ><span class="glyphicon glyphicon-edit"></span>Details</a></li>
				     <li class="nae" onclick="functions('logout'),location.reload();"><a><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>Logout</a></li>
			    </div>
				
        </ul>
</div> </div>
<div class="header" id="foo"></div>
<div  class="row" style="height:auto;margin:auto">
  								     		
    <div class="content">
	
       <div id="languagesm"> </div>     
        	<div class="col-lg-6">
                <div id="info_coursem"></div>		
        	    <div id="get_videom"></div>				
            </div>
		<div id="materialsm"> </div>	
</div>
</div>

<?php 
}
?>

