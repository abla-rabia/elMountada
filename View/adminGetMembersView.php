<?php
require_once(ROOT . '/Controller/userController.php');
require_once("commonViews.php");

class adminUsersView {
    public function entetePage() {
        ?>
        <head>
            <title>Membres et utilisateurs</title>
            <link rel="stylesheet" href="View/css/userInfosStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <script src="View/scripts/infosScript.js"></script>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        </head>
        <?php   
    }

    public function userPopup($nom, $prenom, $username, $email, $type, $paiement) {
        $r = new commonViews();
        ?>
        <div class="popContainer" id="userPopup">
            <div class="popupUpload" id="textPopup">
                <h3>Information de l'utilisateur</h3>
                <div class="textArea">
                    <p>Nom : <span id="popupNom"></span></p>
                    <p>Prénom : <span id="popupPrenom"></span></p>
                    <p>Username : <span id="popupUsername"></span></p>
                    <p>Email : <span id="popupEmail"></span></p>
                    <p>Type : <span id="popupType"></span></p>
                    <p id="popupPaiement" style="display: none;">Reçu : </p>
                </div>
                <?php
                $r->blueButton2("Fermer", "closeUserbtn");
                ?>
            </div>
        </div>
        <?php
    }

    public function afficher_page() {
        $r = new commonViews();
        ?>
        <html>
            <?php
            $this->entetePage();
            ?>
            <body class="to">
            <?php
                $r->navBarC();
                ?>
                <div class="content">
                    <?php
                        $r->titre("Liste des utilisateurs");
                        ?>
                        <div class="subContent">
                            <?php
                                $r->adminSideBar("Utilisateurs");
                            ?>
                            <div class="users">
                                <div class="search">

                                </div>
                                <table id="all">
                                    <tr class="head">
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Date d'inscription</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                </div>
                <?php $this->userPopup('', '', '', '', '', false); ?>
                <script>
                    $(document).ready(function() {
                        // AJAX request to fetch users
                        $.ajax({
                            url: 'index.php?router=getUsers', // Endpoint URL
                            type: 'GET', // HTTP method
                            dataType: 'json',
                            success: function(data) {
                                console.log('Response data:', data)
                                const usersTable = $('#all');
                                data.forEach(function(user) {
                                    usersTable.append('<tr>' +
                                        '<td>' + user['username'] + '</td>' +
                                        '<td>' + user['email'] + '</td>' +
                                        '<td>' + user['nom'] + '</td>' +
                                        '<td>' + user['prenom'] + '</td>' +
                                        '<td>' + user['date_inscription'] + '</td>' +
                                        '<td>' + (user['carte'] !== undefined ? 'Member' : 'User') + '</td>' +
                                        '<td><button class="action-btn" onclick=\'handleUserAction(' + JSON.stringify(user) + ')\'>Action</button></td>' +
                                    '</tr>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching users:', error);
                            }
                        });
                    });
                    const popupT = document.getElementById("userPopup");
                    const popContainer = document.getElementsByClassName("popContainer")[0];
                    function handleUserAction(user) {
                        console.log(user)
                        successPopup()
                        $('#popupNom').text(user.nom);
                        $('#popupPrenom').text(user.prenom);
                        $('#popupUsername').text(user.username);
                        $('#popupEmail').text(user.email);
                        $('#popupType').text(user.carte !== undefined ? 'Member' : 'User');
                        if (user.carte !== undefined) {
                            $('#popupPaiement').show();
                        } else {
                            $('#popupPaiement').hide();
                        }
                        $('#userPopup').show();
                    }

                    document.getElementById("closeUploadPop").addEventListener("click", function () {
                    console.log("Button clicked");
                    popContainer.style.display = "none";
                    popup.style.display = "none";
                });
                
                function successPopup() {
                    
                    popContainer.style.display = "flex";
                    popupT.style.display = "flex";
                }
                window.addEventListener("click", (event) => {
                    if (event.target === popContainer) {
                        popContainer.style.display = "none";
                        popup.style.display = "none";
                    }
                });
                </script>
            </body>
        </html>
        <?php
    }
}
?>
