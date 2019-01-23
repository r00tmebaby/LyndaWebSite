<?php
define("access",true);
if(!defined('access')) {
          header('HTTP/2.0 403 Forbidden');
          exit;
}

function config(){
	           // method , key    , separator
	return array("AES-128-CBC","//e//qwe.,k#$%EWERGFQT%$##W^%H00203\234tkeopkrfodk'd''>AS>D@!#%^$%*^()_",':');
}

function clean_name($name){
	$name = explode("_",$name);
	return($name);	 
}

function getIv()
    {
		$config = config();
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length($config[0]));
    }

function encrypt($data)
    {
		$config = config();
        $iv = getIv();
        return base64_encode(openssl_encrypt($data, $config[0], $config[1], 0, $iv) . $config[2] . base64_encode($iv));
    }

function decrypt($dataAndVector)
    {
		$config = config();
        $parts = explode($config[2], base64_decode($dataAndVector));
        return openssl_decrypt($parts[0], $config[0], $config[1], 0, base64_decode($parts[1]));
    }

function exists($dir){
	$all_courses = dirToArray($dir);
	if(count($all_courses)>0){
		return $all_courses;
	}
	else {
		return false;
	}
}


function dirToArray($dir) { 
   
   $result = array(); 

   $cdir = scandir($dir); 
   foreach ($cdir as $key => $value) 
   { 
      if (!in_array($value,array(".","..",".htaccess",".php"))) 
      { 
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
         { 
            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
         } 
         else 
         { 
            $result[] = $value; 
         } 
      } 
   } 
   
   return $result; 
} 

function credentials(){
	$select = mysqli_query(conn(),"Select * from users");
	$array = array();
	while($rows = mysqli_fetch_array($select)){
		$array[] = $rows['username'] . $rows['password']; 
	}
	return $array;
}
function logged(){
	if(!isset($_SESSION['username']) && !isset($_SESSION['username'])){
		return false;
	}
	else{
	   return true;
	}
}
function errors($array){
		/* array [text=>text type], $type =1:succces, $type=2:error, $type=3:warning */
	    foreach($array as $text => $values){
			$keys = array_keys($values);
			$val  = array_values($values);
	    	switch($val[0]){
	    	case 1: echo '<div  class="alert fixed alert-success" role="alert"><strong><span class="	glyphicon glyphicon-question-sign"></span>'.$keys[0].'</strong></div>';refresh(1); break;
	    	case 2: echo '<div  class="alert fixed alert-danger" role="danger"><strong><span class="	glyphicon glyphicon-question-sign"></span>'.$keys[0].'</strong></div>'; refresh(1); break;
	    	case 3: echo '<div  class="alert fixed alert-warning" role="warning"><strong><span class="	glyphicon glyphicon-question-sign"></span>'.$keys[0].'</strong></div>'; refresh(1); break;
	    	default: echo '<div  class="alert fixed alert-info" role="info"><strong><span class="	glyphicon glyphicon-question-sign"></span>'.$keys[0].'</strong></div>';refresh(1); break;
	    }
	}
}

function logout(){
	if(isset($_POST['logout'])){
		session_destroy();
		refresh();
	}
}
function reload(){
			echo "<script type='text/javascript'>

                 (function()
                 {
                   if( window.localStorage )
                   {
                     if( !localStorage.getItem('firstLoad') )
                     {
                       localStorage['firstLoad'] = true;
                       window.location.reload();
                     }  
                     else
                       localStorage.removeItem('firstLoad');
                   }
                 })();
                 
                 </script>";	
}

function refresh($time=0){
	echo'<meta http-equiv="refresh" content="'.$time.'">';
}
function ip() {
    $ipaddress = '0.0.0.0';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return ip2long($ipaddress);
}

function protect($var=NULL) {
$newvar = @preg_replace('/[^a-zA-Z0-9\_\-\.]/', '', $var);
if (@preg_match('/[^a-zA-Z0-9\_\-\.]/', $var)) { }
return $newvar;
}
function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($dir); 
   } 
}

function magic_quotes($var){
	return (! get_magic_quotes_gpc ()) ? addslashes ($var) : $var;
}

//from html_entity_decode() manual page
function unhtmlentities ($string) {
   $trans_tbl =get_html_translation_table (HTML_ENTITIES );
   $trans_tbl =array_flip ($trans_tbl );
   return strtr ($string ,$trans_tbl );
}

function conn(){
    /////////////////////////////////////////////////////////////////////
    // MYSQLi Configuration /////////////////////////////////////////////
    $option["t_host"]            = ""; // HostName :: IP Adress
    $option["t_user"]            = ""; // MySQL User
    $option["t_pass"]            = ""; // MySQL Pass
    $option["t_database"]        = ""; // MySQL Database
    $link = mysqli_connect($option["t_host"],$option["t_user"],$option["t_pass"],$option["t_database"]);
    if (!$link) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    else{
      return($link);
    }
  mysqli_close($link);
}
?>
