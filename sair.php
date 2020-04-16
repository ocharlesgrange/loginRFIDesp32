<?php
session_start();
unset($_SESSION['usuario']);
unset($_SESSION['cargo']);
unset($_SESSION['rfid_id']);
session_destroy();
session_write_close();
header("Location: login.php");
?>