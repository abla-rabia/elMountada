<?php
require_once(ROOT . '/Controller/partenaireController.php');
require_once(ROOT . '/Controller/dataBaseController.php');
require_once(ROOT . '/utils/qrCodeUtils.php');
class partenaireModel{


    public function getPartenaire($identifier) {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT *
                FROM partenaire 
                WHERE (username = :identifier OR email = :identifier)";
        $stmt = $r->query($pdo, $qtf, ['identifier' => $identifier]);
        $partenaire = $stmt->fetch();
        $r->deconnexion($pdo);
        return $partenaire;
    }

    public function checkPartenairePassword($userName, $password) {
        $r = new dataBaseController();
        if (isset($userName) && isset($password)) {
            $pdo = $r->connexion();
            $partenaire = $this->getPartenaire($userName);
            $pswd = $partenaire['password'];
            if (password_verify($password, $pswd)) {
                $r->deconnexion($pdo);
                return true;
            } else {
                $r->deconnexion($pdo);
                return false;
            }
        }
    }
public function getCategories(){
    $r = new dataBaseController();
    $pdo = $r->connexion();
    $qtf = "SELECT * FROM categpart";
    $stmt = $r->query($pdo, $qtf, []);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $r->deconnexion($pdo);
    return $categories;
}
public function getPartenaireById($id){
    $r = new dataBaseController();
    $pdo = $r->connexion();
    $qtf = "SELECT * FROM partenaire where id=:id";
    $params = [
        'id' => $id
    ];
    $stmt = $r->query($pdo, $qtf, $params);
    $partenaire = $stmt->fetch();
    $r->deconnexion($pdo);
    return $partenaire;
}
public function getPartenaires(){
    $r = new dataBaseController();
    $pdo = $r->connexion();
    $qtf = "SELECT * FROM partenaire";
    $stmt = $r->query($pdo, $qtf, []);
    $partenaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $r->deconnexion($pdo);
    return $partenaires;
}

public function getPartenairesByCategorie($categ){
    $r = new dataBaseController();
    $pdo = $r->connexion();
    $qtf = "SELECT * FROM partenaire where categorie=:categ";
    $params = [
        'categ' => $categ
    ];
    $stmt = $r->query($pdo, $qtf, $params);
    $partenaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $r->deconnexion($pdo);
    return $partenaires;
}

public function problemAddPartenaire($credentials) {
    $r = new dataBaseController();
    if (isset($credentials)) {
        $pdo = $r->connexion();
        $qtf = "SELECT * FROM partenaire WHERE email = :email UNION SELECT * FROM user WHERE email = :email";
        $res = $r->query($pdo, $qtf, ['email' => $credentials['email']]);
        if ($res->rowCount() > 0) {
            $r->deconnexion($pdo);
            return "L'email est déjà utilisé";
        }

        $qtf = "SELECT * FROM partenaire WHERE username = :username UNION SELECT * FROM user WHERE username = :username";
        $res = $r->query($pdo, $qtf, ['username' => $credentials['username']]);
        if ($res->rowCount() > 0) {
            $r->deconnexion($pdo);
            return "Le nom d'utilisateur est déjà utilisé";
        }

        $r->deconnexion($pdo);
        return false; // tout est bon
    }
    return true; // cas où le user n'a rien entré ...
}
public function addPartenaire($credentials) {
    $r = new dataBaseController();
    if (isset($credentials)) {
        $pdo = $r->connexion();
        $qtf = "INSERT INTO partenaire (nom, `description`, ville, photo, logo, categorie, username, email, `password`, telNumber, website, contactmail) VALUES (:nom, :description, :ville, :photo, :logo, :categorie, :username, :email, :password, :telNumber, :website, :contactmail)";
        $params = [
            'nom' => $credentials['nom'],
            'description' => $credentials['description'],
            'ville' => $credentials['ville'],
            'photo' => $credentials['photo'],
            'logo' => $credentials['logo'],
            'categorie' => $credentials['categorie'],
            'username' => $credentials['username'],
            'email' => $credentials['email'],
            'password' => password_hash($credentials['password'], PASSWORD_DEFAULT),
            'telNumber' => $credentials['telNumber'],
            'website' => $credentials['website'],
            'contactmail' => $credentials['contactmail']
        ];
        $res = $r->query($pdo, $qtf, $params);
        $r->deconnexion($pdo);
    }
}

public function deletePartenaire($id) {
    $r = new dataBaseController();
    if (isset($id)) {
        $pdo = $r->connexion();
        $qtf = "DELETE from partenaire WHERE id=:id";
        $params = [
            'id' => $id
        ];
        $res = $r->query($pdo, $qtf, $params);
        $r->deconnexion($pdo);
    }
}

public function modifyPartenaire($credentials){
    $r = new dataBaseController();
    if (isset($credentials)) {
        $pdo = $r->connexion();
        $qtf = "UPDATE partenaire SET nom=:nom, ville=:ville,  categorie=:categorie, telNumber=:telNumber, website=:website, contactmail=:contactmail, `description`=:description WHERE id=:id";
        $params = [
            'nom' => $credentials['nom'],
            'ville' => $credentials['ville'],
            'categorie' => $credentials['categorie'],
            'description' => $credentials['description'],
            'telNumber' => $credentials['telNumber'],
            'website' => $credentials['website'],
            'contactmail' => $credentials['contactmail'],
            'id' => $credentials['id']
        ];
        $res = $r->query($pdo, $qtf, $params);            
        $r->deconnexion($pdo);
        return true;
    }
}

public function modifyPassword($credentials){
    $r = new dataBaseController();
    if (isset($credentials)) {
        $pdo = $r->connexion();
        $qtf = "UPDATE partenaire SET password = :password WHERE id = :id";
        $params = [
            'password' => password_hash($credentials['password'], PASSWORD_DEFAULT),
            'id' => $credentials['id']
        ];
        $res = $r->query($pdo, $qtf, $params);
        $r->deconnexion($pdo);
    }
}
public function addOffre($credentials) {
    $r = new dataBaseController();
    if (isset($credentials)) {
        $pdo = $r->connexion();
        $qtf = "INSERT INTO offre (contenu, partenaireId,`type` ) VALUES (:contenu, :partenaireId, :type)";
        $params = [
            'contenu' => $credentials['contenu'],
            'partenaireId' => $credentials['partenaireId'],
            'type' => $credentials['type']
        ];
        $res = $r->query($pdo, $qtf, $params);
        $idOffre=$pdo->lastInsertId();
        $qtf = "INSERT INTO carteoffre (carte_id, offre_id ) VALUES (:carte_id, :offre_id)";
        $params = [
            'carte_id' => $credentials['carteId'],
            'offre_id' => $idOffre
        ];
        $res = $r->query($pdo, $qtf, $params);
        $r->deconnexion($pdo);
    }
}

}
?>