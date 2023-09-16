<?php
  require_once "config.php";
  $username = $password = $confirm_password = "";

  $username_err = $password_err = $confirm_password_err = "";
  //$stmt = mysqli_stmt_init($conn);
  if($_SERVER['REQUEST_METHOD']=="POST")
  {

    //Check if username is empty
    if(empty(trim($_POST["username"]))){
      $username_err = "Username cannot be blank";
    }
    else{
      $sql="SELECT id FROM users WHERE username=?"; //prepared stattements are used in php for preparing query for binding statements

    $stmt=mysqli_prepare($conn,$sql);
    if($stmt)
    {
      mysqli_stmt_bind_param($stmt,"s",$param_username);

      //set the value of param username
      $param_username=trim($_POST['username']);

    //try to execute the statement
      if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt)==1){
          $username_err="This username is already taken";
        }
        else{
          $username=trim($_POST['username']);
        }

  }
  else{
    echo "Something Went Wrong";
  }

    }
    
  }
  mysqli_stmt_close($stmt);




//check for password
if(empty(trim($_POST['password']))){
  $password_err="Password cannot be blank";
}
else if(strlen(trim($_POST['password']))<5){
  $password_err="Password cannot be less than 5 characters";
}
else{
  $password=trim($_POST['password']);
}


//check for confirm password field
if(trim($_POST['password']) != trim($_POST['confirm_password'])){
  $password_err="Passwords should match";
}


//if there were no errors go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
  $sql="INSERT INTO users (username,password) VALUES  (?,?)";
  $stmt =mysqli_prepare($conn,$sql);

if($stmt){
  
  mysqli_stmt_bind_param($stmt,"ss",$param_username,$param_password);
  //set these parameters
  $param_username=$username;
  $param_password= password_hash($password,PASSWORD_DEFAULT);

  


  //try to execute the query
  if(mysqli_stmt_execute($stmt))
  {
    header("location:login.php");
  }
  else{
    echo "Something went wrong..... Cannot redirect!";
  }
}
mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}
?>




<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Login System!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>

      </ul>
    </div>
  </div>
</nav>


<div class="container mt-4">
<h2>Registration Form </h2>
<hr>
<form class="row g-3" action="" method="Post">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label" >Username</label>
    <input type="text" class="form-control" id="inputEmail4" name="username" placeholder="Username">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label" >Password</label>
    <input type="password" class="form-control" id="inputPassword4" name="password" placeholder="Password">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label" >Confirm Password</label>
    <input type="password" class="form-control" id="inputPassword" name="confirm_password" placeholder="Confirm Password">
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Address</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-6">
    <label for="inputCity" class="form-label">City</label>
    <input type="text" class="form-control" id="inputCity">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">State</label>
    <select id="inputState" class="form-select">
      <option selected>Choose...</option>
      <option>...</option>
    </select>
  </div>
  <div class="col-md-2">
    <label for="inputZip" class="form-label">Zip</label>
    <input type="text" class="form-control" id="inputZip">
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Sign in</button>
  </div>
</form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>