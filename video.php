<?php
require($_SERVER['DOCUMENT_ROOT']."/inc/functions.php");
if(isset($_GET['link'])){
    $path = decrypt($_GET['link']);
    $ctype= 'video/mp4';
    header('Content-Type: ' . $ctype);
    $file_path_name = $path;
    $handle = fopen($file_path_name, "rb");
    $contents = fread($handle, filesize($file_path_name));
    fclose($handle);
    echo $contents;
}


 