// favoris.js
$(document).ready(function() {
    // Gérer les clics sur les icônes de favoris
    $(document).on('click', '.fa-heart', function(e) {
        e.preventDefault();
        const heartIcon = $(this);
        const cardContainer = heartIcon.closest('.cardContainer');
        const partenaire_id = cardContainer.attr('id');
        
        if (heartIcon.hasClass('fa-regular')) {
            // Ajouter aux favoris
            addToFavorites(partenaire_id, heartIcon);
        } else {
            // Retirer des favoris
            removeFromFavorites(partenaire_id, heartIcon);
        }
    });
});

function addToFavorites(partenaire_id, heartIcon) {
    $.ajax({
        url: 'index.php?router=addFavoris',
        type: 'POST',
        data: {
            id_partenaire: partenaire_id
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                heartIcon.removeClass('fa-regular').addClass('fa-solid');
                // Optionnel : Ajouter une animation ou un feedback
                heartIcon.css('color', 'red').fadeIn(100);
            } else {
                alert(response.message || 'Une erreur est survenue');
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de l\'ajout aux favoris');
        }
    });
}

function removeFromFavorites(partenaire_id, heartIcon) {
    $.ajax({
        url: 'index.php?router=deleteFavoris',
        type: 'POST',
        data: {
            id_partenaire: partenaire_id
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                heartIcon.removeClass('fa-solid').addClass('fa-regular');
                // Optionnel : Ajouter une animation ou un feedback
                heartIcon.css('color', 'white').fadeIn(100);
            } else {
                alert(response.message || 'Une erreur est survenue');
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la suppression des favoris');
        }
    });
}

// Fonction pour vérifier si un partenaire est dans les favoris
function checkIsFavorite(partenaire_id, heartIcon) {
    $.ajax({
        url: 'index.php?router=isInFavorites',
        type: 'POST',
        data: {
            id_partenaire: partenaire_id
        },
        dataType: 'json',
        success: function(response) {
            if (response.isFavorite) {
                heartIcon.removeClass('fa-regular').addClass('fa-solid');
                heartIcon.css('color', 'red');
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur lors de la vérification des favoris:', error);
        }
    });
}

// favorisLoad.js
$(document).ready(function() {
    loadFavoris();

    function loadFavoris() {
        $.ajax({
            url: 'index.php?router=getFavoris',
            type: 'GET',
            dataType: 'json',
            success: function(favoris) {
                const container = $('.cartesPartenaire');
                container.empty(); // Vide le conteneur avant d'ajouter les nouvelles cartes

                if (favoris.length === 0) {
                    container.append('<div class="no-favoris">Vous n\'avez pas encore de favoris</div>');
                    return;
                }

                favoris.forEach(function(favori) {
                    $.ajax({
                        url: 'index.php?router=getPartCarte',
                        type: 'GET',
                        data: {
                            partenaireId: favori.id,
                            partenaireNom: favori.nom,
                            partenaireDescription: favori.description,
                            remise: favori.remise || ''
                        },
                        success: function(carteHtml) {
                            container.append(carteHtml);
                        },
                        error: function (data, xhr, status, error) {
                            
                            console.error('Erreur lors du chargement de la carte:', error);
                        }
                    });
                });
            },
            error: function (data,xhr, status, error) {
                console.log(data);
                console.error('Erreur lors du chargement des favoris:', error);
                $('.cartesPartenaire').html('<div class="error">Erreur lors du chargement des favoris</div>');
            }
        });
    }
});