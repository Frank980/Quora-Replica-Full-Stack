<?php
    $showerror = "false";
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        include '_dbconnect.php';
        $email = $_POST['loginemail'];
        $email = str_replace("<", "&lt;", $email);
        $email = str_replace(">", "&gt;", $email); 

        $pass = $_POST['loginpass'];
        $pass = str_replace("<", "&lt;", $pass);
        $pass = str_replace(">", "&gt;", $pass); 

        $sql = "SELECT * FROM `users` WHERE user_email='$email'";
        $result = mysqli_query($conn, $sql);
        $numrows = mysqli_num_rows($result);
        if($numrows==1){
            $row = mysqli_fetch_assoc($result);
                if(password_verify($pass, $row['user_pass'])){
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['useremail'] = $email;
                    $_SESSION['sno'] = $row['sno'];
                    echo "logged in". $email;
                    header("Location: /FCC/index.php?loginsuccessfull=true");
                }            
                else{
                    header("Location: /FCC/index.php?loginsuccessfull=false");
                }    // header("Location: /Forum/index.php");
                    
                }
                else{
                    header("Location: /FCC/index.php?loginsuccessfull=false");
                }
               
            }
?>