
$(document).ready(function() {
    fetchPartenaires();
    $('#seachBar').on('keyup', fetchPartenaires);
    $('#wilayas, #categories').on('change', fetchPartenaires);
});

//fonction pour le load des categories
$(document).ready(function() {
    $.ajax({
        url: 'index.php?router=categories',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const categoriesSelect = $('#categories');
            data.forEach(function(categ) {
                categoriesSelect.append('<option value="' + categ['nomcateg'] + '">' + categ['nomcateg'] + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching users:', error);
        }
    });
});


function fetchPartenaires() {
    const searchValue = $('#seachBar').val();
    const categorie = $('#categories').val();
    const ville = $('#wilayas').val();

    $.ajax({
        url: 'index.php?router=searchPart',
        type: 'POST',
        data: {
            searchPartenaire: searchValue,
            filterVille: ville,
            filterCategorie: categorie
        },
        dataType: 'json',
        success: function(data) {
            $('#all tr:not(.head)').remove();
            const partenaireTable = $('#all');
            data.forEach(function(partenaire) {
                partenaireTable.append('<tr>' +
                    '<td>' + partenaire['nom'] + '</td>' +
                    '<td>' + partenaire['categorie'] + '</td>' +
                    '<td>' + partenaire['ville'] + '</td>' +
                    '<td>' + partenaire['contactmail'] + '</td>' +
                    '<td>' + partenaire['telNumber'] + '</td>' +
                    '<td><button class="action-btn">Modifier</button></td>' +
                    '<td><button class="action-btn">Supprimer</button></td>' +
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
        case 'nom': return 0;
        case 'categorie': return 1;
        case 'ville': return 2;
        case 'email': return 3;
        case 'telNum': return 4;
        default: return 0;
    }
}
