<?php
require_once(ROOT . '/Controller/userController.php');
require_once("commonViews.php");
require_once("inscriptionView.php");

class carteView {
    private $sessionData;
    private $membre;
    private $type = "classique";

    public function __construct() {
        $this->sessionData = isset($_SESSION['user']) ? $_SESSION['user'] : (isset($_SESSION['member']) ? $_SESSION['member'] : null);
        $this->membre = isset($_SESSION['user']) ? 0 : 1;
    }

    public function entetePage() {
        ?>
        <head>
            <title><?php echo $this->membre == 1 ? "Ma carte" : "Achat carte"; ?></title>
            <link rel="stylesheet" href="View/css/inscriptionStyle.css">
            <link rel="stylesheet" href="View/css/userInfosStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        </head>
        <?php
    }

    public function afficher_page() {
        $r = new commonViews();
        $s = new inscriptionView();
        ?>
        <html>
            <?php $this->entetePage(); ?>
            <body>
                <?php $r->navBarC(); ?>
                <div class="content">
                    <?php if ($this->membre == 1) { ?>
                        <?php $r->titre("Ma carte"); ?>
                        <div class="subContent carte">
                            <div class="mesOffres">
                                <table id="Offres">
                                    <tr class="head">
                                        <th>Type</th>
                                        <th>Ville</th>
                                        <th>Catégorie</th>
                                        <th>Partenaire</th>
                                        <th>Contenu</th>
                                    </tr>
                                </table>
                            </div>
                            <?php $r->carte($this->type, $_SESSION["member"]['nom'], $_SESSION["member"]['prenom'], $_SESSION["member"]['id']); ?>
                        </div>
                    <?php } else { ?>
                        <?php $r->titre("Achat carte"); ?>
                        <div class="subContent cartes">
                            <div class="paiement">
                                <div class="subContent cartes">
                                    <div class="textExplication">
                                        <p>Pour devenir membre de notre association, une carte de membre est nécessaire. Voici les informations importantes concernant cette étape :</p>
                                        <h5>Pourquoi une carte de membre ?</h5>
                                        <p>La carte de membre vous permet de bénéficier d'avantages exclusifs avec nos partenaires (hôtels, cliniques, écoles, agences de voyage, etc.) et d’accéder à des remises adaptées à chaque type de carte.</p>
                                        <h5>Types de cartes disponibles :</h5>
                                        <p>Chaque carte propose des avantages spécifiques et un tarif associé. Vous trouverez ci-dessous la liste des cartes avec leurs descriptions détaillées et leurs prix pour choisir celle qui vous convient le mieux.</p>
                                        <h5>Procédure de paiement :</h5>
                                        <ul>
                                            <li>Sélectionnez une carte.</li>
                                            <li>Effectuez le paiement au compte CCP : <b>8544567876534</b>.</li>
                                            <li>Joignez le reçu de paiement directement sur cette page.</li>
                                            <li>Validez votre demande en cliquant sur "Soumettre".</li>
                                        </ul>
                                        <h5>Validation de votre adhésion :</h5>
                                        <p>Une fois votre paiement vérifié par l’administrateur, vous serez notifié par e-mail de votre acceptation en tant que membre de l’association.</p>
                                    </div>
                                    <div class="cartesOffres">
                                        <?php
                                        $r->lightCard("Carte Classique", "2 500");
                                        $r->darkCard();
                                        $r->lightCard("Carte Prestige", "10 000");
                                        ?>
                                    </div>
                                </div>
                                <div class="buttonContainer">
                                    <div class="buttonConf">
                                        <?php
                                        $r->blueButton2("Confirmer", "inscriptionPop");
                                        $r->textPopup();
                                        ?>
                                    </div>
                                    <?php $r->uploadPopup("recu"); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </body>
            <script>
                <?php if ($this->membre == 1) { ?>
                //chargement des offres
                $(document).ready(function() {
                    // AJAX request to fetch users
                    $.ajax({
                        url: 'index.php?router=getOffres', // Endpoint URL
                        type: 'GET', // HTTP method
                        dataType: 'json',
                        success: function(data) {
                            console.log('Response data:', data)
                            const offresTable = $('#Offres');
                            data.forEach(function(offre) {
                                offresTable.append('<tr>' +
                                    '<td>' + offre['type'] + '</td>' +
                                    '<td>' + offre['ville'] + '</td>' +
                                    '<td>' + offre['categorie'] + '</td>' +
                                    '<td>' + offre['partenaire'] + '</td>' +
                                    '<td>' + offre['contenu'] + '</td>' +
                                '</tr>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching users:', error);
                        }
                    });
                });
                //chargement de la carte
                $(document).ready(function() {
                    // AJAX request to fetch users
                    $.ajax({
                        url: 'index.php?router=getCarte', // Endpoint URL
                        type: 'GET', // HTTP method
                        dataType: 'json',
                        success: function(data) {
                            console.log('Response data:', data)
                            $("#userQR").attr("src", data.code_qr);
                            $("#typecarte").text(data.carte_type);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching users:', error);
                        }
                    });
                });
                <?php } ?>

                let plan;
                const popup = document.getElementById("popupUpload");
                const popContainer = document.getElementsByClassName("popContainer")[0];
                const popContainer1 = document.getElementsByClassName("popContainer")[1];

                const choosePlanButtons = document.getElementsByClassName("choosePlan");
                for (let i = 0; i < choosePlanButtons.length; i++) {
                    choosePlanButtons[i].addEventListener("click", function () {
                        console.log("Button clicked");
                        popContainer1.style.display = "flex";
                        popup.style.display = "flex";
                        if (i === 0) {
                            plan = "classique";
                        } else if (i === 1) {
                            plan = "premium";
                        } else if (i === 2) {
                            plan = "prestige";
                        }
                        console.log(plan);
                    });
                }

                document.getElementById("closeUploadPop").addEventListener("click", function () {
                    console.log("Button clicked");
                    popContainer1.style.display = "none";
                    popup.style.display = "none";
                });

                function successPopup() {
                    const popContainer = document.getElementsByClassName("popContainer")[0];
                    const popupT = document.getElementById("textPopup");
                    popContainer.style.display = "flex";
                    popupT.style.display = "flex";
                    document.getElementById("contentPop").textContent= "Reçu soumis avec succès ! Votre demande est en cours de traitement. Une fois confirmée, vous recevrez une notification";
                }

                window.addEventListener("click", (event) => {
                    if (event.target === popContainer) {
                        popContainer.style.display = "none";
                        popup.style.display = "none";
                    }
                });

                window.addEventListener("click", (event) => {
                    if (event.target === popContainer1) {
                        popContainer1.style.display = "none";
                        popup.style.display = "none";
                    }
                });

                $(document).ready(function () {
                    $('#inscriptionPop').on('click', function (event) {
                        event.preventDefault();
                        const fileInput = $('input[name="recu"]')[0]; // Récupère l'élément DOM
                        const files = new FormData(); // Utilisation de FormData pour envoyer les fichiers et le plan
                        files.append('recu', fileInput.files[0]); // Ajout du fichier au FormData
                        files.append('plan', plan); // Ajout du plan au FormData
                        $.ajax({
                            url: 'index.php?router=paiement',
                            type: 'POST',
                            data: files,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                if (response == 1) {
                                    console.log(response);
                                    successPopup();
                                } else if (response == 3) {
                                    console.log(response);
                                    alert('Veuillez remplire tous les champs ! ');
                                } else {
                                    console.log(response);
                                    alert(response);
                                }
                            },
                            error: function () {
                                alert('erreur!');
                            }
                        });
                    });
                });
            </script>
        </html>
        <?php
    }
}
?>
