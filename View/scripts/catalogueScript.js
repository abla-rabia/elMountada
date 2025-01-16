$(document).ready(function () {
    // Function to load and display filtered partners
    function loadFilteredPartners(searchParams) {
        const isEmptySearch = !searchParams.searchPartenaire && 
                            (!searchParams.filterVille || searchParams.filterVille === "0") && 
                            (!searchParams.filterCategorie || searchParams.filterCategorie === "0");

        if (isEmptySearch) {
            loadInitialContent();
            return;
        }

        $.ajax({
            url: 'index.php?router=searchPart',
            type: 'POST',
            data: searchParams,
            success: function (response) {
                console.log('Search response:', response);
                $('.cartesPartenaire').empty();
                $('.category-container').hide();
                $('.sections').empty(); // Clear all sections before adding new ones

                if (response.length === 0) {
                    $('.sections').append(
                        $('<div>').addClass('no-results')
                               .text('Aucun partenaire trouvé')
                    );
                    return;
                }

                // Group partners by category first
                const partnersByCategory = {};
                response.forEach(function(partenaire) {
                    if (!partnersByCategory[partenaire.categorie]) {
                        partnersByCategory[partenaire.categorie] = [];
                    }
                    partnersByCategory[partenaire.categorie].push(partenaire);
                });

                // Create and populate category containers
                Object.keys(partnersByCategory).forEach(function(categorie) {
                    const sections = $('.sections');
                    const categoryContainer = $('<div>')
                        .addClass('category-container')
                        .attr('id', `category-${categorie}`);
                    sections.append(categoryContainer);

                    // Get section title
                    $.ajax({
                        url: `index.php?router=getSection&categorie=${categorie}`,
                        type: 'GET',
                        success: function(sectionHtml) {
                            categoryContainer.append(sectionHtml);
                            
                            // Create cartes partenaire container
                            const cartesPartenaire = $('<div>').addClass('cartesPartenaire');
                            categoryContainer.append(cartesPartenaire);
                            
                            // Add partner cards
                            partnersByCategory[categorie].forEach(function (partenaire) {
                                let remise = "";
                                //load d'une remise
                                $.ajax({
                                    url: `index.php?router=getRemiseByPartenaireId`,
                                    type: 'GET',
                                    dataType: 'json',
                                    data: {'id': partenaire.id},
                                    success: function (data) {
                                        console.log("hillo");
                                        remise = data.remise;
                                        
                                    }
                                });
                                const descriptionWords = partenaire.description.split(' ');
                                const shortDescription = descriptionWords.slice(0, 10).join(' ') + (descriptionWords.length > 10 ? '...' : '');
                                console.log(partenaire.photo);
                                $.ajax({
                                    url: `index.php?router=getPartCarte&partenaireId=${partenaire.id}&partenaireNom=${partenaire.nom}&partenaireDescription=${shortDescription}&partenairePhoto=${partenaire.photo}&remise=${remise}`,
                                    type: 'GET',
                                    success: function(cardHtml) {
                                        cartesPartenaire.append(cardHtml);
                                    }
                                });
                                
                            });
                            if (partnersByCategory[categorie].length === 2) {
                                cartesPartenaire.css({
                                    'justify-content': 'flex-start',
                                    'gap': '8vw'
                                });
                            }
                        }
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la recherche:', error);
            }
        });
    }
    // Function to load initial content
    function loadInitialContent() {
        $('.sections').empty(); // Vider complètement les sections
        
        $.ajax({
            url: 'index.php?router=categories',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const sections = $('.sections');
                data.forEach(function(categorie) {
                    const categoryContainer = $('<div>')
                        .addClass('category-container')
                        .attr('id', `category-${categorie.nomcateg}`);
                    sections.append(categoryContainer);

                    $.ajax({
                        url: `index.php?router=getSection&categorie=${categorie.nomcateg}`,
                        type: 'GET',
                        success: function(sectionHtml) {
                            categoryContainer.append(sectionHtml);
                            $.ajax({
                                url: 'index.php?router=getPartCateg',
                                type: 'POST',
                                data: { 'categorie': categorie.nomcateg },
                                
                                success: function (response) {
                                    const cartesPartenaire = $('<div>').addClass('cartesPartenaire');
                                    categoryContainer.append(cartesPartenaire);
                                    console.log(response);
                                    
                                    
                                    // Show max 3 partners
                                    response.slice(0, 3).forEach(function (partenaire) {
                                        let remise = "";
                                        $.ajax({
                                            url: `index.php?router=getRemiseByPartenaireId`,
                                            type: 'GET',
                                            dataType: 'json',
                                            data: {'id': partenaire.id},
                                            success: function (data) {
                                                remise = data.remise;
                                                
                                            
                                        
                                        const descriptionWords = partenaire.description.split(' ');
                                        const shortDescription = descriptionWords.slice(0, 10).join(' ') + (descriptionWords.length > 10 ? '...' : '');
                                                console.log("remise : ", remise);
                                                console.log(partenaire.photo);
                                        $.ajax({
                                            url: `index.php?router=getPartCarte&partenaireId=${partenaire.id}&partenaireNom=${partenaire.nom}&partenaireDescription=${shortDescription}&partenairePhoto=${partenaire.photo}&remise=${remise}`,
                                            type: 'GET',
                                            success: function(cardHtml) {
                                                cartesPartenaire.append(cardHtml);
                                            }
                                        });
                                    }
                                });
                                    });

                                    // Check if response length is 2
                                    if (response.length === 2) {
                                        cartesPartenaire.css({
                                            'justify-content': 'flex-start',
                                            'gap': '8vw'
                                        });
                                    }
                                    if (response.length === 0) {
                                        categoryContainer.remove();
                                    }
                                },
                                error: function() {
                                    alert('Erreur!');
                                }
                            });
                        }
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching categories:', error);
            }
        });
    }

    // Charge le contenu initial au chargement de la page
    loadInitialContent();

    // Empêcher la soumission du formulaire de recherche
    $('.searchBar').on('submit', function(e) {
        e.preventDefault();
        return false;
    });

    // Search bar event listener with debounce
    let searchTimeout;
    $('#seachBar').on('input', function() {
        const searchValue = $(this).val();
        clearTimeout(searchTimeout);
        
        // Supprimer le message "Aucun partenaire trouvé" s'il existe
        $('.no-results').remove();
        
        searchTimeout = setTimeout(function() {
            const searchParams = {
                searchPartenaire: searchValue.trim(),
                filterVille: $('#wilayas').val() !== "0" ? $('#wilayas').val() : "",
                filterCategorie: $('#categories').val() !== "0" ? $('#categories').val() : ""
            };
            loadFilteredPartners(searchParams);
        }, 300);
    });

    // Wilaya filter event listener
    $('#wilayas').on('change', function() {
        const searchParams = {
            searchPartenaire: $('#seachBar').val().trim(),
            filterVille: $(this).val() !== "0" ? $(this).val() : "",
            filterCategorie: $('#categories').val() !== "0" ? $('#categories').val() : ""
        };
        loadFilteredPartners(searchParams);
    });
    // Remplacez le gestionnaire de tri existant par celui-ci
$('#tri').on('change', function () {
    const filterType = $(this).val();
    if (filterType === "0") {
        loadInitialContent();
        return;
    }
    if (filterType === "1") { // Tri par wilaya
        // Vider les sections existantes
        $('.sections').empty();

        // Récupérer tous les partenaires
        $.ajax({
            url: 'index.php?router=getPartenaires',
            type: 'GET',
            success: function(response) {
                // Grouper les partenaires par ville
                const partnersByCity = {};
                response.forEach(function(partenaire) {
                    if (!partnersByCity[partenaire.ville]) {
                        partnersByCity[partenaire.ville] = [];
                    }
                    partnersByCity[partenaire.ville].push(partenaire);
                });

                // Trier les villes selon l'ordre
                const sortedCities = Object.keys(partnersByCity).sort(function(a, b) {
                    return  a.localeCompare(b) ;
                });

                // Créer les sections pour chaque ville
                sortedCities.forEach(function(ville) {
                    const sections = $('.sections');
                    const cityContainer = $('<div>')
                        .addClass('category-container')
                        .attr('id', `city-${ville}`);
                    sections.append(cityContainer);

                    // Créer le titre de la section ville
                    const sectionTitle = $('<div>')
                        .addClass('section-title')
                        .text(ville);
                    cityContainer.append(sectionTitle);

                    // Créer le conteneur des cartes
                    const cartesPartenaire = $('<div>').addClass('cartesPartenaire');
                    cityContainer.append(cartesPartenaire);
                    
                    // Ajouter les cartes des partenaires
                    partnersByCity[ville].forEach(function (partenaire) {
                        let remise = "";
                        $.ajax({
                            url: `index.php?router=getRemiseByPartenaireId`,
                            type: 'GET',
                            dataType: 'json',
                            data: {'id': partenaire.id},
                            success: function(data) {
                                remise = data.remise;
                            }
                        });
                        const descriptionWords = partenaire.description.split(' ');
                        const shortDescription = descriptionWords.slice(0, 10).join(' ') + (descriptionWords.length > 10 ? '...' : '');
                        console.log(partenaire.photo);
                        $.ajax({
                            url: `index.php?router=getPartCarte&partenaireId=${partenaire.id}&partenaireNom=${partenaire.nom}&partenaireDescription=${shortDescription}&partenairePhoto=${partenaire.photo}&remise=${remise}`,
                            type: 'GET',
                            success: function(cardHtml) {
                                cartesPartenaire.append(cardHtml);
                            }
                        });
                    });
                    if (partnersByCity[ville].length === 2) {
                        cityContainer.css({
                            'justify-content': 'flex-start',
                            'gap': '8vw'
                        });
                    }
                });
            }
        });
    } else if (filterType === "2") { // Tri par catégorie
        const categSections = $('.category-container').toArray();
        categSections.sort(function(a, b) {
            const A = $(a).find('.section-title').text().toLowerCase();
            const B = $(b).find('.section-title').text().toLowerCase();
            return  A.localeCompare(B) ;
        });

        $('.sections').empty().append(categSections);
    }
});

    // Category filter event listener
    $('#categories').on('change', function() {
        const searchParams = {
            searchPartenaire: $('#seachBar').val().trim(),
            filterVille: $('#wilayas').val() !== "0" ? $('#wilayas').val() : "",
            filterCategorie: $(this).val() !== "0" ? $(this).val() : ""
        };
        loadFilteredPartners(searchParams);
    });


    //fonction pour charger les categories pour le filtre 
    $(document).ready(function() {
        $.ajax({
            url: 'index.php?router=categories',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const categs = $('#categories');
                data.forEach(function(cat) {
                    categs.append('<option value="' + cat['nomcateg'] + '">' + cat['nomcateg'] + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching users:', error);
            }
        });
    });
});