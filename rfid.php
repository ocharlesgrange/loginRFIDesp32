<?php
require_once 'class/pdodb.class.php';
date_default_timezone_set('America/Sao_Paulo');
$acao = $_GET['acao'];
if ($acao == "access") {
    $rfid = $_GET['rfid'];
    function AtualizarRFID($rfid, $newstatus) {
        if ($newstatus == "approved") {
            $dbb = Database::conexao();
            $atualizarStatus = $dbb->prepare("UPDATE rfid_req SET status = '$newstatus' WHERE id_rfid = '$rfid' AND status = 'waiting'");
            $atualizarStatus->execute();
        }
    }
    $conexaoDB = Database::conexao();
    $consultarCredencial = $conexaoDB->prepare("SELECT * FROM usuarios WHERE id_rfid = '$rfid'");
    $consultarCredencial->execute();
    $verificarNovo = $conexaoDB->prepare("SELECT * FROM rfid_search WHERE status = 'notused'");
    $verificarNovo->execute();
    if (($consultarCredencial->rowCount() == 0) && ($verificarNovo->rowCount() == 0)) {
        $data = date('d/m/Y H:i:s');
        $inserirNova = $conexaoDB->prepare("INSERT INTO rfid_search (rfidsearch, hourtime, status) VALUES ('$rfid', '$data', 'notused')");
        $inserirNova->execute();
        echo "credential_insert";
        exit;
    }
    $db = Database::conexao();
    $consultaRFID = $db->prepare("SELECT * FROM rfid_req WHERE id_rfid = '$rfid' AND status = 'waiting'");
    $consultaRFID->execute();
    if ($consultaRFID->rowCount() == 0) {
        echo "error_access";
    } else {
        AtualizarRFID($rfid, "approved");
        echo "ok_access";
    }
} elseif ($acao == "include") {
    $rfid = $_GET['rfid'];
    $cons = Database::conexao();
    $verifRFID = $cons->prepare("SELECT * FROM rfid_req WHERE id_rfid = '$rfid' AND status = 'waiting'");
    $verifRFID->execute();
    if ($verifRFID->rowCount() > 0) {
        echo "error_insert";
    } else {
        $consultarAc = $cons->prepare("INSERT INTO rfid_req (id_rfid, status) VALUES ('$rfid', 'waiting')");
        $consultarAc->execute();
        echo "ok_insert";
    }
} elseif ($acao == "search") {
    $login = $_GET['login'];
    $const = Database::conexao();
    $buscarRFID = $const->prepare("SELECT * FROM usuarios WHERE user = '$login'");
    $buscarRFID->execute();
    $rfidBRUTO = $buscarRFID->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rfidBRUTO as $row) {
        $rfid = $row['id_rfid'];
    }
    $verificarAcesso = $const->prepare("SELECT * FROM rfid_req WHERE id_rfid = '$rfid' AND status = 'approved'");
    $verificarAcesso->execute();
    if ($verificarAcesso->rowCount() > 0) {
        $data = date('d/m/Y H:i:s');
        $atualizarStatus = $const->prepare("UPDATE rfid_req SET status = 'done', hourtime = '$data' WHERE id_rfid = '$rfid' AND status = 'approved'");
        $atualizarStatus->execute();
        echo "OKs";
    }
}
?>