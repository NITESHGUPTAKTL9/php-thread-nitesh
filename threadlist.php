<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>iDiscuss - Coding Forums</title>
</head>
<style>
.footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    text-align: center;
}
</style>

<body>
<?php include '_dbconnect.php'; ?>
    <?php include 'header.php';  ?>
    
   

    <?php
$id=$_GET['threadid'];
$sql="SELECT * FROM threads WHERE thread_id = $id";
$result = mysqli_query($conn,$sql);
   while($row=mysqli_fetch_assoc($result))
   {
     $threadtitle=$row['thread_tittle'];
     $threaddesc=$row['thread_desc'];
     $commentedby=$row['thread_user_id'];
     $sql2="SELECT user_email FROM users WHERE Sno='$commentedby'";
     $result2 = mysqli_query($conn,$sql2);
     $row2 = mysqli_fetch_assoc($result2);
     $posted_by =$row2['user_email'];

   }
   ?>
   <?php
   $id=$_GET['threadid'];
   $method=$_SERVER['REQUEST_METHOD'];
   if($method=='POST')
   {    $Sno=$_POST['Sno'];
       $content=$_POST['comment'];
       $content=str_replace("<","&lt;",$content);
       $content=str_replace(">","&gt;",$content);
       $sql="INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ( '$content', '$id', '$Sno', current_timestamp())";
   $result = mysqli_query($conn,$sql);
   $showAlert=true;
   if($showAlert)
   {
       echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
       <strong>Success!</strong> Your comment has been posted  Successfully.
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>';
   }
   }
   
   ?>
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome- <?php echo $threadtitle; ?> Forums</h1>
            <p class="lead"><? echo $threaddesc; ?></p>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
            <p>Posted by : <em><?php echo $posted_by;?></em></p>
        </div>
    </div>
   
   
   <?php
   if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=true)
   {
      echo '<div class="container">
        <h1>Post your comment</h1>
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
           
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type Your Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="Sno" value="' . $_SESSION["Sno"] . '">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>
    </br>';
   }
   else{
    echo '
    <div class="container">
    <h1>Post your comment</h1>
 <p class="lead">You are not logged in. To post a comment please login</p>
    </div>';
   }
    ?>

    <div class="container">
    <h3>Discussions</h3>
    
    
    <?php

$sql="SELECT * FROM comments WHERE thread_id=$id";
$result = mysqli_query($conn,$sql);
$noResponce=true;
   while($row=mysqli_fetch_assoc($result))
   {
     $id=$row['comment_id'];
     $comment=$row['comment_content'];
     $noResponce=false;
     $comment_time=$row['comment_time'];
     $thread_user_id=$row['comment_by'];
     $sql2="SELECT user_email FROM users WHERE Sno='$thread_user_id'";
     $result2 = mysqli_query($conn,$sql2);
     $row2 = mysqli_fetch_assoc($result2);
       echo '<div class="media">
            <img src="default.jpg" class="mr-3" width="100px" height="120px" alt="...">
            <div class="media-body">
            <p class="font-weight-bold my-0">'.$row2['user_email'].' at '.$comment_time.'</p>
                ' .$comment. '
            </div>
        </div>';
        
        }
        ?>
        <?php
        if($noResponce)
        {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">No Comments Present</h1>
              <p class="lead">Be the first person to post.</p>
            </div>
          </div>';
        }
?>
</div>

    </br></br>
        <?php include 'footer.php';  ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
            integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
        </script>
</body>

</html>