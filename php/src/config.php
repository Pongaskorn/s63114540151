<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database (PostgreSQL)
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'PuneethReddy');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'ecommerece');

$conn_string = "host=" . DB_SERVER . " dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
$db = pg_connect($conn_string);

if (!$db) {
    die("❌ Connection failed: " . pg_last_error());
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username   = pg_escape_string($db, $_POST['username']);
  $email      = pg_escape_string($db, $_POST['email']);
  $password_1 = pg_escape_string($db, $_POST['password_1']);
  $password_2 = pg_escape_string($db, $_POST['password_2']);

  // form validation
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
  }

  // check if user already exists
  $user_check_query = "SELECT * FROM register WHERE Name='$username' OR email='$email' LIMIT 1";
  $result = pg_query($db, $user_check_query);
  $user   = pg_fetch_assoc($result);

  if ($user) { 
    if ($user['name'] === $username) {
      array_push($errors, "Username already exists");
    }
    if ($user['email'] === $email) {
      array_push($errors, "Email already exists");
    }
  }

  // register user
  if (count($errors) == 0) {
    $password = md5($password_1); // encrypt password

    $query = "INSERT INTO register (Name, email, password) 
              VALUES('$username', '$email', '$password')";
    pg_query($db, $query);

    $_SESSION['Name'] = $username;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = pg_escape_string($db, $_POST['email']);
  $password = pg_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Email is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM register WHERE email='$username' AND password='$password'";
    $results = pg_query($db, $query);

    if (pg_num_rows($results) == 1) {
      $_SESSION['email'] = $username;
      $_SESSION['success'] = "You are now logged in";
      header('location: index.php');
    } else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}
?>
