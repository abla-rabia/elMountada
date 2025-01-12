
function ajouterRemise() {
    const popup = document.getElementById("addRemisePopup");
    const popContainer = document.getElementsByClassName("popContainer")[0];
    popContainer.style.display = "flex";
    popup.style.display = "flex";
};
$(document).ready(function () {
    const closeBtns = document.querySelectorAll("#closebtn1, #closebtn2");
    closeBtns.forEach(btn => {
        btn.addEventListener("click", function (event) {
            console.log("hello");
            const remisePopup = document.getElementById("addRemisePopup");
            const avantagePopup = document.getElementById("addAvantagePopup");
            const popContainers = document.getElementsByClassName("popContainer");

            for (let i = 0; i < popContainers.length; i++) {
                    popContainers[i].style.display = "none";
                    remisePopup.style.display = "none";
                    avantagePopup.style.display = "none";
            }
        });
    });

    window.addEventListener("click", (event) => {
        const remisePopup = document.getElementById("addRemisePopup");
        const avantagePopup = document.getElementById("addAvantagePopup");
        const popContainers = document.getElementsByClassName("popContainer");
        
        for (let i = 0; i < popContainers.length; i++) {
            if (event.target === popContainers[i]) {
                popContainers[i].style.display = "none";
                remisePopup.style.display = "none";
                avantagePopup.style.display = "none";
            }
        }
    });
});

function fetchCartes() {
    $.ajax({
        url: 'index.php?router=getCartes',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const carteSelect = $('.carteType');
            data.forEach(function(carte) {
                carteSelect.append('<option value="' + carte['id'] + '">' + carte['type'] + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching users:', error);
        }
    });
}
$(document).ready(function() {
    fetchCartes();
});

function ajouterAvantage() {
    const popup = document.getElementById("addAvantagePopup");
    const popContainer = document.getElementsByClassName("popContainer")[1];
    
    popContainer.style.display = "flex";
    popup.style.display = "flex";
};


//handler d'ajout de remise 
$(document).ready(function() {
    $('#addRemise').on('click', function(event) {
        event.preventDefault();
        const formData = new FormData($('#formAddRemise')[0]);
        $.ajax({
            url: 'index.php?router=ajouterRemise',
            type: 'POST',
            beforeSend: function () {
                const carteType = $('#carteType').val();
                formData.append('carteType', carteType);
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response == 1) {
                    alert('Remise ajoutée avec succès !');
                    const popContainer = document.getElementsByClassName("popContainer")[0];
                    popContainer.style.display = "none";
                    document.getElementById("addRemisePopup").style.display = "none";
                    const remiseTable = $('#remisesTable');
                    remiseTable.append('<tr>' +
                        '<td>' + $('input[name="contenu"]').val() + '</td>' +
                        '<td>' + $('#carteType option:selected').text() + '</td>' +
                        '<td><button class="action-btn">Modifier</button></td>' +
                        '<td><button class="action-btn">Supprimer</button></td>' +
                        '</tr>');
                
                
            
                } else {
                    console.log(response)
                    alert(response);
                }
            },
            error: function() {
                alert('Erreur!');
            }
        });
    });
});
// handler d'ajout d'avantage
$(document).ready(function() {
    $('#addAvantage').on('click', function(event) {
        event.preventDefault();
        const formData = new FormData($('#formAddAvantage')[0]);
        $.ajax({
            url: 'index.php?router=ajouterAvantage',
            type: 'POST',
            beforeSend: function() {
                const carteType = $('#carteType').val();
                formData.append('carteType', carteType);
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response == 1) {
                    alert('Avantage ajouté avec succès !');
                    const popContainer = document.getElementsByClassName("popContainer")[1];
                    popContainer.style.display = "none";
                    document.getElementById("addAvantagePopup").style.display = "none";
                    const avantageTable = $('#avantagesTable');
                    avantageTable.append('<tr>' +
                        '<td>' + $('input[placeholder="contenu de l avantage"]').val() + '</td>' +
                        '<td>' + $('#carteType option:selected').text() + '</td>' +
                        '<td><button class="action-btn">Modifier</button></td>' +
                        '<td><button class="action-btn">Supprimer</button></td>' +
                        '</tr>');
                } else {
                    console.log(response);
                    alert(response);
                }
            },
            error: function() {
                alert('Erreur!');
            }
        });
    });
});


