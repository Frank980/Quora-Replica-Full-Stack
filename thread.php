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
        min-height: 400px;
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
    $id = $_GET['threadid'];
    $sql = " SELECT * FROM `threads` WHERE thread_id=$id"; 
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
    }
   
    ?>

<?php
    $showalert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        $sno = $_SESSION['sno'];
        $comment = $_POST['comment'];
        $comment = str_replace("<", "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment);    
        $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ( '$comment', '$id', '$sno', current_timestamp())"; 
    $result = mysqli_query($conn, $sql);
    $showalert = true;
    if($showalert){
        echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successfull!</strong>Comment added.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    } 
    ?>

    <div class="container my-4">
        <div class="p-3 mb-2 bg-dark text-white" style="width: 64rem; margin: auto;">
            <h1 class="display-6 bg-dark"><?php echo $title; ?> </h1>
            <p class="lead">
                <?php echo $desc; ?>
            </p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge. You are warned not to use foul language which may
                offend others, not to advertise, not to spam messages.Your activity is being monitored.</p>
            <p><b>Posted by: Harry</b></p>
        </div>
    </div>
    
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo  '<div class="container my-4" style="width: 1030px; margin:auto;">
    <h3>Post a Comment</h3>
    <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="comment" style="height: 90px"
                name="comment"></textarea>
            <label for="desc">Type here</label>
        </div>
        <button type="submit" class="btn btn-success my-2">Post Comment</button>
    </form>
</div>'
;
    }
    else{
        echo '
        <div class="container" style="width: 64rem; margin: auto; border: 2px solid black; background-color:red; border-radius: 10px; padding-top:5px; margin-bottom:12px; box-shadow: 3px 4px 3px black;" >
        <h3>Login to continue with the discussions</h3>
    </div>
        ';
    }
    ?>








    <!-- <div class="container my-4" style="width: 1030px; margin:auto;">
        <h3>Post a Comment</h3>
        <form action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="comment" style="height: 90px"
                    name="comment"></textarea>
                <label for="desc">Type here</label>
            </div>
            <button type="submit" class="btn btn-success my-2">Post Comment</button>
        </form>
    </div> -->


    <div class="container" id="ques" style="width: 64rem; margin: auto;">
        <h2 class="py-0">Discussions</h2>

        <?php
        $noresult = true;
                $id = $_GET['threadid'];
                $sql = " SELECT * FROM `comments` WHERE thread_id=$id"; 
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                    $noresult = false;
                    $content = $row['comment_content'];
                    $id = $row['comment_id'];
                    $comment_time = $row['comment_time'];
                    $thread_user_id=$row['comment_by'];
                    $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    $comby = $row2['user_email'];
               

       echo  '<div class="my-3">
            <img src="img/userdef.png" width="33px"  class="mx-2" alt="" style="display: inline-block; float:left; padding-right:2px;">
            <p class="font-weight-bold"  style="font-weight:bold;">'.$comby.' | '.$comment_time.'</p>
            <div class="my-0 " style="margin-left: 50px;">
                '.$content.'
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