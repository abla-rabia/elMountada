<?php
class addDonView {
    public function entetePage() {
        ?>
        <head>
            <title>Ajouter don</title>
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
                <div id="head">
                    <?php $r->titre("Ajouter un don"); ?>
                    
                    <form action="index.php?router=addDon" method="post" enctype="multipart/form-data">
                        <div class="fileUpload">
                            <label class="fmsLabel" for="recu">Reçu du don</label>
                            <input type="file" name="recu" id="recu" accept=".pdf,.jpg,.jpeg,.png">
                        </div><br><br>
                        
                        <input type="hidden" name="id_user" value="<?php echo isset($_SESSION['id_user']) ? $_SESSION['id_user'] : ''; ?>">
                        
                        <div class="contBtn">
                            <div class="button-container">
                                <input type="submit" value="Ajouter">
                            </div>
                        </div>
                    </form>
                </div>
                <style>
                    /* Existing styles from partenaire form */
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
                    input,
                    textarea {
                        font-size: 12px;
                        border: none;
                        outline: none;
                        font-weight: 500;
                        flex-grow: 1;
                        background-color: transparent;
                        width: 100%;
                        padding: 8px;
                        border-radius: 6px;
                        color: #001a23;
                        opacity: 0.8;
                    }
                    input::placeholder,
                    textarea::placeholder {
                        color: #001a23;
                        opacity: 0.2;
                        font-size: 12px;
                    }
                    select {
                        font-weight: 500;
                    }
                    div#head {
                        display: flex;
                        gap: 20px;
                        flex-direction: column;
                        margin: 10px 4%;
                    }
                    .button-container {
                        display: flex;
                        justify-content: flex-end;
                        width: 16vw;
                        position: absolute;
                        right: 4%;
                    }
                    .button-container input[type="submit"] {
                        color: white;
                        padding: 10px 20px;
                        border: none;
                        border-radius: 6px;
                        cursor: pointer;
                        width: 100px;
                    }
                    .textArea {
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                    }
                    .textArea label {
                        font-size: 12px;
                        color: #001a23;
                        font-weight: 500;
                    }
                    .textArea textarea {
                        border-radius: 11.054px;
                        border: 1.105px solid #eff0f6;
                        display: flex;
                        height: 120px;
                        padding: 15.903px 22.718px;
                        align-items: flex-start;
                        gap: 9.087px;
                        flex-shrink: 0;
                        box-shadow: 0px 2px 4px 0px rgba(19, 18, 66, 0.03);
                        color: #001a23;
                        font-weight: 500;
                        align-self: stretch;
                        resize: none;
                        outline: none;
                    }
                    
                    /* Additional styles for aide form */
                    .description-box {
                        margin-top: 10px;
                        padding: 10px;
                        border-radius: 6px;
                        background: #f3f3f3;
                        font-size: 12px;
                        color: #001a23;
                        display: none;
                    }
                    
                    .typeAideContainer {
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                    }
                </style>
            </body>
        </html>
        <?php
    }
}
?>