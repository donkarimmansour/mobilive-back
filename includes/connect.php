<?php 
     
    header("Content-Type: text/html;charset=UTF-8");
    

    $Cdbname = "mobilive" ;
    $Chost = "localhost" ;
    $Cusername = "root" ;
    $Cpassword = "" ; 
 

    $Coption = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"
        );
    
    try{
    
        $db = new PDO("mysql:dbname={$Cdbname};host={$Chost}",$Cusername,$Cpassword,$Coption);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
       
    }
    catch(PDOExeption $e){
        echo $e.getMessage();
       

    }
    

?>