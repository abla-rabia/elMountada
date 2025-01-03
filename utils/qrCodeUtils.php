<?php
require_once(ROOT . '/phpqrcode/qrlib.php');
class qrGenerator{
function generateQrCode($idMembre, $idTypeCarte) {
    $data = json_encode([
        'id_membre' => $idMembre,
        'id_type_carte' => $idTypeCarte
    ]);
    $filePath = "qrcodes/membre_{$idMembre}.png";    
    if (!file_exists('qrcodes')) {
        mkdir('qrcodes', 0777, true);
    }
    QRcode::png($data, $filePath, QR_ECLEVEL_L, 10);

    return $filePath;
}
}

?>