<?php  
  include 'config.php';

  //db configuration
  $dns= 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
  $options=[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ];

  try{
    $pdo = new PDO($dns, DB_USER, DB_PASS, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
  }
?>