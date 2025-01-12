
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
                    '<td><button class="action-btn" onclick="handleOffre(' + partenaire['id'] + ')">Offres</button></td>' +
                    '<td><button class="action-btn" onclick="handleDelete(' + partenaire['id'] + ',\'' + partenaire['nom'] + '\')">Supprimer</button></td>' +
                    '<td><button class="action-btn" onclick="handleModify(' + partenaire['id'] + ')">Modifier</button></td>' +
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

function handleDelete(id,nom) {
    $.ajax({
        url: 'index.php?router=deletePartenaire',
        type: 'POST',
        data: { 'id': id },
        dataType: 'json',
        success: function () {
            alert("Partenaire avec l'id " + id + " supprimé avec succès !");
            $('tr').filter(function() {
                return $(this).find('td').eq(0).text() == nom;
            }).remove();
        },
        error: function(xhr, status, error) {
            console.error('Error deleting partenaire:', error);
        }
    });
}

function handleModify(id) {
    $.ajax({
        url: `index.php?router=getModifyPage&id=${id}`,
        type: 'GET',  
        success: function(response) {
            window.location.href = `index.php?router=getModifyPage&id=${id}`;
        },
        error: function(xhr, status, error) {
            console.error('Error accessing modify page:', error);
            alert("Erreur lors de l'accès à la page de modification");
        }
    });
}
function handleOffre(id) {
    $.ajax({
        url: `index.php?router=getOffrePage&id=${id}`,
        type: 'GET',  
        success: function(response) {
            window.location.href = `index.php?router=getOffrePage&id=${id}`;
        },
        error: function(xhr, status, error) {
            console.error('Error accessing offre page:', error);
            alert("Erreur lors de l'accès à la page des offres");
        }
    });
}