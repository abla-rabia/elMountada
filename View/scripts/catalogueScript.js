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
                            partnersByCategory[categorie].forEach(function(partenaire) {
                                $.ajax({
                                    url: `index.php?router=getPartCarte&partenaireId=${partenaire.id}&partenaireNom=${partenaire.nom}&partenaireDescription=${partenaire.description}`,
                                    type: 'GET',
                                    success: function(cardHtml) {
                                        cartesPartenaire.append(cardHtml);
                                    }
                                });
                            });
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
                                success: function(response) {
                                    const cartesPartenaire = $('<div>').addClass('cartesPartenaire');
                                    categoryContainer.append(cartesPartenaire);

                                    response.forEach(function(partenaire) {
                                        $.ajax({
                                            url: `index.php?router=getPartCarte&partenaireId=${partenaire.id}&partenaireNom=${partenaire.nom}&partenaireDescription=${partenaire.description}`,
                                            type: 'GET',
                                            success: function(sectionHtml) {
                                                cartesPartenaire.append(sectionHtml);
                                            }
                                        });
                                    });
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