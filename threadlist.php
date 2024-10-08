<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iShare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
    #ques {
        /* min-height: 400px; */
    }
    </style>
</head>

<body>
    <?php
    include 'partials/_header.php';
    ?>
    <?php
    include 'partials/_dbconnect.php';
    ?>

    <?php
    $id = $_GET['catid'];
    $sql = " SELECT * FROM `categories` WHERE category_id=$id"; 
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $catn = $row['category_name'];
        $catd = $row['category_description'];
    } 
    ?>

    <?php
    $showalert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        $sno = $_SESSION['sno'];
        $th_title = $_POST['title'];
        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title); 

        $th_desc = $_POST['desc'];
        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc); 
        $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ( '$th_title', '$th_desc ', '$id', '$sno', current_timestamp())"; 
        //default thread_user_id was 0 
    $result = mysqli_query($conn, $sql);
    $showalert = true;
    if($showalert){
        echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successfull!</strong>Thread added successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    } 
    ?>

    <div class="container my-4">
        <div class="p-3 mb-2 bg-dark text-white opacity-75" style="width: 64rem; margin: auto; border-radius:10px;">
            <h1 class="display-6 bg-dark">Welcome to <?php echo $catn; ?> forum</h1>
            <p class="lead">
                <?php echo $catd; ?>
            </p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge. You are warned not to use foul language which may
                offend others, not to advertise, not to spam messages.Your activity is being monitored.</p>
            <!-- <a href="" class="btn btn-success btn-lg" role="button">Learn more</a> -->
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo  '<div class="container my-4" style="width: 1030px; margin:auto;">
        <h3>Start a discussion</h3>
        <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Thread title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible.</div>
            </div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="desc" style="height: 100px"
                    name="desc"></textarea>
                <label for="desc">Elaborate your concern</label>
            </div>
            <button type="submit" class="btn btn-success my-2">Submit</button>
        </form>
    </div>';
    }
    else{
        echo '
        <div class="container bg-danger bg-gradient" style="width: 63.5rem; margin: auto; padding:5px; margin-bottom:12px; font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande", "Lucida Sans Unicode", Geneva, Verdana, sans-serif;" >
        <h3>Login to continue with the discussions</h3>
    </div>
        ';
    }
    ?>



    <div class="container" id="ques" style="width: 64rem; margin: auto;">
        <h1 class="py-1">Browse questions</h1>
        <hr>

        <?php
                $id = $_GET['catid'];
                $sql = " SELECT * FROM `threads` WHERE thread_cat_id=$id"; 
                $result = mysqli_query($conn, $sql);
                $noresult = true;
                while($row = mysqli_fetch_assoc($result)){
                    $noresult = false;
                    $title = $row['thread_title'];
                    $desc = $row['thread_desc'];
                    $id = $row['thread_id'];
                    $thread_time = $row['timestamp'];
                    $thread_user_id=$row['thread_user_id'];
                    $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                   
               

       echo  '<div class="my-3">                  
       <p class="font-weight-bold"  style="font-weight:bold;"> '.$row2['user_email'].' | '.$thread_time.'</p>
            <img src="img/userdef.png" width="32px" class="mr-4" alt="" style="display: inline;">
           
            <h5 class="mt-0 mx-2" style="display: inline;"><a class="text-dark" style="text-decoration:none;" href="thread.php?threadid='.$id.'">'.$title.'</a></h5>
            <div class="mt-0" style="margin-left: 44px;">
                '.$desc.'
            </div>
            
            <hr>
        </div>';

    }  
    if($noresult){
        // echo "<b> Be the first person to ask a question </b>";
        
        echo    '<div class="jumbotron my-2 jumbotro-fluid py-2 bg-secondary bg-gradient" style="border-radius: 15px;">
        <div class="container">
        <h1 class="display-6">Nothing till now</h1>
        <p class="lead"><b>Be the first person to ask a question</b> </p>
        </div>
        </div>';
    }

    ?>
    </div>




    <?php
    include 'partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
        integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous">
    </script>
</body>

</html>