// Premier event ready avec tous les événements
$(document).ready(function() {
    fetchOffres();
    $('#seachBar').on('keyup', fetchOffres);
    
    // Correction de la syntaxe pour multiple sélecteurs
    $('#wilayas, #categories, #type').on('change', fetchOffres);
    
    // Déplacer l'appel AJAX des catégories ici
    loadCategories();
});

// Fonction pour charger les catégories
function loadCategories() {
    $.ajax({
        url: 'index.php?router=categories',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const categoriesSelect = $('#categories');
            data.forEach(function(categ) {
                categoriesSelect.append('<option value="' + categ.nomcateg + '">' + categ.nomcateg + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching categories:', error);
        }
    });
}

function fetchOffres() {
    const searchValue = $('#seachBar').val();
    const categorie = $('#categories').val();
    const ville = $('#wilayas').val();
    const type = $('#type').val();

    $.ajax({
        url: 'index.php?router=searchOffres',
        type: 'POST',
        data: {
            searchOffre: searchValue,
            filterVille: ville,
            filterCategorie: categorie,
            filterType: type,
        },
        dataType: 'json',
        success: function(data) {
            updateOffresTable(data);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching offers:', error);
        }
    });
}

// Nouvelle fonction pour mettre à jour la table
function updateOffresTable(data) {
    const offresTable = $('#offersTable');
    offresTable.find('tr:not(.head)').remove();
    
    data.forEach(function(offre) {
        offresTable.append(`<tr>
            <td>${offre.partenaireVille}</td>
            <td>${offre.partenaireCategorie}</td>
            <td>${offre.partenaireNom}</td>
            <td>${offre.offreContenu}</td>
        </tr>`);
    });
}

function sortTable(column) {
    const table = $('#offersTable');
    const rows = table.find('tr:not(.head)').get();
    const currentOrder = table.data('order') || 'asc';
    const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
    
    rows.sort(function(a, b) {
        const A = $(a).children('td').eq(getColumnIndex(column)).text().toLowerCase();
        const B = $(b).children('td').eq(getColumnIndex(column)).text().toLowerCase();
        
        return currentOrder === 'asc' 
            ? A.localeCompare(B) 
            : B.localeCompare(A);
    });
    
    rows.forEach(function(row) {
        table.append(row);
    });
    
    table.data('order', newOrder);
}

function getColumnIndex(column) {
    const columns = {
        'partenaireVille': 0,
        'partenaireCategorie': 1,
        'partenaireNom': 2,
        'offreContenu': 3
    };
    return columns[column] || 0;
}