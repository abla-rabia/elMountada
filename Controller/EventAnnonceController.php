<?php

require_once(ROOT . '/Model/EventAnnonceModel.php');
require_once(ROOT . '/View/adminEventsView.php');
require_once(ROOT . '/View/evenementView.php');
class EventAnnonceController{



    public function afficherPageAdminEvents(){
        $view = new adminEventsView();
        
        $view->afficher_page();
    }
public function addEvent() {
    $r = new EventAnnonceModel();
    $credentials = [
        'nom' => $_POST['nom'],
        'description' => $_POST['description'],
        'photo' => $this->uploadPhoto('photo'),
        'date_event' => $_POST['date_event']
    ];

    foreach ($credentials as $key => $value) {
        if (empty($value)) {
            
            return 3;
        }
    }

    

    if (!($resul = $r->problemAddEvent($credentials))) {
        $r->addEvent($credentials);
        echo 1;
    } else {
        return $resul;
    }
}

public function getEvents() {
    $r = new EventAnnonceModel();
    $events = $r->getEvents();
    header('Content-Type: application/json');
    echo json_encode($events);
}


private function uploadPhoto($name) {
    if (isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
        $targetDir = 'uploads/';
        $targetFile = $targetDir . basename($_FILES[$name]['name']);
        move_uploaded_file($_FILES[$name]['tmp_name'], $targetFile);
        return $targetFile;
    }
    return null;
}

public function addBenevole(){
    $r = new EventAnnonceModel();
    $credentials = [
        'id_user' => $_SESSION['user']['id'] ?? $_SESSION['member']['id'] ?? null,
        'id_event' => $_POST['id']
    ];

    foreach ($credentials as $key => $value) {
        if (empty($value)) {
            return 3;
        }
    }
    $r->addBenevole($credentials);
    echo 1;
}
public function afficherPageEvenement() {
    $view = new evenementView();
    $view->afficher_page();
}
}
?>