<?php
if(isset($_POST['Log_in'])){
  require 'dbh.inc.php';

  $username=$_POST['uid'];
  $password=$_POST['pwd'];

  if(empty($username)||empty($password)){
    header("Location: ../Login.html?error=emptyfields");
        exit();
  }
  else{
    $sql = "SELECT * FROM users where uidUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location: ../Login.html?error=sqlerror");
          exit();
    }
    else{
      mysqli_stmt_bind_param($stmt,"s",$username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if($row = mysqli_fetch_assoc($result)) {
         $pwdCheck = password_verify($password, $row['passwd_users']);
         if($pwdCheck == true){
           header("Location: ../Login.html?error=wrongpwd");
               exit();
         }
         else if($pwdCheck == false){
           $_SESSION['userId'] = $row['idUsers'];
           $_SESSION['userName'] = $row['uidUsers'];

           header("Location: ../Main.php?login=success");
               exit();
         }
         else{
        header("Location: ../Login.html?error=no-user");
            exit();
      }

    }
  }
}
}
else{
  header("Location: ../Login.html");
      exit();
}
