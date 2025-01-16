<?php
require_once(ROOT . '/Controller/EventAnnonceController.php');
require_once("commonViews.php");

class adminActivitiesView {
    public function entetePage() {
        ?>
        <head>
            <title>Gestion des activités</title>
            <link rel="stylesheet" href="View/css/userInfosStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <style>
                .popContainer {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    z-index: 1000;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .popupUpload {
                    display: none;
                    background-color: white;
                    padding: 2rem;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    width: 90%;
                    max-width: 500px;
                }

                .input-group {
                    margin-bottom: 1rem;
                }

                .input-group label {
                    display: block;
                    margin-bottom: 0.5rem;
                }

                .input-group input,
                .input-group textarea {
                    width: 100%;
                    padding: 0.5rem;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                }

                .input-group textarea {
                    min-height: 100px;
                }

                .users {
                    background: white;
                    border-radius: 12px;
                    padding: 20px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                }

                table#all {
                    width: 100%;
                    border-collapse: separate;
                    border-spacing: 0;
                    margin-top: 20px;
                    font-size: 14px;
                }

                table#allActivities th {
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

                table#allActivities th:hover {
                    background: #edf2f7;
                }

                table#allActivities th:after {
                    content: '↕';
                    position: absolute;
                    right: 8px;
                    opacity: 0.3;
                }

                table#allActivities td {
                    padding: 14px 16px;
                    border-bottom: 1px solid #edf2f7;
                    color: #4a5568;
                    font-weight: 500;
                }

                table#allActivities tr:not(.head):hover {
                    background-color: #f8fafc;
                    transition: background-color 0.2s;
                }

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
                    background: rgb(104, 172, 122);
                }

                table#allActivities td:nth-child(6) {
                    position: relative;
                }

                table#allActivities td:nth-child(6):before {
                    content: '';
                    display: inline-block;
                    width: 8px;
                    height: 8px;
                    border-radius: 50%;
                    margin-right: 8px;
                }

                table#allActivities td:nth-child(6):contains('Membre'):before {
                    background-color: #34d399;
                }

                table#allActivities td:nth-child(6):contains('User'):before {
                    background-color: #fbbf24;
                }

                @media screen and (max-width: 1024px) {
                    table#allActivities {
                        font-size: 13px;
                    }

                    table#allActivities th,
                    table#allActivities td {
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

                    table#allActivities {
                        display: block;
                        overflow-x: auto;
                        white-space: nowrap;
                    }
                }
            </style>
            <script src="View/scripts/infosScript.js"></script>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        </head>
        <?php
    }

    public function activityPopup() {
        $r = new commonViews();
        ?>
        <div class="popContainer" style="display: none;">
            <div class="popupUpload" id="activityPopup">
                <h3>Ajouter une activité</h3>
                <div class="textArea">
                    <form action="" class="addActivity" id="formAddActivity" method="POST">
                        <div class="input-group">
                            <label for="nomActivity">Nom de l'activité:</label>
                            <input type="text" name="nom" id="nomActivity" required>
                        </div>
                        <div class="input-group">
                            <label for="descriptionActivity">Description:</label>
                            <textarea name="description" id="descriptionActivity" required></textarea>
                        </div>
                        <div class="input-group">
                            <label for="dateActivity">Date:</label>
                            <input type="date" name="date_activite" id="dateActivity" required>
                        </div>
                        <div class="fileUpload">
                            <label class="fmsLabel" for="photo">Photo</label>
                            <input type="file" name="photo" id="photo" accept=".pdf,.jpg,.jpeg,.png">
                        </div><br><br>
                        <div class="button-group">
                            <?php
                            $r->blueButton2("Confirmer", "addActivity");?>
                            <br><br>
                            <?php
                            $r->blueButton2("Annuler", "closeActivityBtn");
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    public function afficher_page() {
        $r = new commonViews();
        ?>
        <html>
            <?php $this->entetePage(); ?>
            <body>
                <?php $r->navBar(); ?>
                <div class="content">
                    <div class="head" style="display:flex;justify-content:space-between;">
                        <?php $r->titre("Liste des activités"); ?>
                        <div class="header-actions">
                            <button id="addActivityBtn" class="action-btn">Ajouter une activité</button>
                        </div>
                    </div>
                    <div class="subContent">
                        <?php $r->adminSideBar("Activités"); ?>
                        <div class="users">
                            <table id="allActivities">
                                <tr class="head">
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php $this->activityPopup(); ?>
                <script>
                    $(document).ready(function() {
                        fetchActivities();

                        $('#addActivityBtn').click(function() {
                            $('.popContainer').fadeIn();
                            $('#activityPopup').fadeIn();
                        });

                        $('#closeActivityBtn').click(function() {
                            $('.popContainer').fadeOut();
                            $('#activityPopup').fadeOut();
                            $('#formAddActivity')[0].reset();
                        });

                        $(document).on('click', '#addActivity', function(e) {
                            e.preventDefault();
                            if (!$('#formAddActivity')[0].checkValidity()) {
                                $('#formAddActivity')[0].reportValidity();
                                return;
                            }

                            const formData = new FormData($('#formAddActivity')[0]);
                            
                            $.ajax({
                                url: 'index.php?router=addActivite',
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    console.log(response);
                                    alert('Activité ajoutée avec succès!');
                                    $('.popContainer').fadeOut();
                                    $('#activityPopup').fadeOut();
                                    $('#formAddActivity')[0].reset();
                                    fetchActivities();
                                },
                                error: function() {
                                    alert('Erreur de connexion au serveur');
                                }
                            });
                        });

                        $('.popContainer').click(function(e) {
                            if (e.target === this) {
                                $('.popContainer').fadeOut();
                                $('#activityPopup').fadeOut();
                                $('#formAddActivity')[0].reset();
                            }
                        });
                    });

                    function fetchActivities() {
                        $.ajax({
                            url: 'index.php?router=getActivites',
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('#allActivities tr:not(.head)').remove();
                                const activitiesTable = $('#allActivities');
                                data.forEach(function(activity) {
                                    const formattedDate = new Date(activity.date_activite).toLocaleDateString();
                                    activitiesTable.append('<tr>' +
                                        '<td>' + activity.nom + '</td>' +
                                        '<td>' + activity.description + '</td>' +
                                        '<td>' + formattedDate + '</td>' +
                                        '<td><button class="action-btn">Voir détails</button></td>' +
                                    '</tr>');
                                });
                            },
                            error: function() {
                                alert('Erreur lors de la récupération des activités');
                            }
                        });
                    }
                </script>
            </body>
        </html>
        <?php
    }
}
?>
