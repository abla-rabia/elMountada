<?php
require_once(ROOT . '/Controller/donsBenevolatsAidesController.php');
require_once(ROOT . '/Controller/EventAnnonceController.php');
class EventAnnonceModel{
    public function problemAddEvent($credentials){
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "SELECT * FROM events WHERE nom = :nom";
            $res = $r->query($pdo, $qtf, ['nom' => $credentials['nom']]);
            if ($res->rowCount() > 0) {
                $r->deconnexion($pdo);
                return "The event already exists";
            }
    
            $r->deconnexion($pdo);
            return false; // everything is good
        }
        return true; // case where the user has not entered anything ...
    }
    
    public function addEvent($credentials) {
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "INSERT INTO events (nom, `description`, date_event, photo) VALUES (:nom, :description, :date_event, :photo)";
            $params = [
            'nom' => $credentials['nom'],
            'description' => $credentials['description'],
            'date_event' => $credentials['date_event'],
            'photo' => $credentials['photo']
            ];
            $res = $r->query($pdo, $qtf, $params);
            $r->deconnexion($pdo);
        }
    }

    public function getEvents() {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT * FROM events";
        $stmt = $r->query($pdo, $qtf, []);
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $r->deconnexion($pdo);
        return $events;
    }
    
    public function getEventsActivities() {
        $events = $this->getEvents();
        $activities = $this->getActivites();
        return [
            'events' => $events,
            'activities' => $activities
        ];
    }
    public function problemAddActivite($credentials){
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "SELECT * FROM activites WHERE nom = :nom";
            $res = $r->query($pdo, $qtf, ['nom' => $credentials['nom']]);
            if ($res->rowCount() > 0) {
                $r->deconnexion($pdo);
                return "The activity already exists";
            }
    
            $r->deconnexion($pdo);
            return false; // everything is good
        }
        return true; // case where the user has not entered anything ...
    }
    
    public function addActivite($credentials) {
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "INSERT INTO activites (nom, `description`, date_activite, photo) VALUES (:nom, :description, :date_activite, :photo)";
            $params = [
            'nom' => $credentials['nom'],
            'description' => $credentials['description'],
            'date_activite' => $credentials['date_activite'],
            'photo' => $credentials['photo']
            ];
            $res = $r->query($pdo, $qtf, $params);
            $r->deconnexion($pdo);
        }
    }

    public function getActivites() {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT * FROM activites";
        $stmt = $r->query($pdo, $qtf, []);
        $activites = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $r->deconnexion($pdo);
        return $activites;
    }
    public function addBenevole($credentials) {
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "INSERT INTO benevoles_events  (id_user, id_event) VALUES (:id_user, :id_event)";
            $params = [
                'id_user' => $credentials['id_user'],
                'id_event' => $credentials['id_event']
            ];
            $res = $r->query($pdo, $qtf, $params);
            $r->deconnexion($pdo);
        }
    }
public function addBenevoleActivite($credentials) {
    $r = new dataBaseController();
    if (isset($credentials)) {
        $pdo = $r->connexion();
        $qtf = "INSERT INTO benevoles_activites (id_user, id_activite) VALUES (:id_user, :id_activite)";
        $params = [
            'id_user' => $credentials['id_user'],
            'id_activite' => $credentials['id_activite']
        ];
        $res = $r->query($pdo, $qtf, $params);
        $r->deconnexion($pdo);
    }
}
}

?>