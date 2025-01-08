<?php
require_once(ROOT . '/Controller/userController.php');
require_once(ROOT . '/Controller/dataBaseController.php');
require_once(ROOT . '/utils/qrCodeUtils.php');

class userModel {
    public function getUser($identifier) {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf =    $qtf = "SELECT u.*,
                    CASE WHEN u.approuve = TRUE THEN m.carte ELSE NULL END as carte
                    FROM user u 
                    LEFT JOIN membre m ON u.id = m.id 
                    WHERE (u.username = :identifier OR u.email = :identifier)";
        $stmt = $r->query($pdo, $qtf, ['identifier' => $identifier]);
        $user = $stmt->fetch();
        $r->deconnexion($pdo);
        return $user;
    }

    public function checkPassword($userName, $password) {
        $r = new dataBaseController();
        if (isset($userName) && isset($password)) {
            $pdo = $r->connexion();
            $user = $this->getUser($userName);
            $pswd = $user['password'];
            if (password_verify($password, $pswd)) {
                $r->deconnexion($pdo);
                return true;
            } else {
                $r->deconnexion($pdo);
                return false;
            }
        }
    }

    public function problemInscription($credentials) {
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "SELECT * FROM user WHERE email = :email";
            $res = $r->query($pdo, $qtf, ['email' => $credentials['email']]);
            if ($res->rowCount() > 0) {
                $r->deconnexion($pdo);
                return "L'email est déjà utilisé";
            }

            $qtf = "SELECT * FROM user WHERE username = :username";
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

    public function inscriptionSimple($credentials) {
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "INSERT INTO user (username, email, `password`, telNumber, birthDate, nom, prenom, photoId, photo) VALUES (:username, :email, :password, :telNumber, :birthDate, :nom, :prenom, :photoId, :photo)";
            $params = [
                'username' => $credentials['username'],
                'email' => $credentials['email'],
                'password' => password_hash($credentials['password'], PASSWORD_DEFAULT),
                'telNumber' => $credentials['telNumber'],
                'birthDate' => $credentials['birthDate'],
                'nom' => $credentials['nom'],
                'prenom' => $credentials['prenom'],
                'photoId' => $credentials['idPhoto'],
                'photo' => $credentials['persoPhoto']
            ];
            $res = $r->query($pdo, $qtf, $params);
            $r->deconnexion($pdo);
        }
    }
    public function inscriptionMembre($credentials) {
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "INSERT INTO user (username, email, `password`, telNumber, birthDate, nom, prenom, photoId, photo,paiement) VALUES (:username, :email, :password, :telNumber, :birthDate, :nom, :prenom, :photoId, :photo,:paiement)";
            $params = [
                'username' => $credentials['username'],
                'email' => $credentials['email'],
                'password' => password_hash($credentials['password'], PASSWORD_DEFAULT),
                'telNumber' => $credentials['telNumber'],
                'birthDate' => $credentials['birthDate'],
                'nom' => $credentials['nom'],
                'prenom' => $credentials['prenom'],
                'photoId' => $credentials['idPhoto'],
                'photo' => $credentials['persoPhoto'],
                'paiement'=>1
            ];
            $res = $r->query($pdo, $qtf, $params);
            $user=$res->fetch(PDO::FETCH_ASSOC);
            $idUser=$pdo->lastInsertId();
            //insertion d'une ligne dans la table paiement
            $qtf2="INSERT INTO paiement (montant, recu) VALUES (:montant,:recu)";
            $params2 = [
                'montant' => NULL,
                'recu' => $credentials['recu']
            ];
            $res = $r->query($pdo, $qtf2, $params2);
            $idPaiement = $pdo->lastInsertId();
            //maintenant, on insere un ligne dans la table paiementUser pour avoir une association entre les deux table 
            $qtf3="INSERT INTO paiementuser (id_user, id_paiement) VALUES (:id_user,:id_paiement)";
            $params3 = [
                'id_user' => $idUser,
                'id_paiement' => $idPaiement
            ];
            $res = $r->query($pdo, $qtf3, $params3);
            $qtf4="INSERT INTO paiementcarte (type_carte, id_paiement) VALUES (:type_carte,:id_paiement)";
            $params4 = [
                'type_carte' => $credentials['plan'],
                'id_paiement' => $idPaiement
            ];
            $res = $r->query($pdo, $qtf4, $params4);
            $r->deconnexion($pdo);
        }
    }
    public function paiement($credentials) {
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "UPDATE user SET paiement = :paiement WHERE id = :id";
            $params = [
                'paiement'=>1,
                'id'=>$credentials['id']
            ];
            $res = $r->query($pdo, $qtf, $params);
            $user=$res->fetch(PDO::FETCH_ASSOC);
            //insertion d'une ligne dans la table paiement
            $qtf2="INSERT INTO paiement (montant, recu) VALUES (:montant,:recu)";
            $params2 = [
                'montant' => NULL,
                'recu' => $credentials['recu']
            ];
            $res = $r->query($pdo, $qtf2, $params2);
            $idPaiement = $pdo->lastInsertId();
            //maintenant, on insere un ligne dans la table paiementUser pour avoir une association entre les deux table 
            $qtf3="INSERT INTO paiementuser (id_user, id_paiement) VALUES (:id_user,:id_paiement)";
            $params3 = [
                'id_user' => $credentials['id'],
                'id_paiement' => $idPaiement
            ];
            $res = $r->query($pdo, $qtf3, $params3);
            $qtf4="INSERT INTO paiementcarte (type_carte, id_paiement) VALUES (:type_carte,:id_paiement)";
            $params4 = [
                'type_carte' => $credentials['plan'],
                'id_paiement' => $idPaiement
            ];
            $res = $r->query($pdo, $qtf4, $params4);
            $r->deconnexion($pdo);
        }
    }

    public function modifyPersoInfo($credentials){
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "UPDATE user SET nom=:nom,prenom=:prenom,telNumber=:telNumber,birthDate=:birthDate WHERE id=:id";
            $params = [
                'telNumber' => $credentials['telNumber'],
                'birthDate' => $credentials['birthDate'],
                'nom' => $credentials['nom'],
                'prenom' => $credentials['prenom'],
                'id' => $credentials['id']
            ];
            $res = $r->query($pdo, $qtf, $params);            
            $r->deconnexion($pdo);
            echo "abla";
        }
    }
    public function modifyCompteInfo($credentials){
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "UPDATE user SET username=:username,email=:email WHERE id=:id";
            $params = [
                'username' => $credentials['username'],
                'email' => $credentials['email'],
                'id' => $credentials['id']
            ];
            $res = $r->query($pdo, $qtf, $params);
            $r->deconnexion($pdo);
        }
    }
    public function modifyPassword($credentials){
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "UPDATE user SET password = :password WHERE id = :id";
            $params = [
                'password' => password_hash($credentials['password'], PASSWORD_DEFAULT),
                'id' => $credentials['id']
            ];
            $res = $r->query($pdo, $qtf, $params);
            $r->deconnexion($pdo);
        }
    }

    public function modifyPdp($credentials){
        $r = new dataBaseController();
        if (isset($credentials)) {
            $pdo = $r->connexion();
            $qtf = "UPDATE user SET photoProfile=:photoProfile WHERE id=:id";
            $params = [
                'photoProfile' => $credentials['photoProfile'],
                'id' => $credentials['id']
            ];
            $res = $r->query($pdo, $qtf, $params);
            $r->deconnexion($pdo);
        }
    }


    public function getUsers(){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT * FROM user WHERE id NOT IN ( SELECT id FROM `admin` )";
        $stmt = $r->query($pdo, $qtf, []);
        $users = $stmt->fetchAll();
        $r->deconnexion($pdo);
        return $users;
    }
    public function getCartes(){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT * FROM carte";
        $stmt = $r->query($pdo, $qtf, []);
        $cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $r->deconnexion($pdo);
        return $cartes;
    }

    public function isMember($id) {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT * FROM membre WHERE id=:id";
        $stmt = $r->query($pdo, $qtf, ['id' => $id]);
        $user = $stmt->fetch();
        $r->deconnexion($pdo);
        return $user ? true : false;
    }
    public function searchUser($searchKey){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf="SELECT * FROM user WHERE nom LIKE :searchKey OR prenom LIKE :searchKey OR email LIKE :searchKey OR username LIKE :searchKey";
        $params = [
            'searchKey' => '%' . $searchKey . '%'
        ];
        $stmt = $r->query($pdo, $qtf, $params);
        $users = $stmt->fetchAll();
        $r->deconnexion($pdo);
        return $users;
    }

    public function getMembers(){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT * FROM membre WHERE id NOT IN ( SELECT id FROM `admin` )";
        $stmt = $r->query($pdo, $qtf, []);
        $users = $stmt->fetchAll();
        $r->deconnexion($pdo);
        return $users;
    }
    public function getSimpleUsers(){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT * FROM user WHERE id NOT IN ( SELECT id FROM membre )";
        $stmt = $r->query($pdo, $qtf, []);
        $users = $stmt->fetchAll();
        $r->deconnexion($pdo);
        return $users;
    }

    public function approuverMembre($id_user,$type_carte){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        //création de la carte first
        $id_carte=$this->genererCartee($id_user,$type_carte);
        //création d'une ligne dans la table membre
        $qtf="INSERT INTO membre (id, carte) VALUES (:id,:carte)";
        $params = [
            'id' => $id_user,
            'carte' => $id_carte
        ];

        $res = $r->query($pdo, $qtf, $params);
        $qtf="UPDATE user SET approuve = TRUE WHERE id=:id;";
        $params = [
            'id' => $id_user
        ];
        
        $res = $r->query($pdo, $qtf, $params);
        $r->deconnexion($pdo);
    }

    public function getIdCarte($type_carte){
        if (isset($type_carte)){
            $r = new dataBaseController();
            $pdo = $r->connexion();
            $qtf = "SELECT * FROM carte WHERE type=:type_carte";
            $stmt = $r->query($pdo, $qtf, ['type_carte' => $type_carte]);
            $carte = $stmt->fetch();
            $r->deconnexion($pdo);
            return $carte['id'];
        }
    }
    //fonction pour générer la carte membre 
    public function genererCartee($id_user,$type_carte){
        $s= new qrGenerator();
        $id_type_carte=$this->getIdCarte($type_carte);
        $codeQr=$s->generateQrCode($id_user,$id_type_carte);
        $id_carte=$this->genererCarte($id_type_carte,$codeQr);
        return $id_carte;

    }
    public function genererCarte($id_type_carte,$codeQr){
        if (isset($id_type_carte) && isset($codeQr)){
            $r = new dataBaseController();
            $pdo = $r->connexion();
            $qtf="INSERT INTO cartem (code_qr, `type`) VALUES (:code_qr,:type)";
            $params = [
                'code_qr' => $codeQr,
                'type' => $id_type_carte
            ];
            $res = $r->query($pdo, $qtf, $params);
            $idCarte=$pdo->lastInsertId();
            $r->deconnexion($pdo);
            return $idCarte;
        }
    }
    
    public function getCarteById($id){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT cm.*, c.type as carte_type FROM cartem cm JOIN carte c ON cm.type = c.id WHERE cm.id = :id";
        $stmt = $r->query($pdo, $qtf, ['id' => $id]);
        $carte = $stmt->fetch();
        $r->deconnexion($pdo);
        return $carte;
    }

    public function getFavoris($id){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT p.id, p.photo, p.ville, p.nom, p.description, p.siteweb, p.numtel, p.contactemail FROM favoris f JOIN partenaire p ON f.id_partenaire = p.id WHERE f.id_user = :id_user";
        $stmt = $r->query($pdo, $qtf, ['id_user' => $id]);
        $favoris = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $r->deconnexion($pdo);
        return $favoris;
    }

    public function addFavoris($id_user,$id_partenaire){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf="INSERT INTO favoris (id_user, id_partenaire) VALUES (:id_user,:id_partenaire)";
        $params = [
            'id_user' => $id_user,
            'id_partenaire' => $id_partenaire
        ];
        $res = $r->query($pdo, $qtf, $params);
        $r->deconnexion($pdo);
    }

    public function deleteFavoris($id_user, $id_partenaire) {
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "DELETE FROM favoris WHERE id_user = :id_user AND id_partenaire = :id_partenaire";
        $params = [
            'id_user' => $id_user,
            'id_partenaire' => $id_partenaire
        ];
        $res = $r->query($pdo, $qtf, $params);
        $r->deconnexion($pdo);
    }

    public function getRecu($userId){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT p.recu FROM paiementuser pu JOIN paiement p ON pu.id_paiement = p.id WHERE pu.id_user = :id_user";
        $params = [
            'id_user' => $userId
        ];
        $stmt = $r->query($pdo, $qtf, $params);
        $recu = $stmt->fetch(PDO::FETCH_ASSOC);
        $r->deconnexion($pdo);
        return $recu;
    }

    public function getOffres($id){
        $r = new dataBaseController();
        $pdo = $r->connexion();
        $qtf = "SELECT 
    o.offre_id,
    o.contenu,
    o.type,
    p.ville,
    p.categorie,
    p.nom
FROM 
    (
        SELECT 
            offr.id AS offre_id,
            offr.partenaireId,
            offr.contenu,
            offr.type
        FROM 
            offre AS offr
        JOIN 
            carteoffre AS co ON co.offre_id = offr.id
        WHERE 
            co.carte_id = (
                SELECT 
                    m.carte
                FROM 
                    membre AS m
                WHERE 
                    m.id = :id
            )
    ) AS o
JOIN 
    partenaire AS p ON p.id = o.partenaireId;
                ";
        $params = [
            'id' => $id
        ];
        $stmt = $r->query($pdo, $qtf, $params);
        $offres = $stmt->fetch(PDO::FETCH_ASSOC);
        $r->deconnexion($pdo);
        return $offres;
    }
}
?>