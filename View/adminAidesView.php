<?php
require_once(ROOT . '/Controller/donsBenevolatsAidesController.php');
require_once("commonViews.php");

class adminAidesView {
    public function entetePage() {
        ?>
        <head>
            <title>Gestion des aides</title>
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

    public function searchBar() {
        ?>
        <form action="" id="aides" class="searchBar">
            <div class="searchBar">
                <i class="fas fa-search"></i>
                <input type="text" onkeyup="fetchAides()" name="search" id="searchBar" placeholder="Rechercher une aide">
            </div>
            <div class="filtresTri">
                <input onchange="fetchAides()" type="date" id="dateMin" name="dateMin" style="background: #f3f3f3;border-radius:4px;">
                <input onchange="fetchAides()" type="date" id="dateMax" name="dateMax" style="background: #f3f3f3;border-radius:4px;">
                <select name="filtreAides" id="filtreAides" onchange="fetchAides()">
                    <option value="0">Tous les types</option>
                </select>
            </div>
        </form>
        <?php
    }

    public function aidePopup() {
        $r = new commonViews();
        ?>
        <div class="popContainer">
            <div class="popupUpload" id="aidePopup">
                <h3>Information de l'aide</h3>
                <div class="textArea">
                    <p>Nom : <span id="popupNom"></span></p>
                    <p>Prénom : <span id="popupPrenom"></span></p>
                    <p>Description : <span id="popupDescription"></span></p>
                    <p>Type d'aide : <span id="popupType"></span></p>
                    <p style="display: flex; justify-content:space-between;">Dossier : <button type='button' id='fileDossier'>Télécharger le dossier</button></p>
                </div>
                <?php $r->blueButton2("Fermer", "closeAideBtn"); ?>
            </div>
        </div>
        <?php
    }

    public function addTypeAidePopup() {
        $r = new commonViews();
        ?>
        <div class="popContainer">
            <div class="popupUpload" id="typeAidePopup">
                <h3>Ajouter un type d'aide</h3>
                <div class="textArea">
                    <form action="" class="addTypeAide" id="formAddTypeAide">
                        <div class="input-group">
                            <label for="nomType">Nom du type:</label>
                            <input type="text" name="nom" id="nomType" required>
                        </div>
                        <div class="input-group">
                            <label for="descriptionType">Description:</label>
                            <textarea name="description" id="descriptionType" required></textarea>
                        </div>
                    </form>
                </div>
                <?php
                $r->blueButton2("Confirmer", "addTypeAide");
                ?>
                <br>
                <br>
                <?php
                $r->blueButton2("Annuler", "closeTypeAideBtn");
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
                <?php $r->navBarC(); ?>
                <div class="content">
                    <div class="head" style="display:flex;justify-content:space-between;">
                    <?php $r->titre("Liste des aides"); ?>
                    <div class="header-actions">
                                <button id="addTypeAideBtn" class="blue-btn">Ajouter un type d'aide</button>
                    
                    </div>
                    </div>
                    <div class="subContent">
                        <?php $r->adminSideBar("Aides"); ?>
                        <div class="users">
                            
                            
                            <table id="all">
                                <tr class="head">
                                    <th onclick="sortTable('nom')">Nom</th>
                                    <th onclick="sortTable('prenom')">Prénom</th>
                                    <th onclick="sortTable('type')">Type d'aide</th>
                                    <th onclick="sortTable('date')">Date de demande</th>
                                    <th>Action</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php $this->aidePopup(); ?>
                <?php $this->addTypeAidePopup(); ?>
                <script>
                    $(document).ready(function() {
                        fetchAides();
                        loadTypeAides();
                        $('#searchBar').on('keyup', fetchAides);
                        $('#dateMin, #dateMax, #filtreAides').on('change', fetchAides);
                    });

                    function loadTypeAides() {
                        $.ajax({
                            url: 'index.php?router=typesAide',
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                const typeSelect = $('#filtreAides');
                                data.forEach(function(type) {
                                    typeSelect.append('<option value="' + type.id + '">' + type.nom + '</option>');
                                });
                            }
                        });
                    }

                    function handleAideAction(aide) {
                        $('#popupNom').text(aide.nom);
                        $('#popupPrenom').text(aide.prenom);
                        $('#popupDescription').text(aide.description);
                        $('#popupType').text(aide.type_aide);
                        
                        $('#fileDossier').on('click', function() {
                            window.location.href = aide.dossier;
                        });
                        
                        $('.popContainer').first().css('display', 'flex');
                        $('#aidePopup').show();
                    }

                    // Close popups
                    $('#closeAideBtn').click(function() {
                        $('.popContainer').first().hide();
                        $('#aidePopup').hide();
                    });

                    $('#closeTypeAideBtn').click(function() {
                        $('.popContainer').last().hide();
                        $('#typeAidePopup').hide();
                    });

                    // Show add type aide popup
                    $('#addTypeAideBtn').click(function() {
                        $('.popContainer').last().css('display', 'flex');
                        $('#typeAidePopup').show();
                    });

                    // Add type aide
                    $('#addTypeAide').click(function(e) {
                        e.preventDefault();
                        const formData = new FormData($('#formAddTypeAide')[0]);
                        
                        $.ajax({
                            url: 'index.php?router=addTypeAide',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response == 1) {
                                    alert('Type d\'aide ajouté avec succès!');
                                    $('.popContainer').last().hide();
                                    $('#typeAidePopup').hide();
                                    $('#formAddTypeAide')[0].reset();
                                    loadTypeAides();
                                } else {
                                    alert(response);
                                }
                            },
                            error: function() {
                                alert('Erreur lors de l\'ajout du type d\'aide');
                            }
                        });
                    });

                    function fetchAides() {
                        const searchValue = $('#searchBar').val();
                        const dateMin = $('#dateMin').val();
                        const dateMax = $('#dateMax').val();
                        const filterType = $('#filtreAides').val();

                        $.ajax({
                            url: 'index.php?router=getAides',
                            type: 'POST',
                            data: {
                                search: searchValue,
                                dateMin: dateMin,
                                dateMax: dateMax,
                                typeAide: filterType
                            },
                            dataType: 'json',
                            success: function(data) {
                                $('#all tr:not(.head)').remove();
                                const aidesTable = $('#all');
                                data.forEach(function(aide) {
                                    aidesTable.append('<tr>' +
                                        '<td>' + aide.nom + '</td>' +
                                        '<td>' + aide.prenom + '</td>' +
                                        '<td>' + aide.type_aide + '</td>' +
                                        '<td>' + aide.date_demande + '</td>' +
                                        '<td><button class="action-btn" onclick=\'handleAideAction(' + JSON.stringify(aide) + ')\'>Voir détails</button></td>' +
                                    '</tr>');
                                });
                            }
                        });
                    }

                    function sortTable(column) {
                        const rows = $('#all tr:not(.head)').get();
                        const order = $(this).data('order') || 'asc';
                        
                        rows.sort(function(a, b) {
                            const A = $(a).children('td').eq(getColumnIndex(column)).text().toLowerCase();
                            const B = $(b).children('td').eq(getColumnIndex(column)).text().toLowerCase();
                            
                            return order === 'asc' ? A.localeCompare(B) : B.localeCompare(A);
                        });
                        
                        $.each(rows, function(index, row) {
                            $('#all').append(row);
                        });
                        
                        $(this).data('order', order === 'asc' ? 'desc' : 'asc');
                    }

                    function getColumnIndex(column) {
                        const columns = {
                            'nom': 0,
                            'prenom': 1,
                            'type': 2,
                            'date': 3
                        };
                        return columns[column] || 0;
                    }
                </script>
                <style>
                    
                    
                    .blue-btn {
                        background-color: #001a23;
                        color: white;
                        border: none;
                        padding: 10px 20px;
                        border-radius: 6px;
                        cursor: pointer;
                        font-size: 14px;
                    }

                    .blue-btn:hover {
                        background-color:#001a23;
                    }

                    .input-group {
                        margin-bottom: 15px;
                    }

                    .input-group label {
                        display: block;
                        margin-bottom: 5px;
                        font-size: 12px;
                        color: #001a23;
                        font-weight: 500;
                    }

                    .input-group input,
                    .input-group textarea {
                        width: 100%;
                        padding: 8px;
                        border-radius: 6px;
                        border: 1px solid #eff0f6;
                        background: #f3f3f3;
                    }

                    .input-group textarea {
                        height: 100px;
                        resize: vertical;
                    }

                    /* Include all existing styles from the users page */
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