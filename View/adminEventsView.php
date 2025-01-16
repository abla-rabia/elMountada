<?php
require_once(ROOT . '/Controller/EventAnnonceController.php');
require_once("commonViews.php");

class adminEventsView {
    public function entetePage() {
        ?>
        <head>
            <title>Gestion des événements</title>
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
                
/* Table Container */
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
table#allEvents th {
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

table#allEvents th:hover {
    background: #edf2f7;
}

table#allEvents th:after {
    content: '↕';
    position: absolute;
    right: 8px;
    opacity: 0.3;
}

/* Table Cells */
table#allEvents td {
    padding: 14px 16px;
    border-bottom: 1px solid #edf2f7;
    color: #4a5568;
    font-weight: 500;
}

/* Table Rows */
table#allEvents tr:not(.head):hover {
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
    background:rgb(111, 160, 124);
}

/* Status Styles */
table#allEvents td:nth-child(6) {
    position: relative;
}

table#allEvents td:nth-child(6):before {
    content: '';
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 8px;
}

table#allEvents td:nth-child(6):contains('Membre'):before {
    background-color: #34d399;
}

table#allEvents td:nth-child(6):contains('User'):before {
    background-color: #fbbf24;
}

/* Responsive Design */
@media screen and (max-width: 1024px) {
    table#allEvents {
        font-size: 13px;
    }
    
    table#allEvents th, 
    table#allEvents td {
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
    
    table#allEvents {
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

    public function eventPopup() {
        $r = new commonViews();
        ?>
        <div class="popContainer" style="display: none;">
            <div class="popupUpload" id="eventPopup">
                <h3>Ajouter un événement</h3>
                <div class="textArea">
                    <form action="" class="addEvent" id="formAddEvent" method="POST">
                        <div class="input-group">
                            <label for="nomEvent">Nom de l'événement:</label>
                            <input type="text" name="nom" id="nomEvent" required>
                        </div>
                        <div class="input-group">
                            <label for="descriptionEvent">Description:</label>
                            <textarea name="description" id="descriptionEvent" required></textarea>
                        </div>
                        <div class="input-group">
                            <label for="dateEvent">Date:</label>
                            <input type="date" name="date_event" id="dateEvent" required>
                        </div>
                        <div class="fileUpload">
                            <label class="fmsLabel" for="photo">Photo</label>
                            <input type="file" name="photo" id="photo" accept=".pdf,.jpg,.jpeg,.png">
                        </div><br><br>
                        <div class="button-group">
                            <?php
                            $r->blueButton2("Confirmer", "addEvent");?>
                            <br><br>
                            <?php
                            $r->blueButton2("Annuler", "closeEventBtn");
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
                        <?php $r->titre("Liste des événements"); ?>
                        <div class="header-actions">
                            <button id="addEventBtn" class="action-btn">Ajouter un événement</button>
                        </div>
                    </div>
                    <div class="subContent">
                        <?php $r->adminSideBar("Événements"); ?>
                        <div class="users">
                            <table id="allEvents">
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
                <?php $this->eventPopup(); ?>
                <script>
                    $(document).ready(function() {
                        fetchEvents();

                        $('#addEventBtn').click(function() {
                            $('.popContainer').fadeIn();
                            $('#eventPopup').fadeIn();
                        });

                        $('#closeEventBtn').click(function() {
                            $('.popContainer').fadeOut();
                            $('#eventPopup').fadeOut();
                            $('#formAddEvent')[0].reset();
                        });

                        $(document).on('click', '#addEvent', function(e) {
                            e.preventDefault();
                            if (!$('#formAddEvent')[0].checkValidity()) {
                                $('#formAddEvent')[0].reportValidity();
                                return;
                            }

                            const formData = new FormData($('#formAddEvent')[0]);
                            
                            $.ajax({
                                url: 'index.php?router=addEvent',
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                        console.log(response);
                                            alert('Événement ajouté avec succès!');
                                            $('.popContainer').fadeOut();
                                            $('#eventPopup').fadeOut();
                                            $('#formAddEvent')[0].reset();
                                            fetchEvents();
                                },
                                error: function() {
                                    alert('Erreur de connexion au serveur');
                                }
                            });
                        });

                        // Close popup when clicking outside
                        $('.popContainer').click(function(e) {
                            if (e.target === this) {
                                $('.popContainer').fadeOut();
                                $('#eventPopup').fadeOut();
                                $('#formAddEvent')[0].reset();
                            }
                        });
                    });

                    function fetchEvents() {
                        $.ajax({
                            url: 'index.php?router=getEvents',
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                
                                $('#allEvents tr:not(.head)').remove();
                                const eventsTable = $('#allEvents');
                                data.forEach(function(event) {
                                    const formattedDate = new Date(event.date_event).toLocaleDateString();
                                    eventsTable.append('<tr>' +
                                        '<td>' + event.nom + '</td>' +
                                        '<td>' + event.description + '</td>' +
                                        '<td>' + formattedDate + '</td>' +
                                        '<td><button class="action-btn">Voir détails</button></td>' +
                                    '</tr>');
                                });
                            },
                            error: function() {
                                console.log(data);
                                alert('Erreur lors de la récupération des événements');
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