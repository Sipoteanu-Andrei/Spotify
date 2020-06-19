<?php
if(isset($_POST['Sign_In'])){

	require 'dbh.inc.php';

	$username =$_POST['uid'];
	$email =$_POST['mail'];
	$password =$_POST['pwd'];
	$passwordRepet =$_POST['pwd-repeat'];

	if(empty($username)|| empty($email)|| empty($password)|| empty($passwordRepet)){
		header("Location: ../Register.html?error=emptyfields&uid=".$username."&email=".$email);
		exit();
	}
  	else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) ){
		header("Location: ../Register.html?error=invalidmail&uid");
		exit();
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		header("Location: ../Register.hmtl?error=invalidmail&uid=".$username);
		exit();
	}
	else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
		header("Location: ../Register.html?error=invaliduaid&maild=".$mail);
		exit();
	}
	else if($password !== $passwordRepet){
		header("Location: ../Register.html?error=emptyfields&uid=".$username."&email=".$email);
		exit();
	}
	else {

		$sql ="SELECT uidUsers FROM users WHERE uidUsers=?";
		$stmt =mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../Register.html?error=sqlerror");
		exit();
		}
		else {
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);
			if($resultCheck>0){
				header("Location: ../Register.html?error=usertaken");
				exit();
			}
			else{
				$sql = " INSERT INTO users (uidUsers,emailUsers,pwdUsers) VALUES(?,?,?)";
				$stmt =mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../Register.html?error=sqlerror");
			exit();
		}
		else{
			mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
			mysqli_stmt_execute($stmt);
			header("Location: ../Login.html?Register=success");
			exit();

		}
	  }
	}
  }

	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else{
	header("Location: ../Register.html");
			exit();
}
