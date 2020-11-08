<?php
$showerror="false";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    include '_dbconnect.php';
    $email=$_POST['loginemail'];
    $pass=$_POST['loginpassword'];
    $sql="select * from users where user_email='$email'";
    $result=mysqli_query($conn,$sql);
    $numrow=mysqli_num_rows($result);
    if($numrow==1)
    {
        $num=mysqli_fetch_assoc($result);
        if(password_verify($pass,$num['user_pass']))
        {
        session_start();
        $_SESSION['loggedin']=true;
        $_SESSION['useremail']=$email;
        $_SESSION['Sno']=$num['Sno'];
        header("Location:/forums/index.php");
        exit();
        }
        
            header("Location:/forums/index.php?loginsuccess=true");
        
    }
    header("Location:/forums/index.php?loginsuccess=true");
}


?>