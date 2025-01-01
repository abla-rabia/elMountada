document.addEventListener("DOMContentLoaded", function () {
    let checkElement = document.getElementById("payerNow");
    checkElement.addEventListener("click", function () {
        const payementSection = document.getElementsByClassName("paiement")[0];
        payementSection.style.display = checkElement.checked ? "flex" : "none";
    });
    let plan;
    const popup = document.getElementById("popupUpload");
    const popContainer = document.getElementsByClassName("popContainer")[0];
    const popContainer1 = document.getElementsByClassName("popContainer")[1];

    const choosePlanButtons = document.getElementsByClassName("choosePlan");
    for (let i = 0; i < choosePlanButtons.length; i++) {
        choosePlanButtons[i].addEventListener("click", function () {
            console.log("Button clicked");
            popContainer1.style.display = "flex";
            popup.style.display = "flex";
            if (i === 0) {
                plan = "classique";
            } else if (i === 1) {
                plan = "premium";
            } else if (i === 2) {
                plan = "prestige";
            }
            console.log(plan);
        });
    }

    document.getElementById("closeUploadPop").addEventListener("click", function () {
        console.log("Button clicked");
        popContainer1.style.display = "none";
        popup.style.display = "none";
    });
    const popupT = document.getElementById("textPopup");
    function successPopup() {
        const popContainer = document.getElementsByClassName("popContainer")[0];
        const popupT = document.getElementById("textPopup");
        popContainer.style.display = "flex";
        popupT.style.display = "flex";
        document.getElementById("contentPop").textContent = checkElement.checked ? "Reçu soumis avec succès ! Votre demande est en cours de traitement. Une fois confirmée, vous recevrez un email. En attendant, vous pouvez vous connecter et profiter des avantages utilisateur" : "Votre inscription a été effectuée avec succès. Vous pouvez maintenant vous connecter et bénéficier des avantages réservés aux utilisateurs inscrits.";
    }
    window.addEventListener("click", (event) => {
        if (event.target === popContainer) {
            popContainer.style.display = "none";
            popup.style.display = "none";
        }
    });

    window.addEventListener("click", (event) => {
        if (event.target === popContainer1) {
            popContainer1.style.display = "none";
            popup.style.display = "none";
        }
    });
    const pass1 = document.querySelector('[name="password"]');
    const pass2 = document.querySelector('[name="password2"]');
    let machingPass = false;
    pass2.addEventListener("change", function (event) {
        if (pass1.value !== event.target.value) {
            pass2.style.border = "1px solid rgba(255, 88, 51, 0.57)";
            machingPass = false;
        }
        else {
            pass2.style.border = "1px solid var(--Neutral-300, #eff0f6)";
            machingPass = true;
        }

    })

    // gestion du formulaire a l'aide de ajax
    
    $(document).ready(function () {
        $('#inscriptionPop').on('click', function (event) {
            if (machingPass){
            event.preventDefault();
            
                const formData = new FormData($('#formInsc')[0]);
                if (!checkElement.checked){
            $.ajax({
                url: 'Routers/inscriptionRouter.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response == 1) {
                        console.log(response);
                        successPopup();
                    } else if (response==3){                
                        console.log(response);
                        alert('Veuillez remplire tous les champs ! ');
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
                } else {
                    formData.append('plan', plan);
                    $.ajax({
                        url: 'Routers/inscription2Router.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response == 1) {
                                console.log(response);
                                successPopup();
                            } else if (response==3){                
                                console.log(response);
                                alert('Veuillez remplire tous les champs ! ');
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
            }
            else {
                alert('Mots de passe non identiques ! ');
            }
        });
    });
});

