<?php
//le controlleur pour gerer les evennement et les activités
require_once(ROOT . '/Model/EventAnnonceModel.php');
require_once(ROOT . '/View/adminEventsView.php');
require_once(ROOT . '/View/evenementView.php');
require_once(ROOT . '/View/adminActivitiesView.php');
class EventAnnonceController{



    public function afficherPageAdminEvents(){
        $view = new adminEventsView();
        
        $view->afficher_page();
    }
    public function afficherPageAdminActivites(){
        $view = new adminActivitiesView();
        
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

public function getEventsActivities() {
    $r = new EventAnnonceModel();
    $events = $r->getEventsActivities();
    header('Content-Type: application/json');
    echo json_encode($events);
}
public function addActivite() {
    $r = new EventAnnonceModel();
    $credentials = [
        'nom' => $_POST['nom'],
        'description' => $_POST['description'],
        'photo' => $this->uploadPhoto('photo'),
        'date_activite' => $_POST['date_activite']
    ];

    foreach ($credentials as $key => $value) {
        if (empty($value)) {
            return 3;
        }
    }

    if (!($resul = $r->problemAddActivite($credentials))) {
        $r->addActivite($credentials);
        echo 1;
    } else {
        return $resul;
    }
}

public function getActivites() {
    $r = new EventAnnonceModel();
    $activites = $r->getActivites();
    header('Content-Type: application/json');
    echo json_encode($activites);
}
public function getEvents() {
    $r = new EventAnnonceModel();
    $activites = $r->getEvents();
    header('Content-Type: application/json');
    echo json_encode($activites);
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
        'id_user' => $_SESSION['user']['id'] ?? $_SESSION['member']['id'] ?? $_SESSION['admin']['id'] ?? null,
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
public function addBenevoleActivite(){
    $r = new EventAnnonceModel();
    $credentials = [
        'id_user' => $_SESSION['user']['id'] ?? $_SESSION['member']['id'] ?? $_SESSION['admin']['id'] ?? null,
        'id_activite' => $_POST['id']
    ];

    foreach ($credentials as $key => $value) {
        if (empty($value)) {
            return 3;
        }
    }
    $r->addBenevoleActivite($credentials);
    echo 1;
}
public function afficherPageEvenement() {
    $view = new evenementView();
    $view->afficher_page();
}
}
?>