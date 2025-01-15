<?php
require_once(ROOT . '/Controller/userController.php');
require_once("commonViews.php");

class historiqueDons {
    public function entetePage() {
        ?>
        <head>
            <title>Mes Dons</title>
            <link rel="stylesheet" href="View/css/userInfosStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <script src="View/scripts/infosScript.js"></script>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <style>
/* Table Container */
.users {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

/* Table Styles */
table#all {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;
    font-size: 14px;
}

/* Header Cells */
table#all th {
    background: #f8f9fa;
    color: #2c3e50;
    font-weight: 600;
    padding: 16px;
    text-align: left;
    border-bottom: 2px solid #edf2f7;
    cursor: pointer;
    transition: background-color 0.2s;
    position: relative;
}

table#all th:hover {
    background: #edf2f7;
}

table#all th:after {
    content: '↕';
    position: absolute;
    right: 8px;
    opacity: 0.3;
}

/* Table Cells */
table#all td {
    padding: 14px 16px;
    border-bottom: 1px solid #edf2f7;
    color: #4a5568;
    font-weight: 500;
}

/* Table Rows */
table#all tr:not(.head):hover {
    background-color: #f8fafc;
    transition: background-color 0.2s;
}

/* Action Button */
.action-btn {
    background: #a6dfb5;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.action-btn:hover {
    background:rgb(129, 185, 144);
}

/* Status Styles */
table#all td:nth-child(6) {
    position: relative;
}

table#all td:nth-child(6):before {
    content: '';
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 8px;
}

table#all td:nth-child(6):contains('Approuvé'):before {
    background-color: #34d399;
}

table#all td:nth-child(6):contains('En attente'):before {
    background-color: #fbbf24;
}

/* Responsive Design */
@media screen and (max-width: 1024px) {
    table#all {
        font-size: 13px;
    }
    
    table#all th, 
    table#all td {
        padding: 12px;
    }
    
    .action-btn {
        padding: 6px 12px;
    }
}

@media screen and (max-width: 768px) {
    .users {
        padding: 12px;
    }
    
    table#all {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
}
</style>
        </head>
        <?php   
    }

    

    

    

    public function afficher_page() {
        $r = new commonViews();
        ?>
        <html>
            <?php $this->entetePage(); ?>
            <body class="to">
                <?php $r->navBarC(); ?>
                <div class="content">
                    <?php $r->titre("Historique"); ?>
                    <div class="subContent">
                        <?php $r->historySideBar("Mes dons"); ?>
                        <div class="users">
                            
                            <table id="all">
                                <tr class="head">
                                    <th onclick="sortTable('date')">Date du dons</th>
                                    <th >Recu</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        fetchDons();
                    });


                    function fetchDons() {
                        const searchValue = $('#seachBar').val();
                        const dateMin = $('#dateMin').val();
                        const dateMax = $('#dateMax').val();
                        const filterType = $('#filtreDons').val();

                        $.ajax({
                            url: 'index.php?router=getDonsHistory',
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('#all tr:not(.head)').remove();
                                const donsTable = $('#all');
                                data.forEach(function(don) {
                                    donsTable.append('<tr>' +
                                        '<td>' + don.date_ajout + '</td>' +
                                        `<td><a href="${don.recu}" target="_blank">Voir le reçu</a></td>`+
                                    '</tr>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching dons:', error);
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
                            case 'date': return 0;
                            default: return 0;
                        }
                    }
                </script>
                <style>
                    form.searchBar {
                        display: flex;
                        justify-content: space-between;
                        gap: 40px;
                        padding: 0;
                    }
                    form.searchBar div.searchBar {
                        width: 100%;
                        display: flex;
                        gap: 8px;
                        align-items: center;
                    }
                    form.searchBar .filtresTri {
                        display: flex;
                        justify-content: space-between;
                        gap: 10px;
                    }
                    form.searchBar .filtresTri select {
                        width: fit-content;
                    }
                    div.searchBar i {
                        color: #001a23;
                        opacity: 0.4;
                    }
                    div.searchBar,
                    select {
                        border-radius: 6px;
                        background: #f3f3f3;
                        padding: 8px 8px;
                        border: 0;
                        color: #001a23;
                        opacity: 0.8;
                        outline: none;
                        font-size: 12px;
                        font-weight: 500;
                    }
                    input {
                        font-size: 12px;
                        border: none;
                        outline: none;
                        font-weight: 500;
                        flex-grow: 1;
                        background-color: transparent;
                    }
                    input::placeholder {
                        color: #001a23;
                        opacity: 0.2;
                        font-size: 12px;
                    }
                    select {
                        font-weight: 500;
                    }
                </style>
            </body>
        </html>
        <?php
    }
}
?>
