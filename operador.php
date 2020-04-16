<?php
session_start();
require_once ("class/pdodb.class.php");
date_default_timezone_set('America/Sao_Paulo');
$usuario = addslashes($_POST['usuario']);
$senha = addslashes($_POST['senha']);
$db = Database::conexao();
$consultaUser = $db->prepare("SELECT * FROM usuarios WHERE user = '$usuario' AND pass = '$senha'");
$consultaUser->execute();
if ($consultaUser->rowCount() > 0) {
    $infos_user = $consultaUser->fetchAll(PDO::FETCH_ASSOC);
    foreach ($infos_user as $infos) {
        $user = $infos['user'];
        $cargo = $infos['cargo'];
        $rfid = $infos['id_rfid'];
    }
    $_SESSION['usuario'] = $user;
    $_SESSION['cargo'] = $cargo;
    $_SESSION['rfid_id'] = $rfid;
    $verifRFID = $db->prepare("SELECT * FROM rfid_req WHERE id_rfid = '$rfid' AND status = 'waiting'");
    $verifRFID->execute();
    if ($verifRFID->rowCount() > 0) {
        $data = date('d/m/Y H:i:s');
        $irradicar = $db->prepare("UPDATE rfid_req SET status = 'try', hourtime = '$data' WHERE id_rfid = '$rfid' AND status = 'waiting'");
        $irradicar->execute();
        $consultarAc = $db->prepare("INSERT INTO rfid_req (id_rfid, status, hourtime) VALUES ('$rfid', 'waiting', '$data')");
        $consultarAc->execute();
    } else {
        $data = date('d/m/Y H:i:s');
        $consultarAc = $db->prepare("INSERT INTO rfid_req (id_rfid, status, hourtime) VALUES ('$rfid', 'waiting', '$data')");
        $consultarAc->execute();
    }
    echo "LOGIN_OK";
} else {
    echo "LOGIN_ERROR";
}
?>