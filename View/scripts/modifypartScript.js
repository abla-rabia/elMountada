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

$(document).ready(function () {
    fetchInfo();
});


function fetchInfo() {
    const id = $('#id').val();
    console.log(id);
    
    $.ajax({
        url: 'index.php?router=getPartenaireById',
        type: 'POST',
        data: {
            'id_partenaire': id
        },
        dataType: 'json',
        success: function(data) {
            $('input[name="nom"]').val(data.nom);
            $('select[name="categorie"]').val(data.categorie);
            $('select[name="ville"]').val(data.ville);
            $('input[name="tel"]').val(data.telNumber);
            $('textarea[name="description"]').val(data.description);
            $('input[name="mail"]').val(data.contactmail);
            $('input[name="site"]').val(data.website);
            
        },
        error: function(error) {
            console.error('Error fetching users:', error);
        }
    });
}


$(document).ready(function() {
    fetchInfo(); // Fetch initial data

    // Handle form submission
    $("#infosButton").on("click", function(event) {
        event.preventDefault();
        
        // Create FormData object
        const formData = new FormData($("#infosForm")[0]);
        
        // Log the data being sent (for debugging)
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            url: "index.php?router=modifierPartenaire",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // Expect JSON response
            success: function(response) {
                if (response.success) {
                    alert("Informations modifiées avec succès");
                    // Optionally refresh the page or redirect
                    window.location.reload();
                } else {
                    alert("Erreur: " + response.message);
                }
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error("Error details:", xhr.responseText);
                alert("Erreur lors de la modification!");
            }
        });
    });
});