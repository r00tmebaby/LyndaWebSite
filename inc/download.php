<?php
if(isset($_GET['download'])){
    $code  = decrypt($_GET['download']);
    if($code){
		$filename_real = explode("/",$code);	
        ob_start();
           $mm_type="application/octet-stream";
           $file = $code;
           $filename = "r00tLib_".$filename_real[count($filename_real)-1].".zip";
           header("Cache-Control: public, must-revalidate");
           header("Pragma: no-cache");
           header("Content-Type: " . $mm_type);
           header("Content-Length: " .(string)(filesize($file)) );
           header('Content-Disposition: attachment; filename="'.$filename.'"');
           header("Content-Transfer-Encoding: binary\n");
           ob_end_clean();
         readfile($file);  
	}
}	
?>