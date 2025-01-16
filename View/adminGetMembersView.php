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
            <style>
                .users {
                    background: white;
                    border-radius: 12px;
                    padding: 20px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                }

                /* Table Styles */
                table#all {
                    width: 100%;
                    border-collapse: separate;
                    border-spacing: 0;
                    margin-top: 20px;
                    font-size: 14px;
                }

                /* Header Cells */
                table#all th {
                    background: #f8f9fa;
                    color: #2c3e50;
                    font-weight: 600;
                    padding: 16px;
                    text-align: left;
                    border-bottom: 2px solid #edf2f7;
                    cursor: pointer;
                    transition: background-color 0.2s;
                    position: relative;
                }

                table#all th:hover {
                    background: #edf2f7;
                }

                table#all th:after {
                    content: '↕';
                    position: absolute;
                    right: 8px;
                    opacity: 0.3;
                }

                /* Table Cells */
                table#all td {
                    padding: 14px 16px;
                    border-bottom: 1px solid #edf2f7;
                    color: #4a5568;
                    font-weight: 500;
                }

                /* Table Rows */
                table#all tr:not(.head):hover {
                    background-color: #f8fafc;
                    transition: background-color 0.2s;
                }

                /* Action Button */
                .action-btn {
                    background: #a6dfb5;
                    color: white;
                    border: none;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-size: 12px;
                    font-weight: 500;
                    cursor: pointer;
                    transition: background-color 0.2s;
                }

                .action-btn:hover {
                    background:rgb(129, 185, 144);
                }

                /* Status Styles */
                table#all td:nth-child(6) {
                    position: relative;
                }

                table#all td:nth-child(6):before {
                    content: '';
                    display: inline-block;
                    width: 8px;
                    height: 8px;
                    border-radius: 50%;
                    margin-right: 8px;
                }

                table#all td:nth-child(6):contains('Membre'):before {
                    background-color: #34d399;
                }

                table#all td:nth-child(6):contains('User'):before {
                    background-color: #fbbf24;
                }

                /* Responsive Design */
                @media screen and (max-width: 1024px) {
                    table#all {
                        font-size: 13px;
                    }
                    
                    table#all th, 
                    table#all td {
                        padding: 12px;
                    }
                    
                    .action-btn {
                        padding: 6px 12px;
                    }
                }

                @media screen and (max-width: 768px) {
                    .users {
                        padding: 12px;
                    }
                    
                    table#all {
                        display: block;
                        overflow-x: auto;
                        white-space: nowrap;
                    }
                }
            </style>
        </head>
        <?php   
    }

    public function searchBar() {
        ?>
        <form action="" id="users" class="searchBar">
            <div class="searchBar">
                <i class="fas fa-search"></i>
                <input type="text" onkeyup="fetchUsers()" name="search" id="seachBar" placeholder="Rechercher un utilisateur">
            </div>
            <div class="filtresTri">
                <input onchange="fetchUsers()" type="date" id="dateMin" name="dateMin" style="background: #f3f3f3;border-radius:4px;">
                <input onchange="fetchUsers()" type="date" id="dateMax" name="dateMax" style="background: #f3f3f3;border-radius:4px;">
                <select name="filtreUsers" id="filtreUsers" onchange="fetchUsers()">
                    <option value="0">Filtrer par</option>
                    <option value="1">Utilisateurs</option>
                    <option value="2">Membres</option>           
                </select>
            </div>
        </form>
        <?php
    }

    public function userPopup() {
        $r = new commonViews();
        ?>
        <div class="popContainer">
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
        <div class="popContainer">
            <div class="popupUpload" id="approuverPopup">
                <h3>Approuver l'utilisateur</h3>
                <div class="textArea">
                    <form action="" class="approuver" id="formApprouver">
                        <input type="hidden" name="id">
                        <label for="carteType">Type de carte:</label>
                        <select name="carteType" id="carteType"></select>
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
            <?php $this->entetePage(); ?>
            <body class="to">
                <?php $r->navBar(); ?>
                <div class="content">
                    <?php $r->titre("Liste des utilisateurs"); ?>
                    <div class="subContent">
                        <?php $r->adminSideBar("Utilisateurs"); ?>
                        <div class="users">
                            <div class="search">
                                <?php $this->searchBar() ?>
                            </div>
                            <table id="all">
                                <tr class="head">
                                    <th onclick="sortTable('username')">Username</th>
                                    <th onclick="sortTable('email')">Email</th>
                                    <th onclick="sortTable('nom')">Nom</th>
                                    <th onclick="sortTable('prenom')">Prénom</th>
                                    <th onclick="sortTable('date')">Date d'inscription</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                    <th>Bloquer</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php $this->userPopup(); ?>
                <?php $this->approuverPopup(); ?>
                <script>
                    $(document).ready(function() {
                        fetchUsers();
                        $('#seachBar').on('keyup', fetchUsers);
                        $('#dateMin, #dateMax, #filtreUsers').on('change', fetchUsers);
                    });

                    

                    const popupT = document.getElementById("userPopup");
                    const popContainer = document.getElementsByClassName("popContainer")[0];

                    function handleUserAction(user) {
                        successPopup();
                        $('#popupNom').text(user.nom);
                        $('#popupId').val(user.id);
                        $('#popupPrenom').text(user.prenom);
                        $('#popupUsername').text(user.username);
                        $('#popupEmail').text(user.email);
                        $('#popupType').text(user.approuve ? 'Membre' : 'User');
                        if (user.paiement == 1) {
                            $('#popupPaiement').show();
                            $('#fileRecu').on('click', function() {
                                handleClickRecu(user);
                            });
                        } else {
                            $('#popupPaiement').hide();
                        }
                        if (user.approuve) {
                            $('#approuverBtn').hide();
                        } else {
                            $('#approuverBtn').show();
                        }
                        $('#userPopup').show();
                    }

                    function handleClickRecu(user) {
                        $.ajax({
                            url: 'index.php?router=getRecu',
                            type: 'POST',
                            data: { userId: user.id },
                            dataType: 'json',
                            success: function(data) {
                                var imageUrl = data.recu.replace('../', '');
                                var a = document.createElement('a');
                                a.href = imageUrl;
                                a.download = imageUrl.split('/').pop();
                                a.click();
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching users:', error);
                            }
                        });
                    }

                    const popContainer1 = document.getElementsByClassName("popContainer")[1];
                    document.getElementById("closeUserbtn").addEventListener("click", function() {
                        popContainer.style.display = "none";
                        popupT.style.display = "none";
                    });
                    document.getElementById("closeUserbtn2").addEventListener("click", function() {
                        popContainer1.style.display = "none";
                        document.getElementById("approuverPopup").style.display = "none";
                    });

                    function successPopup() {
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
                            document.getElementById("approuverPopup").style.display = "none";
                        }
                    });

                    document.getElementById("approuverBtn").addEventListener("click", function() {
                        popContainer.style.display = "none";
                        popupT.style.display = "none";
                        document.getElementById("approuverPopup").style.display = "flex";
                        popContainer1.style.display = "flex";
                        const userId = parseInt($('#popupId').val());
                        $('#approuverPopup input[name="id"]').val(userId);
                    });

                    $(document).ready(function() {
                        $.ajax({
                            url: 'index.php?router=getCartes',
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
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

                    $(document).ready(function() {
                        $('#approuverUser').on('click', function(event) {
                            event.preventDefault();
                            const formData = new FormData($('#formApprouver')[0]);
                            $.ajax({
                                url: 'index.php?router=approuver',
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response == 1) {
                                        alert('Utilisateur approuvé avec succès !');
                                        popContainer1.style.display = "none";
                                        document.getElementById("approuverPopup").style.display = "none";
                                        $('#popupType').text('Membre');
                                        $("#approuveTd").text("Membre");
                                    } else {
                                        alert(response);
                                    }
                                },
                                error: function() {
                                    alert('Erreur!');
                                }
                            });
                        });
                    });
                    function handleUserBlock(user){
                        $.ajax({
                                url: 'index.php?router=bloquer',
                                type: 'POST',
                                data: {username:user.username, email:user.email, nom:user.nom, prenom:user.prenom},
                                dataType: 'json',
                                success: function(response) {
                                    if (response == 1) {
                                        alert('Utilisateur bloqué avec succès !');
                                        popContainer1.style.display = "none";
                                        document.getElementById("approuverPopup").style.display = "none";
                                        location.reload();
                                    } else {
                                        console.log(response);
                                        
                                    }
                                },
                                error: function(xhr, status, error) {
                                    
                                    console.error('Error fetching users:', error);
                                }
                            });
                    }

                    function fetchUsers() {
                        const searchValue = $('#seachBar').val();
                        const dateMin = $('#dateMin').val();
                        const dateMax = $('#dateMax').val();
                        const filterType = $('#filtreUsers').val();

                        $.ajax({
                            url: 'index.php?router=searchUser',
                            type: 'POST',
                            data: {
                                searchUser: searchValue,
                                dateMin: dateMin,
                                dateMax: dateMax,
                                filterType: filterType
                            },
                            dataType: 'json',
                            success: function(data) {
                                $('#all tr:not(.head)').remove();
                                const usersTable = $('#all');
                                data.forEach(function(user) {
                                    usersTable.append('<tr>' +
                                        '<td>' + user['username'] + '</td>' +
                                        '<td>' + user['email'] + '</td>' +
                                        '<td>' + user['nom'] + '</td>' +
                                        '<td>' + user['prenom'] + '</td>' +
                                        '<td>' + user['date_inscription'] + '</td>' +
                                        '<td id="approuveTd">' + (user['approuve'] ? 'Membre' : 'User') + '</td>' +
                                        '<td><button class="action-btn" onclick=\'handleUserAction(' + JSON.stringify(user) + ')\'>Détails</button></td>' +
                                        '<td><button class="action-btn" onclick=\'handleUserBlock(' + JSON.stringify(user) + ')\'>Bloquer</button></td>' +
                                    '</tr>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching users:', error);
                            }
                        });
                    }

                    function sortTable(column) {
                        let order = $(this).data('order') || 'asc';
                        const rows = $('#all tr:not(.head)').get();
                        
                        rows.sort(function(a, b) {
                            const A = $(a).children('td').eq(getColumnIndex(column)).text().toLowerCase();
                            const B = $(b).children('td').eq(getColumnIndex(column)).text().toLowerCase();
                            
                            if (order === 'asc') {
                                return A.localeCompare(B);
                            } else {
                                return B.localeCompare(A);
                            }
                        });
                        
                        $.each(rows, function(index, row) {
                            $('#all').append(row);
                        });
                        
                        $(this).data('order', order === 'asc' ? 'desc' : 'asc');
                    }

                    function getColumnIndex(column) {
                        switch (column) {
                            case 'username': return 0;
                            case 'email': return 1;
                            case 'nom': return 2;
                            case 'prenom': return 3;
                            case 'date': return 4;
                            default: return 0;
                        }
                    }
                </script>
                <style>
                    form.searchBar {
                        display: flex;
                        justify-content: space-between;
                        gap: 40px;
                        padding: 0;
                    }
                    form.searchBar div.searchBar {
                        width: 100%;
                        display: flex;
                        gap: 8px;
                        align-items: center;
                    }
                    form.searchBar .filtresTri {
                        display: flex;
                        justify-content: space-between;
                        gap: 10px;
                    }
                    form.searchBar .filtresTri select {
                        width: fit-content;
                    }
                    div.searchBar i {
                        color: #001a23;
                        opacity: 0.4;
                    }
                    div.searchBar,
                    select {
                        border-radius: 6px;
                        background: #f3f3f3;
                        padding: 8px 8px;
                        border: 0;
                        color: #001a23;
                        opacity: 0.8;
                        outline: none;
                        font-size: 12px;
                        font-weight: 500;
                    }
                    input {
                        font-size: 12px;
                        border: none;
                        outline: none;
                        font-weight: 500;
                        flex-grow: 1;
                        background-color: transparent;
                    }
                    input::placeholder {
                        color: #001a23;
                        opacity: 0.2;
                        font-size: 12px;
                    }
                    select {
                        font-weight: 500;
                    }
                </style>
            </body>
        </html>
        <?php
    }
}
?>
