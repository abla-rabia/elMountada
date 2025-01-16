<?php
class adminDonsView {
    public function entetePage() {
        ?>
        <head>
            <title>Liste des dons</title>
            <link rel="stylesheet" href="View/css/userInfosStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <script src="View/scripts/infosScript.js"></script>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        </head>
        <?php   
    }

    public function afficher_page() {
        $r = new commonViews();
        ?>
        <html>
            <?php $this->entetePage(); ?>
            <body class="to">
                <?php $r->navBar(); ?>
                <div class="content">
                <div id="head">
                    <?php $r->titre("Liste des dons"); ?><br><br>
                    <div class="subContent">
                    <?php $r->adminSideBar("Dons"); ?>
                    <div class="users">
                        <table id="donsList">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Donateur</th>
                                    <th>Reçu</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
                </div>
                </div>

                <style>
                    .table-container {
                        margin: 20px 0;
                        overflow-x: auto;
                    }
                    
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    
                    th, td {
                        padding: 12px;
                        text-align: left;
                        border-bottom: 1px solid #ddd;
                    }
                    
                    th {
                        background-color: #f5f5f5;
                        font-weight: 600;
                    }
                    
                    .btn-approuver {
                        background-color: #4CAF50;
                        color: white;
                        padding: 8px 16px;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                    }
                    
                    .btn-approuver:disabled {
                        background-color: #cccccc;
                        cursor: not-allowed;
                    }
                </style>

                <script>
                    $(document).ready(function() {
                        loadDons();

                        function loadDons() {
                            $.ajax({
                                url: 'index.php?router=getDons',
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    console.log("hellllo");
                                    console.log(data);
                                    const tbody = $('#donsList tbody');
                                    tbody.empty();

                                    data.forEach(function(don) {
                                        const tr = $('<tr>');
                                        tr.append(`<td>${formatDate(don.date_ajout)}</td>`);
                                        tr.append(`<td>${don.prenom} ${don.nom}</td>`);
                                        tr.append(`<td><a href="${don.recu}" target="_blank">Voir le reçu</a></td>`);
                                        tr.append(`<td>${don.approuve == 1 ? 'Approuvé' : 'En attente'}</td>`);
                                        tr.append(`
                                            <td>
                                                <button 
                                                    class="btn-approuver" 
                                                    onclick="approuverDon(${don.id})"
                                                    ${don.approuve == 1 ? 'disabled' : ''}
                                                >
                                                    Approuver
                                                </button>
                                            </td>
                                        `);
                                        tbody.append(tr);
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error fetching dons:', error);
                                }
                            });
                        }

                        function formatDate(dateStr) {
                            const date = new Date(dateStr);
                            return date.toLocaleDateString('fr-FR');
                        }

                        window.approuverDon = function(id) {
                            if (confirm('Êtes-vous sûr de vouloir approuver ce don ?')) {
                                $.ajax({
                                    url: 'index.php?router=approuverDon',
                                    type: 'POST',
                                    data: { id: id },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            alert('Le don a été approuvé avec succès !');
                                            loadDons();
                                        } else {
                                            alert('Une erreur est survenue lors de l\'approbation');
                                        }
                                    },
                                    error: function() {
                                        alert('Une erreur est survenue');
                                    }
                                });
                            }
                        }
                    });
                </script>
            </body>
        </html>
        <?php
    }
}
?>

