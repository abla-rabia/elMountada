<?php
require_once(ROOT . '/Controller/EventAnnonceController.php');
require_once("commonViews.php");

class evenementView {
    public function entetePage() {
        ?>
        <head>
            <title>Événements</title>
            <link rel="stylesheet" href="View/css/catalogueStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="View/scripts/evenementScript.js"></script>
        </head>
        <?php
    }
    public function searchBar() {
        ?>
        <form action="" class="searchBar">
            <div class="searchBar">
                <i class="fas fa-search"></i>
                <input type="text" name="search" id="seachBar" placeholder="Rechercher un événement">
            </div>
            
        </form>
        <?php
    }

    public function afficher_event($titre, $description, $date, $image = "View/assets/slider1.png") {
        ?>
        <div class="event-row" style="display: flex; align-items: center; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 10px; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <div class="event-image" style="flex: 1; padding: 10px;">
                <img src="<?php echo $image; ?>" alt="Image de l'événement" style="width: 100%; height: auto; border-radius: 10px;">
            </div>
            
            <div class="event-details" style="flex: 2; padding: 10px; display: flex; flex-direction: column;">
                <h2 style="margin: 0 0 10px 0; font-family: 'Montserrat', sans-serif;"><?php echo $titre; ?></h2>
                <p style="margin: 0 0 10px 0; font-size: 14px; color: #555;"><?php echo $description; ?></p>
                <p style="margin: 0; font-weight: bold; color: #333;">Date : <?php echo $date; ?></p>
            </div>
            
            <div class="event-action" style="flex: 1; padding: 10px; display: flex; align-items: center; justify-content: center;">
                <button style="background-color: #28a745; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;">
                    Être bénévole
                </button>
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
                <?php
                $r->navBar();
                $r->titre("Catalogue des événements");
                ?>
                <div id="search-bar-container">
                    <?php $this->searchBar(); ?>
                </div>
                <div id="event-list"></div> <!-- Conteneur des événements -->
                <script>
                    $(document).ready(function() {
                        // Appel AJAX pour récupérer les événements
                        $.ajax({
                            url: "index.php?router=getEventsActivities",
                            method: "GET",
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                            data.events.forEach(function(event) {
                                $('#event-list').append(`
                                    <div class="event-row" style="display: flex; align-items: center; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 10px; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                        <div class="event-image" style="flex: 1; padding: 10px;">
                                            <img src="${event.photo}" alt="Image de l'événement" style="width: 100%; height: auto; border-radius: 10px;">
                                        </div>
                                        <div class="event-details" style="flex: 2; padding: 10px; display: flex; flex-direction: column;">
                                            <h2 style="margin: 0 0 10px 0; font-family: 'Montserrat', sans-serif;">${event.nom}</h2>
                                            <p style="margin: 0 0 10px 0; font-size: 14px; color: #555;">${event.description}</p>
                                            <p style="margin: 0; font-weight: bold; color: #333;">Date : ${event.date_event}</p>
                                            <p style="margin: 0; font-weight: bold; color: #333;">Type : Événement</p>
                                        </div>
                                        <div class="event-action" style="flex: 1; padding: 10px; display: flex; align-items: center; justify-content: center;">
                                            <button onclick="approuver(${event.id})" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;">
                                                Être bénévole
                                            </button>
                                        </div>
                                    </div>
                                `);
                            });

                            data.activities.forEach(function(activity) {
                                $('#event-list').append(`
                                    <div class="event-row" style="display: flex; align-items: center; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 10px; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                        <div class="event-image" style="flex: 1; padding: 10px;">
                                            <img src="${activity.photo}" alt="Image de l'activité" style="width: 100%; height: auto; border-radius: 10px;">
                                        </div>
                                        <div class="event-details" style="flex: 2; padding: 10px; display: flex; flex-direction: column;">
                                            <h2 style="margin: 0 0 10px 0; font-family: 'Montserrat', sans-serif;">${activity.nom}</h2>
                                            <p style="margin: 0 0 10px 0; font-size: 14px; color: #555;">${activity.description}</p>
                                            <p style="margin: 0; font-weight: bold; color: #333;">Date : ${activity.date_activite}</p>
                                            <p style="margin: 0; font-weight: bold; color: #333;">Type : Activité</p>
                                        </div>
                                        <div class="event-action" style="flex: 1; padding: 10px; display: flex; align-items: center; justify-content: center;">
                                            <button onclick="approuver2(${activity.id})" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;">
                                                Être bénévole
                                            </button>
                                        </div>
                                    </div>
                                `);
                            });
                            },
                            error: function(err) {
                                console.error("Erreur lors de la récupération des événements :", err);
                            }
                        });
                    });
                    function approuver(id) {
                        $.ajax({
                            url: "index.php?router=approuverBenevolat",
                            method: "POST",
                            data: { id: id },
                            success: function(response) {
                                console.log(response);
                                alert("Votre demande pour être bénévole a été envoyée avec succès.");
                            },
                            error: function(err) {
                                console.error("Erreur lors de l'envoi de la demande :", err);
                                alert("Une erreur est survenue lors de l'envoi de votre demande. Veuillez réessayer.");
                            }
                        });
                    }
                    function approuver2(id) {
                        $.ajax({
                            url: "index.php?router=approuverBenevolat2",
                            method: "POST",
                            data: { id: id },
                            success: function(response) {
                                console.log(response);
                                alert("Votre demande pour être bénévole a été envoyée avec succès.");
                            },
                            error: function(err) {
                                console.error("Erreur lors de l'envoi de la demande :", err);
                                alert("Une erreur est survenue lors de l'envoi de votre demande. Veuillez réessayer.");
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
