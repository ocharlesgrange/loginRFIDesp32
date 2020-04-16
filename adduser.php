<?php
require_once 'class/pdodb.class.php';
$usuario = $_POST['usuario'];
$pass = $_POST['senha'];
$cargo = $_POST['cargo'];
$codigorfid = $_POST['rfidcodigo'];
$db = Database::conexao();
if ($codigorfid == "") {
    $procurarRFID = $db->prepare("SELECT * FROM rfid_search WHERE status = 'notused'");
    $procurarRFID->execute();
    $rfidBRUTO = $procurarRFID->fetchAll(PDO::FETCH_ASSOC);
    if ($procurarRFID->rowCount() == 0) {
        echo "needinsert_rfid";
        exit;
    } else {
        $rfid = $rfidBRUTO[0]['rfidsearch'];
        $inserirUsuario = $db->prepare("INSERT INTO usuarios (user, pass, id_rfid, cargo) VALUES ('$usuario', '$pass', '$rfid', 'Administrador')");
        $inserirUsuario->execute();
        $mudarStatus = $db->prepare("UPDATE rfid_search SET status = 'used' WHERE rfidsearch = '$rfid' AND status = 'notused'");
        $mudarStatus->execute();
        echo "USER_CRIADO_RFID";
        exit;
    }
} else {
    $inserirUsuario = $db->prepare("INSERT INTO usuarios (user, pass, id_rfid, cargo) VALUES ('$usuario', '$pass', '$codigorfid', 'Administrador')");
    $inserirUsuario->execute();
    echo "USER_CRIADO_NORMAL";
    exit;
}
?>