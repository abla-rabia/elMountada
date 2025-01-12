$(document).ready(function() {
    fetchUsers();
    $('#seachBar').on('keyup', fetchUsers);
    $('#dateMin, #dateMax, #filtreUsers').on('change', fetchUsers);
});



const popupT = document.getElementById("userPopup");
const popContainer = document.getElementsByClassName("popContainer")[0];

function handleUserAction(user) {
    successPopup();
    $('#popupNom').text(user.nom);
    $('#popupId').val(user.id);
    $('#popupPrenom').text(user.prenom);
    $('#popupUsername').text(user.username);
    $('#popupEmail').text(user.email);
    $('#popupType').text(user.approuve ? 'Membre' : 'User');
    if (user.paiement == 1) {
        $('#popupPaiement').show();
        $('#fileRecu').on('click', function() {
            handleClickRecu(user);
        });
    } else {
        $('#popupPaiement').hide();
    }
    if (user.approuve) {
        $('#approuverBtn').hide();
    } else {
        $('#approuverBtn').show();
    }
    $('#userPopup').show();
}

function handleClickRecu(user) {
    $.ajax({
        url: 'index.php?router=getRecu',
        type: 'POST',
        data: { userId: user.id },
        dataType: 'json',
        success: function(data) {
            var imageUrl = data.recu.replace('../', '');
            var a = document.createElement('a');
            a.href = imageUrl;
            a.download = imageUrl.split('/').pop();
            a.click();
        },
        error: function(xhr, status, error) {
            console.error('Error fetching users:', error);
        }
    });
}

const popContainer1 = document.getElementsByClassName("popContainer")[1];
document.getElementById("closeUserbtn").addEventListener("click", function() {
    popContainer.style.display = "none";
    popupT.style.display = "none";
});
document.getElementById("closeUserbtn2").addEventListener("click", function() {
    popContainer1.style.display = "none";
    document.getElementById("approuverPopup").style.display = "none";
});

function successPopup() {
    popContainer.style.display = "flex";
    popupT.style.display = "flex";
}

window.addEventListener("click", (event) => {
    if (event.target === popContainer) {
        popContainer.style.display = "none";
        popupT.style.display = "none";
    }
    if (event.target === popContainer1) {
        popContainer1.style.display = "none";
        document.getElementById("approuverPopup").style.display = "none";
    }
});

document.getElementById("approuverBtn").addEventListener("click", function() {
    popContainer.style.display = "none";
    popupT.style.display = "none";
    document.getElementById("approuverPopup").style.display = "flex";
    popContainer1.style.display = "flex";
    const userId = parseInt($('#popupId').val());
    $('#approuverPopup input[name="id"]').val(userId);
});

$(document).ready(function() {
    $.ajax({
        url: 'index.php?router=getCartes',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const carteSelect = $('#carteType');
            data.forEach(function(carte) {
                carteSelect.append('<option value="' + carte['type'] + '">' + carte['type'] + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching users:', error);
        }
    });
});

$(document).ready(function() {
    $('#approuverUser').on('click', function(event) {
        event.preventDefault();
        const formData = new FormData($('#formApprouver')[0]);
        $.ajax({
            url: 'index.php?router=approuver',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response == 1) {
                    alert('Utilisateur approuvé avec succès !');
                    popContainer1.style.display = "none";
                    document.getElementById("approuverPopup").style.display = "none";
                    $('#popupType').text('Membre');
                    $("#approuveTd").text("Membre");
                } else {
                    alert(response);
                }
            },
            error: function() {
                alert('Erreur!');
            }
        });
    });
});

function fetchUsers() {
    const searchValue = $('#seachBar').val();
    const dateMin = $('#dateMin').val();
    const dateMax = $('#dateMax').val();
    const filterType = $('#filtreUsers').val();

    $.ajax({
        url: 'index.php?router=searchUser',
        type: 'POST',
        data: {
            searchUser: searchValue,
            dateMin: dateMin,
            dateMax: dateMax,
            filterType: filterType
        },
        dataType: 'json',
        success: function(data) {
            $('#all tr:not(.head)').remove();
            const usersTable = $('#all');
            data.forEach(function(user) {
                usersTable.append('<tr>' +
                    '<td>' + user['username'] + '</td>' +
                    '<td>' + user['email'] + '</td>' +
                    '<td>' + user['nom'] + '</td>' +
                    '<td>' + user['prenom'] + '</td>' +
                    '<td>' + user['date_inscription'] + '</td>' +
                    '<td id="approuveTd">' + (user['approuve'] ? 'Membre' : 'User') + '</td>' +
                    '<td><button class="action-btn" onclick=\'handleUserAction(' + JSON.stringify(user) + ')\'>Action</button></td>' +
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
        case 'username': return 0;
        case 'email': return 1;
        case 'nom': return 2;
        case 'prenom': return 3;
        case 'date': return 4;
        default: return 0;
    }
}