function fetchRemisesEtAvantages() {
    const idPartenaire = $('#id').val();

    $.ajax({
        url: 'index.php?router=getRemises',
        type: 'POST',
        data: {'idPartenaire': idPartenaire},
        dataType: 'json',
        success: function(data) {
            $('table#remisesTable tr:not(.head)').remove();
            const remiseTable = $('#remisesTable');
            let maxRemise = 0;
            data.forEach(function(remise) {
                remiseTable.append('<tr>' +
                    '<td>' + remise['offreContenu'] + '</td>' +
                    '<td>' + remise['carteType'] + '</td>' +
                    '<td><button class="action-btn" onclick="handleModifyRemise(' + remise['offreId'] + ',\'' + remise['offreContenu'] + '\',\'' + remise['carteType'] + '\' )">Modifier</button></td>' +
                    '<td><button class="action-btn" onclick="handleDelete(' + remise['offreId'] + ',\'' + remise['offreContenu'] + '\')">Supprimer</button></td>' +
                    '</tr>');
                    let remiseValue = parseInt(remise['offreContenu'].replace('%', ''));
                    if (remiseValue > maxRemise) {
                        maxRemise = remiseValue;
                    }
            });
            $("#numberRemise").text(maxRemise + "%");
        },
        error: function(xhr, status, error) {
            console.error('Error fetching remises:', error);
        }
    });

    $.ajax({
        url: 'index.php?router=getAvantages',
        type: 'POST',
        data: {'idPartenaire': idPartenaire},
        dataType: 'json',
        success: function(data) {
            $('table#avantagesTable tr:not(.head)').remove();
            const avantageTable = $('#avantagesTable');
            data.forEach(function(avantage) {
                avantageTable.append('<tr>' +
                                    '<td>' + avantage['offreContenu'] + '</td>' +
                                    '<td>' + avantage['carteType'] + '</td>' +
                                    '<td><button class="action-btn" onclick="handleModifyAvantage(' + avantage['offreId'] + ',\'' + avantage['offreContenu'] + '\',\'' + avantage['carteType'] + '\' )">Modifier</button></td>' +
                                    '<td><button class="action-btn" onclick="handleDelete(' + avantage['offreId'] + ',\'' + avantage['offreContenu'] + '\',\'' + avantage['carteType'] + '\' )">Supprimer</button></td>' +
                                '</tr>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching avantages:', error);
        }
    });
}

$(document).ready(function() {
    fetchRemisesEtAvantages();
});

function handleDelete(id,nom) {
    $.ajax({
        url: 'index.php?router=deleteOffre',
        type: 'POST',
        data: { 'id': id },
        dataType: 'json',
        success: function () {
            alert("Offre avec l'id " + id + " supprimé avec succès !");
            $('tr').filter(function() {
                return $(this).find('td').eq(0).text() == nom;
            }).remove();
        },
        error: function(xhr, status, error) {
            console.error('Error deleting offre:', error);
        }
    });
}


function handleModifyAvantage(id, nom, type) {
    //1- affichage du popup de modification 
    const popup = document.getElementById("modifyAvantagePopup");
    const popContainer = document.getElementsByClassName("popContainer")[3];
    
    popContainer.style.display = "flex";
    popup.style.display = "flex";
    //on set les valeurs par defauts des champs
    console.log(type);
    $('#formModifyAvantage #carteType option').filter(function() {
        return $(this).text() === type;
    }).prop('selected', true);
    $('input[value="contenu de l avantage"]').val(nom);
    $('input[name="id"]').val(id);


}
//handler de modification d'avantage
$(document).ready(function() {
    $('#modifyAvantage').on('click', function(event) {
        event.preventDefault();
        const formData = new FormData($('#formModifyAvantage')[0]);
        $.ajax({
            url: 'index.php?router=modifyOffre',
            type: 'POST',
            beforeSend: function() {
                const carteType = $('#formModifyAvantage #carteType').val();
                formData.append('carteType', carteType);
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response == 1) {
                    alert('Avantage modifié avec succès !');
                    const popContainer = document.getElementsByClassName("popContainer")[3];
                    popContainer.style.display = "none";
                    document.getElementById("modifyAvantagePopup").style.display = "none";
                    location.reload();
                } else {
                    console.log(response);
                    alert(response);
                }
            },
            error: function() {
                alert('Erreur!');
            }
        });
    });
});



function handleModifyRemise(id, nom, type) {
    //1- affichage du popup de modification 
    const popup = document.getElementById("modifyRemisePopup");
    const popContainer = document.getElementsByClassName("popContainer")[2];
    
    popContainer.style.display = "flex";
    popup.style.display = "flex";
    //on set les valeurs par defauts des champs
    console.log(type);
    $('#formModifyRemise #carteType option').filter(function() {
        return $(this).text() === type;
    }).prop('selected', true);
    $('input[value="50%"]').val(nom);
    $('input[name="id"]').val(id);
}

$(document).ready(function() {
    $('#modifyRemise').on('click', function(event) {
        event.preventDefault();
        const formData = new FormData($('#formModifyRemise')[0]);
        $.ajax({
            url: 'index.php?router=modifyOffre',
            type: 'POST',
            beforeSend: function() {
                const carteType = $('#formModifyRemise #carteType').val();
                formData.append('carteType', carteType);
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response == 1) {
                    alert('Remise modifiée avec succès !');
                    const popContainer = document.getElementsByClassName("popContainer")[2];
                    popContainer.style.display = "none";
                    document.getElementById("modifyRemisePopup").style.display = "none";
                    location.reload();
                } else {
                    console.log(response);
                    alert(response);
                }
            },
            error: function() {
                alert('Erreur!');
            }
        });
    });
});



