
 <?php  

require './helpers/dbConnection.php';
require './helpers/validator.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

$title     =  clean($_POST['title']); 
$content   =  clean($_POST['content']);

// var_dump($title);
// var_dump($content);
// var_dump($_FILES['photo']['type']);

// exit();


   $errors = [];
  # Title Validation ... 

  if(!validate($title,'empty')){
     $errors['Title'] = "Field Required";
  }elseif(validate($title,'string')){
      $errors['Title'] = "Title Must be String !!";
  }

  # Content Validation ... 
  if(!validate($content,'empty')){
      $errors['Content'] = "Field Required";
  }elseif(!validate($content,'size',50) ){
      $errors['Content'] = "Content Length Must >= 50 ch";
  }

  # Photo Validation ... 
  if(!empty($_FILES['photo']['name'])){
        $photoTmp=$_FILES['photo']['tmp_name'];
        $photoName=$_FILES['photo']['name'];
        $photoSize=$_FILES['photo']['size'];
        $photoType=$_FILES['photo']['type'];

        $allowedEx=['png','jpg','jpeg'];

        $typeArray = explode('/',$photoType);
        
        if(in_array($typeArray[1],$allowedEx)){

            $photoName=rand(1,20).time().'.'.$typeArray[1];
            $destination='./uploads/'.$photoName;

            if(move_uploaded_file($photoTmp,$destination)){
                echo "Photo Uploaded successfully".'<br>';
            }
            else{
                $errors['Photo'] = "* Error uploading photo";
            }



        }
        else{
            $errors['Photo'] = "* NOT Allowed Extension";

        }
    }
    else{
        $errors['Photo']="* Photo is Required";
    }

    




  if(count($errors) > 0){
      foreach($errors as $key => $val ){
          echo '* '.$key.' :  '.$val.'<br>';
      }
  }else{

    // echo "title"." : ".$title;
    // echo "content"." : ".$content;
    // echo "photo"." : ".$photoName;

    // exit();
      
     // db code .... 

     $sql = "insert into articale (title,content,photo) values ('$title','$content','$photoName')";
     $operation =mysqli_query($connection,$sql);
    //  var_dump($sql);

    //  var_dump($operation);
    //  exit();

     if($operation){
         echo 'Data Inserted';
     }else{
         echo 'Error Inserting Data.. Try Again';
     }
     # close connection ... 
     mysqli_close($connection);

     }
}




?>




<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Articale</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data">



            <div class="form-group">
                <label for="exampleInputEmail1">Title</label>
                <input type="text" name="title" class="form-control" id="exampleInputName" aria-describedby=""
                    placeholder="Enter Title">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail1">Content</label>
                <input type="text" name="content" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Enter Content">
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo">
            </div>    

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>
