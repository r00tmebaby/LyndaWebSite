<?php
session_start();
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	
include($_SERVER['DOCUMENT_ROOT']."/inc/functions.php");

if(!defined('access')) {
          header('HTTP/2.0 403 Forbidden');
          exit;
}

$i      =  0;
$ountz  =  0;
$tr     = "";
$crs    = "";
$active = "";
$dupi   = array();
$hr     = "";
$header = "";
$retus  = "";
$names  = "";
$left   = "";
$params = array();

switch(trim($_GET['loader'])){	

            case "login":
			    $error = array();	
                if(isset($_POST['username']) && isset($_POST['password'])){		
	                 if(in_array($_POST['username'].$_POST['password'],credentials())){	
	                 	$_SESSION['username'] = $_POST['username'];
	                 	$_SESSION['password'] = $_POST['password'];	
	             	    refresh();
	                 }
	                 else{
	                     $error[] = ["Wrong Credentials!" => 2];			
	                 }
	             	errors($error);
	             }
            break;			
    	    case "menu":	
			    if (exists($_SERVER['DOCUMENT_ROOT']."/courses/")){          							   
					    foreach(exists($_SERVER['DOCUMENT_ROOT']."/courses/") as $key => $value){
                          $i++;							
                          echo '<li onclick="off(),functions(\'menu_sub\',\''.encrypt($key).'\')"><a ><i class="lyndacon cat-'.$i.' category-icons"></i>'.$key.'</a></li>'; 
					    }					
				   }									   
			break;
			
// Submenu //Subfolders		
	
            case "menu_sub":		        
			    if(exists($_SERVER['DOCUMENT_ROOT']."/courses/".decrypt($_GET['item']))){          							      
                           echo "<div class='col-sm-12'>";				
			            foreach(exists($_SERVER['DOCUMENT_ROOT']."/courses/".decrypt($_GET['item'])) as $keys => $values){			        			   
                           echo '<div class="col-sm-6"><li onclick="off(),functions(\'languages\',\''.$_GET['item'].'\',\''.encrypt($keys).'\')"><a >'.$keys.'</a></div></li>'; 
			            }
                           echo " </div>";
			        }					
			break;  

     		case "info_course":
                		    
	            if(!file_exists($_SERVER['DOCUMENT_ROOT']."/courses/".decrypt($_GET['item']).'/'.decrypt($_GET['id']).'/'.decrypt($_GET['specdir']).'/info.php')){
					return("Information File for this course is missing");
				}
				else{
					require_once($_SERVER['DOCUMENT_ROOT']."/courses/".decrypt($_GET['item']).'/'.decrypt($_GET['id']).'/'.decrypt($_GET['specdir']).'/info.php'); 
				}

		    break;
		    case "user_menu":
	   
			   
			break;
			case "languages":
				if(exists($_SERVER['DOCUMENT_ROOT']."/courses/".decrypt($_GET['item']).'/'.decrypt($_GET['id']))){  		   
					   foreach(exists($_SERVER['DOCUMENT_ROOT']."/courses/".decrypt($_GET['item']).'/'.decrypt($_GET['id'])) as $key => $value){					 
                        $i++;
						$check_code = explode("-",$key);

						 	 
						 if($check_code[0]== 2){
							 $header ="<img class='level' src='./media/advanced.svg'>";
						 }
						 elseif($check_code[0]== 1){
							 $header ="<img class='level' src='./media/intermediate.svg'>";
						 }
						 elseif($check_code[0]== 0){
							 $header ="<img class='level' src='./media/beginner.svg'>";
						 }
                       
						$crs .='<a class="uroklink" href="#"
						 						onclick="
						remove_video(),
						functions(\'info_course\',\''.$_GET['item'].'\',\''.$_GET['id'].'\',\''.encrypt($key).'\'),
						functions(\'materials\',\''.$_GET['item'].'\',\''.$_GET['id'].'\',\''.encrypt($key).'\'),
						functions(\'header_text\',\''.$_GET['item'].'\',\''.$_GET['id'].'\',\''.encrypt($key).'\')" >
						
						<span class="glyphicon glyphicon-hand-right"></span><span style="margin-left:10px;max-width:40%;font-weight:600;">'.$check_code[1].'</span><b>'. $header .'</b></a>';
                  
					  }	
                    echo'   
					    <div class="col-lg-3 micro">
        	                <div class="panel panel-default ">
                                 <div class="panel-heading"><span class=" glyphicon glyphicon-education"></span> Related Courses <span style="float:right">Level</span></div>
        	                     <div style="overflow:auto;max-height:50%" class="panel-body interior">
        	             		   '.$crs.'
        	             		</div>	
        	                </div>     	                            
						</div> ';					  				 
				}					
			break;
			case "logout":
			    session_destroy();

			break;
			case "materials":
			    if(exists($_SERVER['DOCUMENT_ROOT']."/courses/".decrypt($_GET['item']).'/'.decrypt($_GET['id']).'/'.decrypt($_GET['specdir']))){                
                         $dir = $_SERVER['DOCUMENT_ROOT']."/courses/".decrypt($_GET['item']).'/'.decrypt($_GET['id']).'/'.decrypt($_GET['specdir']);
                             chdir($dir);
                             array_multisort(array_map('natsort', ($files = glob("*.*"))), SORT_DESC, $files);
                             foreach($files as $value)
                             {                   		  
                                if(substr($value,-4) === ".mp4"){
									
                			    $clean_name = str_replace(".mp4","",$value);
							
							    if(isset($_SESSION['watched'])){
								    if(in_array($value,$_SESSION['watched'])){
									    	
								  	        $active = '<span style="float:right;" class="actives glyphicon glyphicon-eye-open"></span>';
								        }
									    else{
									    	
									    	$active = "";
									       }									   
								}
                                 $i++;
								 
								$filedir = $_SERVER['DOCUMENT_ROOT']."/courses/".decrypt($_GET['item']).'/'.decrypt($_GET['id']).'/'.decrypt($_GET['specdir']).'/'.$value;  
						        $encrypto = encrypt($_SERVER['DOCUMENT_ROOT']."/courses/".decrypt($_GET['item']).'/'.decrypt($_GET['id']).'/'.decrypt($_GET['specdir']).'/'.$value);
								
								if($i % 5 == 0){
									$hr = "<hr></hr>";
								}else{
									$hr  = "";
								}
							//	$fileinfos = dur($filedir);
								//$duration  = $fileinfos['playtime_string'];
								$minutes = floor(clean_name($clean_name)[2]/60);
								$seconds = clean_name($clean_name)[2] % 60;
								$duration = $minutes . "." . $seconds;
								$tr .= '
								        <a href="#" onclick="
										   setCookie(\'video\',\''. $encrypto.'\',\'1\'),
										   remove_info(),
								           functions(\'get_video\',\''.$_GET['item'].'\',\''.$_GET['id'].'\',\''.$_GET['specdir'].'\',\''.encrypt($value).'\',\''.encrypt($clean_name).'\'),
								           functions(\'check_status\',\''.$_GET['item'].'\',\''.$_GET['id'].'\',\''.$_GET['specdir'].'\',\''.encrypt($value).'\',\''.encrypt($clean_name).'\')" 
								           class=" uroklink">
								           <span class="glyphicon glyphicon-play-circle"></span>
								           &nbsp;<b>'.clean_name($clean_name)[1].'</b>
										  <i>'.($duration).'</i>&nbsp;'.$active.'
								        </a>'.$hr.'';															
								}
                                if(substr($value,-4) === ".zip" || substr($value,-4) === ".rar"){
                        	
                                    $ountz++;
                                    if($ountz % 3 == 0){
						        	  $retus .= "</tr><tr>";
						        	 
						        	}
                                    else{
                                     $retus.= '<td><a target="_blank" href="?download='.encrypt($filedir).'"><span class="glyphicon glyphicon-save-file"> '.$value.'</span></a></td>';
						        	}								  							  			  
						        }				
																	        
				   }
				
			 echo '
                <div class="col-lg-3 micro">			 
			        <div class="panel panel-default interior" >
                        <div class="panel-heading"><span class="glyphicon glyphicon-facetime-video"></span> Video Materials</div>
	                      <div onclick="myFunction()" style="overflow:auto;max-height:80%" id="activebtn" class="panel-body">
			               <ul class="list-group interior">'.$tr.'</ul>
		     	        </div>	
	                </div>
				</div>
				<div id="download_filem"></div>
		            <div class="col-lg-12">
                    	<div class="panel panel-default ">
                           <div class="panel-heading">Course Exercises and Materials</div>
                    	        <div style="overflow:auto;max-height:50%" class="panel-body interior">
		            	      	<table ><tr>'.$retus.'</tr></table>
		            	 </div>
		            </div>
		        </div>	
				';
			}
				

			break;
			
			case "get_video":
			
             $filesa = $_SERVER['DOCUMENT_ROOT'].'/courses/'.decrypt($_GET['item']).'/'.decrypt($_GET['id']).'/'.decrypt($_GET['specdir']) . "/".decrypt($_GET['name']);
			 $clean_name = clean_name(decrypt($_GET['name']))[1];
			 echo '					   
					<div class="panel panel-default micro">
                        <div class="panel-heading"><div style="text-align:center">'.$clean_name.'</div>
                            </div>
                               <div class="panel-body">			    
      		       		          
  			                <video class="videos" id="myVideo" controls autoplay="true" playsinline>
                                   <source src="video.php?link='.encrypt($filesa).'" type="video/mp4"> 			   
                            </video>
  			      
                        </div>                 
                    </div>';
			break;
			
			case "check_status":
			 
			  $_SESSION['watched'][] = decrypt($_GET['name']); 
			  
			break;
			
			case "header_text":
			    if(dirToArray($_SERVER['DOCUMENT_ROOT']."/courses/".decrypt($_GET['item']).'/'.decrypt($_GET['id']).'/'.decrypt($_GET['specdir']))){
		           $item  = explode("-",decrypt($_GET['specdir']));		
			  	   echo 
			  	       '						 							        
			  	   					<span class="glyphicon glyphicon-level-up"></span>'.decrypt($_GET['item']).' 
									<span class="glyphicon glyphicon-hand-right"></span> &nbsp;'.$item[1].' Course
											</span>					  										
			  	   					 <div id="loading">						 
                                              <img class="error images-loader" src="./media/blackdove_spinner.gif"></div>';
				}			  
			    break;
    }
}  
else{
    header("HTTP/2.0 404 Not Found");
}

?>

