document.addEventListener("DOMContentLoaded", function () {
    // gestion du formulaire des informations personnelles a l'aide de ajax
    
    $(document).ready(function () {
        $('#infosButton').on('click', function (event) {
            event.preventDefault();
            
                const formData = new FormData($('#infosForm')[0]);
            $.ajax({
                url: 'index.php?router=modifyPersoInfo',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    
                        alert('Informations modifées avec succés');
                        console.log(response);
                    
                    
                },
                error: function () {
                    alert('erreur!');
                }
            });
        });
    });


//gestion du formulaire des informations de compte

    $(document).ready(function () {
        $('#compteButton').on('click', function (event) {
            event.preventDefault();
            
                const formData = new FormData($('#compteForm')[0]);
            $.ajax({
                url: 'index.php?router=modifyCompteInfo',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    
                        alert('Informations modifées avec succés');
                        console.log(response);
                    
                },
                error: function () {
                    alert('erreur!');
                }
            });
        });
    });


    $(document).ready(function () {
        $('#photoInput').on('change', function (event) {
            event.preventDefault();
            const fileInput = document.getElementById('photoInput');
            const file = fileInput.files[0];
            
            if (!file) {
                alert('Please select a file.');
                return;
            }
    
            const formData = new FormData();
            formData.append('photoProfile', file);
    
            $.ajax({
                url: 'index.php?router=modifyPdp',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert('Photo modifiée avec succès');
                    let image = document.getElementById("photoPdp");
                    console.log(response)
                    image.src = response; // Assuming response contains photo URL
                    document.getElementById("nav").src=response //modifying the navbar photo
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                    alert('Erreur: ' + xhr.responseText);
                }
            });
        });
    });
    
    let matchingPassword = false;
    let emptyPassword = true;
//gestion du formulaire du mot de passe

    $(document).ready(function () {
        $('#passwordForm').on('click', function (event) {
            event.preventDefault();
            
            const formData = new FormData($('#formInsc')[0]);
            if (!emptyPassword){
            if(matchingPassword){
            $.ajax({
                url: 'index.php?router=modifyPassword',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response == 1) {
                        alert('Mot de passe modifées avec succés');
                        console.log(response);
                    }
                    else {                
                        console.log(response);
                        alert(response);
                    }
                },
                error: function () {
                    alert('erreur!');
                }
            });
                }
            else {
                alert("Les mots de passes doivent être identiques !");
                }
            }
            else {
                alert("le mot de passe ne peut pas etre vide ! ")
            }
            });
        
    });
});




