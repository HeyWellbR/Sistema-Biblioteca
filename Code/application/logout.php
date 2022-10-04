<?PHP
session_start();
session_destroy();
header('LOCATION: ../index.php');
   
?>