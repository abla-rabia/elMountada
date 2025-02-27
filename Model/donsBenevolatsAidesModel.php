<?php
require_once(ROOT . '/Controller/donsBenevolatsAidesController.php');
require_once(ROOT . '/Controller/dataBaseController.php');
class DonsBenevolatsAidesModel {
    public function problemAddTypeAide($credentials){
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "SELECT * FROM type_aide WHERE nom = :nom";
            $res = $r->query($pdo, $qtf, ['nom' => $credentials['nom']]);
            if ($res->rowCount() > 0) {
                $r->deconnexion($pdo);
                return "Le type d'aide existe déja";
            }
    
            $r->deconnexion($pdo);
            return false; // tout est bon
        }
        return true; // cas où le user n'a rien entré ...
    }
    public function addTypeAide($credentials) {
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "INSERT INTO type_aide (nom, `description` ) VALUES (:nom, :description)";
            $params = [
                'nom' => $credentials['nom'],
                'description' => $credentials['description']
            ];
            $res = $r->query($pdo, $qtf, $params);
            $r->deconnexion($pdo);
        }
    }

    public function getTypesAide() {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT * FROM type_aide";
        $stmt = $r->query($pdo, $qtf, []);
        $typesAide = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $r->deconnexion($pdo);
        return $typesAide;
    }
    public function getAides() {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT a.*, ta.nom as type_aide FROM aide a join type_aide ta on ta.id=a.id_type_aide";
        $stmt = $r->query($pdo, $qtf, []);
        $Aides = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $r->deconnexion($pdo);
        return $Aides;
    }
    public function addAide($credentials) {
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "INSERT INTO aide (nom, prenom, id_user, dossier_zip, id_type_aide, `description`) VALUES (:nom, :prenom, :id_user, :dossier_zip, :id_type_aide, :description)";
            $params = [
                'nom' => $credentials['nom'],
                'prenom' => $credentials['prenom'],
                'id_user' => $credentials['id_user'],
                'dossier_zip' => $credentials['dossier_zip'],
                'id_type_aide' => $credentials['id_type_aide'],
                'description' => $credentials['description']
            ];
            $res = $r->query($pdo, $qtf, $params);
            $r->deconnexion($pdo);
        }
    }
    public function addDon($credentials) {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $query = "INSERT INTO dons (recu, id_user) VALUES (:recu, :id_user)";
        $params = [
            'recu' => $credentials['recu'],
            'id_user' => $credentials['id_user']
        ];
        $res = $r->query($pdo, $query, $params);
        $r->deconnexion($pdo);
        return $res;
    }

    public function getDons() {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $query = "SELECT d.*, u.nom, u.prenom 
                 FROM dons d 
                 JOIN user u ON d.id_user = u.id 
                 ORDER BY d.date_ajout DESC"; 
        $stmt = $r->query($pdo, $query, []);
        $dons = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $r->deconnexion($pdo);
        return $dons;
    }

    public function approuverDon($id) {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $query = "UPDATE dons SET approuve = TRUE WHERE id = :id";
        $params = ['id' => $id];
        $res = $r->query($pdo, $query, $params);
        $r->deconnexion($pdo);
        return $res;
    }
    public function getDonsByUserId($id){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $query = "SELECT * FROM dons WHERE id_user = :id_user";
        $params = ['id_user' => $id];
        $stmt = $r->query($pdo, $query, $params);
        $dons = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $r->deconnexion($pdo);
        return $dons;
    }

    public function getBenevolatsByUserId($id){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $queryEvents = "SELECT e.* FROM benevoles_events b JOIN events e ON e.id = b.id_event WHERE b.id_user = :id_user";
        $params = ['id_user' => $id];
        $stmtEvents = $r->query($pdo, $queryEvents, $params);
        $benevolatsEvents = $stmtEvents->fetchAll(PDO::FETCH_ASSOC);
        $queryActivites = "SELECT a.* FROM benevoles_activites b JOIN activites a ON a.id = b.id_activite WHERE b.id_user = :id_user";
        $stmtActivites = $r->query($pdo, $queryActivites, $params);
        $benevolatsActivites = $stmtActivites->fetchAll(PDO::FETCH_ASSOC);
        
        $r->deconnexion($pdo);
        $benevolats = array_merge($benevolatsEvents, $benevolatsActivites);
        
        return $benevolats;
    }
    
}
?>