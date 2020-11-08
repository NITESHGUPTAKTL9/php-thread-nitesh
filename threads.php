
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
$id=$_GET['catid'];
$sql="SELECT * FROM categaries WHERE categariey_id=$id";
$result = mysqli_query($conn,$sql);
   while($row=mysqli_fetch_assoc($result))
   {
     $catname=$row['categariey_name'];
     $deck=$row['categariey_description'];
   }
?>
    <?php
   
$method=$_SERVER['REQUEST_METHOD'];
if($method=='POST')
{$Sno=$_POST['Sno'];
    $th_title=$_POST['title'];
    $th_desc=$_POST['desc'];
    $th_tittle=str_replace("<","&lt;",$th_title);
    $th_title=str_replace(">","&gt;",$th_title);
    $th_desc=str_replace("<","&lt;",$th_desc);
    $th_desc=str_replace(">","&gt;",$th_desc);
    $sql="INSERT INTO `threads` ( `thread_tittle`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$Sno', current_timestamp())";
$result = mysqli_query($conn,$sql);
$showAlert=true;
if($showAlert)
{
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your data has been inserted  Successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}
}

?>
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome- <?php echo $catname;?> Forums</h1>
            <p class="lead"><?php echo $deck;?></p>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=true)
    {
   echo '<div class="container">
        <h1>Start a Discussion</h1>
        <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as
                    possible</small>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Elaborate your concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                <input type="hidden" name="Sno" value="' . $_SESSION["Sno"] . '">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    }

    else{

   echo '
   <div class="container">
   <h1>Start a Discussion</h1>
<p class="lead">You are not logged in. To start a discussion please login</p>
   </div>';
    
}
    ?>
    <div class="container my-3">
        <h3>Browse Questions</h3>

        <?php
$id=$_GET['catid'];
$sql="SELECT * FROM threads WHERE thread_cat_id=$id";
$result = mysqli_query($conn,$sql);
$noResponce=true;
   while($row=mysqli_fetch_assoc($result))
   {
     $id=$row['thread_id'];
     $threadtitle=$row['thread_tittle'];
     $threaddesc=$row['thread_desc'];
     $comment_time=$row['timestamp'];
     $thread_user_id=$row['thread_user_id'];
     $noResponce=false;
   $sql2="SELECT user_email FROM users WHERE Sno='$thread_user_id'";
   $result2 = mysqli_query($conn,$sql2);
   $row2 = mysqli_fetch_assoc($result2);
       echo '<div class="media">
            <img src="default.jpg" class="mr-3" width="100px" height="120px" alt="...">
            <div class="media-body">
                <h5 class="mt-0"><a href="threadlist.php?threadid='.$id.'">' .$threadtitle. '</a></h5>
                ' .$threaddesc. '
                <p class="font-weight-bold my-0">'.$row2['user_email'].' at '.$comment_time.'</p>
            </div>

        </div>
        <br>';
        
        }
        ?>
        <?php
        if($noResponce)
        {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">No Question Present</h1>
              <p class="lead">Be the first person to ask.</p>
            </div>
          </div>';
        }
?>
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