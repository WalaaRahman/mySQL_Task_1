<?php

function clean($input){

    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = trim($input);

    return $input;

}

function validate($input,$flag,$minlength = 6,$maxlength=1000){
   
    $status = true;

    switch ($flag) {
        case 'empty':
            # code...
            if(empty($input)){
                $status = false;
            }
            break;
        case 'string':
            #code... 
            if(!is_string($input)){
                $status = false;
            }   

        case 'email': 
            # code ... 
             if(!filter_var($input,FILTER_VALIDATE_EMAIL)){
                $status = false;
             }
            break;
        
        case 'size': 
            #code ... 
            if(strlen($input) < $minlength || strlen($input) > $maxlength ){
                $status = false;
            }    
            break;

        case 'url': 
            #code ... 
            if(!filter_var($input,FILTER_VALIDATE_URL)){
                $status = false;
            }    
            break;
    }
    return $status;

}


?>