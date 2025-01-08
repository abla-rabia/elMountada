$(document).ready(function () { 
    const id = $("#partId").val();
    function loadInitialContent() {
        $.ajax({
            url: 'index.php?router=getPartenaireById',
            type: 'POST',
            data: { 'id_partenaire': id },
            dataType: 'json',
            success: function (data) {
                console.log(data)
                $('#categp').text(data.categorie+" > ");
                $('#nomp').text(data.nom);
                $('h2#nompL').text(data.nom);
                $('p#descriptionp').text(data.description);
                $('#wilayaP').text(data.ville);
                $('.aboutUs').text(data.description);
                $('#phoneP').text(data.telnumber);
                $('#emailP').text(data.contactmail);
                $('#webP').text(data.website);

                console.log(id);
            },
            error: function() {
                console.error('error');
            }
        });
    }
    loadInitialContent();
});