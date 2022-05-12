<?php
include("config.php");

if(isset($_POST['btnlogin'])){
    $email=$_POST["email"];
    $password=$_POST["password"];

    $sql="select * from test1 where email='".$email."' AND password='".$password."' ";

    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_array($result);


    if($row["designation"]=="student")
    {
        $_SESSION['student_id'] = $row["id"];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] =$row['designation'];
        header("location:stu_exam.php");
    }
    elseif($row["designation"]=="teacher")
    {
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] =$row['designation'];
        header("location:paper.php");
    }
    else{
        echo "incorrect";
    }
}

?>
