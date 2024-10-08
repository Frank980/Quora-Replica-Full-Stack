<?php
$substr = "@iith";
$showerror = "false";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    include '_dbconnect.php';
    $user_email = $_POST['signupemail'];
    $user_email = str_replace("<", "&lt;", $user_email);
    $user_email = str_replace(">", "&gt;", $user_email); 

    $pass = $_POST['signuppassword'];
    $pass = str_replace("<", "&lt;", $pass);
    $pass = str_replace(">", "&gt;", $pass); 

    $cpass = $_POST['signupcpassword'];
    $cpass = str_replace("<", "&lt;", $cpass);
    $cpass = str_replace(">", "&gt;", $cpass); 

    //checking if the username already exists
    $existsql = "SELECT * from `users` WHERE user_email='$user_email'";
    $result = mysqli_query($conn, $existsql);
    $numrows = mysqli_num_rows($result);
    if($numrows > 0){
        $showerror = "Email already in use";
    }
    else{
        if($pass == $cpass && strpos($user_email, $substr) !== false){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if($result){
                $showalert = true;
                header("Location: /FCC/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showerror = "Passwords do not match or institute mail id not used";
           
        }        
}
header("Location: /FCC/index.php?signupsuccess=false&error=$showerror");
}
?>
