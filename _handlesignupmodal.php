<?php
$showerror="false";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    include '_dbconnect.php';
    $user_email=$_POST['signupemail'];
    $pass=$_POST['signuppassword'];
    $cpass=$_POST['signupcpassword'];
$existsql="select * from users where user_email='$user_email'";
$result=mysqli_query($conn,$existsql);
$numrow=mysqli_num_rows($result);
if($numrow>0)
{
  $showerror="Email IS Already Exists";
}
else
{
    if($pass==$cpass)
    {   $hash=password_hash($pass,PASSWORD_DEFAULT);
        $sql="INSERT INTO users (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
        $result=mysqli_query($conn,$sql);
       
        if($result)
        {
            $showAlert=true;
            header("location:/forums/index.php?signupsuccess=true");
            exit();
        }
    }
    else{
        $showerror="Passwords do not match";
        
    }
}
            header("location:/forums/index.php?signupsuccess=false&error=$showerror");
              $showerror=true;
}
?>