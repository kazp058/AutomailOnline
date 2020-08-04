<?php
if(isset($_POST['search-submit'])){
  require 'dbh.inc.php';

  $key = $_POST['key'];

  if(empty($key)){
    header("Location: ../certificates.php?error=emptyfields");
    exit();
  }
  else{
    $sql = "SELECT * FROM certs WHERE key=?;";
    $stmt = mysqli_stmt_init($conn_certs);

    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../certificates.php?error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "s", $key);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if($row = mysqli_fetch_assoc($stmt)){
        header("Location: ../viewcertificate.php?");
        exit();
      }else{
        header("Location: ../certificates.php?error=nocert");
        exit();
      }
    }
  }
}else{
  header("Location: ../certificates.php");
  exit();
}
