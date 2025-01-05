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

    public function userPopup() {
        $r = new commonViews();
        ?>
        <div class="popContainer" >
            <div class="popupUpload" id="userPopup">
                <h3>Information de l'utilisateur</h3>
                <div class="textArea">

                    <p>Nom : <span id="popupNom"></span></p>
                    <p>Prénom : <span id="popupPrenom"></span></p>
                    <p>Username : <span id="popupUsername"></span></p>
                    <p>Email : <span id="popupEmail"></span></p>
                    <p>Type : <span id="popupType"></span></p>
                    <p id="popupPaiement" style="display: flex; justify-content:space-between;">Reçu : <button type='button' id='fileRecu'>Télécharger le reçu</button></p>
                    <input type="hidden" id="popupId" data-user-id="">
                </div>
                <?php
                $r->blueButton2("Approuver l'utilisateur", "approuverBtn");
                $r->blueButton2("Fermer", "closeUserbtn");
                ?>
            </div>
        </div>
        <?php
    }
    public function approuverPopup() {
        $r = new commonViews();
        ?>
        <div class="popContainer" >
            <div class="popupUpload" id="approuverPopup">
                <h3>Approuver l'utilisateur</h3>
                <div class="textArea">
                    <form action="" class="approuver" id="formApprouver">
                        <input type="hidden" name="id">
                        <label for="carteType">Type de carte:</label>
                        <select name="carteType" id="carteType">
                            
                        </select>
                    </form>
                </div>
                <?php
                $r->blueButton2("Confirmer", "approuverUser");
                $r->blueButton2("Annuler", "closeUserbtn2");
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
                <?php $this->userPopup(); ?>
                <?php $this->approuverPopup(); ?>
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
                                        '<td id="approuveTd">' + (user['approuve'] ? 'Membre' : 'User') + '</td>' +
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
                        $('#popupId').val(user.id);
                        $('#popupPrenom').text(user.prenom);
                        $('#popupUsername').text(user.username);
                        $('#popupEmail').text(user.email);
                        $('#popupType').text(user.approuve ? 'Membre' : 'User');
                        if (user.paiement==1) {
                            $('#popupPaiement').show();
                            $('#fileRecu').on('click', function() {
                                handleClickRecu(user);
                            });
                        } else {
                            $('#popupPaiement').hide();
                        }
                        if(user.approuve){
                            $('#approuverBtn').hide();
                        } else {
                            $('#approuverBtn').show();
                        }
                        $('#userPopup').show();
                        
                    }
                    function handleClickRecu(user){
                        $.ajax({
                            url: 'index.php?router=getRecu', // Endpoint URL
                            type: 'POST', // HTTP method
                            data: { userId: user.id },
                            dataType: 'json',
                            success: function(data) {
                                var imageUrl = data.recu.replace('../', ''); // Remove '../' from the path
                                var a = document.createElement('a');
                                a.href =  imageUrl; // Prepend 'View/' to the path
                                a.download = imageUrl.split('/').pop(); 
                                a.click();
                                console.log(data);
                                console.log(a.href);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching users:', error);
                            }
                        });
                        
                    }
                    const popContainer1 = document.getElementsByClassName("popContainer")[1];
                    document.getElementById("closeUserbtn").addEventListener("click", function () {
                    console.log("Button clicked");
                    popContainer.style.display = "none";
                    popupT.style.display = "none";
                });
                document.getElementById("closeUserbtn2").addEventListener("click", function () {
                    console.log("Button clicked");
                    popContainer1.style.display = "none";
                    document.getElementById("approuverPopup").style.display="none";
                });
                
                function successPopup() {
                    const popupT = document.getElementById("userPopup");
                    popContainer.style.display = "flex";
                    popupT.style.display = "flex";
                }
                window.addEventListener("click", (event) => {
                    if (event.target === popContainer) {
                        popContainer.style.display = "none";
                        popupT.style.display = "none";
                        
                    }
                    if (event.target === popContainer1) {
                        popContainer1.style.display = "none";
                        document.getElementById("approuverPopup").style.display="none";
                        
                    }
                });

                document.getElementById("approuverBtn").addEventListener("click", function () {
                    popContainer.style.display = "none";
                    popupT.style.display = "none";
                    document.getElementById("approuverPopup").style.display = "flex";
                    popContainer1.style.display = "flex";
                    
                    // Pass the user ID to the approuverPopup function
                    const userId = parseInt($('#popupId').val());
                    $('#approuverPopup input[name="id"]').val(userId);
                });
                $(document).ready(function() {
                        // AJAX request to fetch users
                        $.ajax({
                            url: 'index.php?router=getCartes', // Endpoint URL
                            type: 'GET', // HTTP method
                            dataType: 'json',
                            success: function(data) {
                                console.log('Response data:', data)
                                const carteSelect = $('#carteType');
                                data.forEach(function(carte) {
                                    carteSelect.append('<option value="' + carte['type'] + '">' + carte['type'] + '</option>');
                                });
                                
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching users:', error);
                            }
                        });
                    });
                    $(document).ready(function () {
                    $('#approuverUser').on('click', function (event) {            
                    event.preventDefault();
            
                    const formData = new FormData($('#formApprouver')[0]);
                    $.ajax({
                        url: 'index.php?router=approuver',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response == 1) {
                                console.log(response);
                                alert('Utilisateur approuvé avec succés !')
                                popContainer1.style.display = "none";
                                document.getElementById("approuverPopup").style.display="none";
                                $('#popupType').text('Membre');
                                $("#approuveTd").text("Membre");
                            
                            }
                            else {                
                                console.log(response);
                                alert(response);
                            }
                        },
                        error: function () {
                            alert('erreur!');
                        }
                    });})})
                </script>
            </body>
        </html>
        <?php
    }
}
?>
