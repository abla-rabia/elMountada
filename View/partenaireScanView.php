<?php
require_once(ROOT . '/Controller/donsBenevolatsAidesController.php');
require_once("commonViews.php");

class partenaireScanView {
    public function entetePage() {
        ?>
        <head>
            <title>Scanner User</title>
            <link rel="stylesheet" href="View/css/userInfosStyle.css">
            <link rel="stylesheet" href="View/css/commonStyles.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"></script>
            <style>
                *{
                    font-family: "Montserrat", sans-serif;
                }
                body.scan {
                    overflow-y: hidden;
                }
                .container {
                    display: flex; 
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    min-height: 70vh;
                    padding: 20px;
                }
                .button-container {
                    display: flex;
                    gap: 40px;
                    margin-bottom: 30px;
                }
                .scan-button {
                    width: 200px;
                    height: 200px;
                    border: none;
                    border-radius: 15px;
                    background-color: #001a23;
                    color: white;
                    cursor: pointer;
                    transition: transform 0.2s, background-color 0.2s;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                }
                .scan-button:hover {
                    background-color: #003a4d;
                    transform: scale(1.05);
                }
                .scan-button i {
                    font-size: 64px;
                    margin-bottom: 15px;
                }
                .button-description {
                    text-align: center;
                    color: #666;
                    margin-top: 10px;
                    font-size: 14px;
                    max-width: 200px;
                }
                .popup {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.8);
                    justify-content: center;
                    align-items: center;
                    z-index: 1000;
                }
                .popup-content {
                    background: white;
                    padding: 30px;
                    border-radius: 15px;
                    text-align: center;
                    width: 90%;
                    max-width: 400px;
                    position: relative;
                }
                #username {
                    width: 100%;
                    padding: 12px;
                    margin: 20px 0;
                    border: 2px solid #001a23;
                    border-radius: 8px;
                    font-size: 16px;
                }
                .close-btn {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background: none;
                    border: none;
                    color: #001a23;
                    font-size: 24px;
                    cursor: pointer;
                }
                #videoElement {
                    width: 100%;
                    max-width: 640px;
                    border-radius: 8px;
                }
                #username-results ,#qr-reader-results{
                    margin-top: 20px;
                    max-height: 300px;
                    overflow-y: auto;
                }
                #username-results .success-scan,
                #username-results .error-scan,
                #qr-reader-results .success-scan,
                #qr-reader-results .error-scan {
                    padding: 15px;
                    border-radius: 8px;
                    margin-top: 10px;
                }
                #username-results .success-scan {
                    background-color: #e8f5e9;
                    border: 1px solid #a5d6a7;
                }
                #username-results .error-scan {
                    background-color: #ffebee;
                    border: 1px solid #ffcdd2;
                }
                #username-results ul {
                    list-style: none;
                    padding-left: 0;
                }
                #username-results li {
                    margin: 10px 0;
                    padding: 10px;
                    background-color: #f5f5f5;
                    border-radius: 4px;
                }
                #qr-reader-results .success-scan {
                    background-color: #e8f5e9;
                    border: 1px solid #a5d6a7;
                }
                #qr-reader-results .error-scan {
                    background-color: #ffebee;
                    border: 1px solid #ffcdd2;
                }
                #qr-reader-results ul {
                    list-style: none;
                    padding-left: 0;
                }
                #qr-reader-results li {
                    margin: 10px 0;
                    padding: 10px;
                    background-color: #f5f5f5;
                    border-radius: 4px;
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
            <body class="scan to">
                <?php $r->navBarC(); ?>
                <div class="content">
                <?php $r->titre("Scanner user"); ?>
                
                <div class="container">
                    <div class="button-container">
                        <div>
                            <button class="scan-button" id="scanUserBtn">
                                <i class="fas fa-camera"></i>
                                <span>Scanner User</span>
                            </button>
                            <p class="button-description">Scannez le QR code de l'utilisateur</p>
                        </div>
                        <div>
                            <button class="scan-button" id="enterUsernameBtn">
                                <i class="fas fa-user"></i>
                                <span>Entrer le nom</span>
                            </button>
                            <p class="button-description">Saisissez manuellement le nom d'utilisateur</p>
                        </div>
                    </div>

                    <!-- Scanner Popup -->
                    <div class="popup" id="scannerPopup">
                        <div class="popup-content">
                            <button class="close-btn">&times;</button>
                            <h2>Scanner le QR Code</h2>
                            <div id="qr-reader"></div>
                            <div id="qr-reader-results"></div>
                            
                        </div>
                    </div>

                    <!-- Username Input Popup -->
                    <div class="popup" id="usernamePopup">
                        <div class="popup-content" style="display:flex;flex-direction:column;">
                            <button class="close-btn">&times;</button>
                            <h2>Entrer le nom d'utilisateur</h2>
                            <input type="text" id="username" placeholder="Nom d'utilisateur ou email">
                            <button class="scan-button" id="validateUsernameBtn" style="width: auto; height: auto; padding: 10px 20px;">
                                Valider
                            </button>
                            <div id="username-results"></div>
                        </div>
                    </div>
                </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let html5QrcodeScanner = null;

                        function initializeScanner() {
                            if (html5QrcodeScanner) {
                                html5QrcodeScanner.clear();
                            }

                            html5QrcodeScanner = new Html5QrcodeScanner(
                                "qr-reader",
                                { 
                                    fps: 10,
                                    qrbox: {width: 250, height: 250},
                                    showTorchButtonIfSupported: true,
                                },
                                false
                            );

                            html5QrcodeScanner.render(onScanSuccess, onScanError);
                        }

                        function onScanSuccess(decodedText, decodedResult) {
                            console.log(decodedText);
                            console.log(decodedResult);
                            if (html5QrcodeScanner) {
                                html5QrcodeScanner.pause();
                            }

                            $.ajax({
                                url: 'index.php?router=verifyQRCode',
                                method: 'POST',
                                data: { qr_code: decodedText },
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response);
                                    const resultDiv = document.getElementById('qr-reader-results');
                                    if (response.success) {
                                        let userInfo = '';
                                        if (response.user) {
                                            userInfo = `<p>Nom: ${response.user.nom} ${response.user.prenom}</p>`;
                                        } else {
                                            userInfo = `<p>Utilisateur non trouvé</p>`;
                                        }

                                        let remisesInfo = '';
                                        if (response.carte.remises && response.carte.remises.length > 0) {
                                            remisesInfo = '<h4>Avantages disponibles:</h4><ul>';
                                            response.carte.remises.forEach(remise => {
                                                remisesInfo += `
                                                    <li>${remise.contenu}${remise.type === 'remise' ? '%' : ''} 
                                                        (${remise.type}) - ${remise.nom}</li>
                                                `;
                                            });
                                            remisesInfo += '</ul>';
                                        } else {
                                            remisesInfo = `<p>Aucune remise disponible pour cette carte</p>`;
                                        }

                                        resultDiv.innerHTML = `
                                            <div class="success-scan">
                                                <h3>Membre vérifié !</h3>
                                                ${userInfo}
                                                ${remisesInfo}
                                            </div>
                                        `;
                                    } else {
                                        resultDiv.innerHTML = `
                                            <div class="error-scan">
                                                <p>Code QR invalide ou expiré</p>
                                            </div>
                                        `;
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Status:', status);
                                    console.error('Error:', error);
                                    console.error('Response:', xhr.responseText);
                                    const resultDiv = document.getElementById('qr-reader-results');
                                    resultDiv.innerHTML = `
                                        <div class="error-scan">
                                            <p>Erreur lors de la vérification : ${error}</p>
                                        </div>
                                    `;
                                },
                            });
                        }

                        function onScanError(error) {
                            console.warn(`Erreur de scan: ${error}`);
                        }

                        document.getElementById('scanUserBtn').addEventListener('click', function() {
                            document.getElementById('scannerPopup').style.display = 'flex';
                            setTimeout(() => {
                                initializeScanner();
                            }, 100);
                        });

                        document.querySelectorAll('.close-btn').forEach(btn => {
                            btn.addEventListener('click', function() {
                                if (html5QrcodeScanner) {
                                    html5QrcodeScanner.clear();
                                }
                                document.getElementById('qr-reader-results').innerHTML = '';
                                document.getElementById('scannerPopup').style.display = 'none';
                            });
                        });
                    });

                    document.getElementById('validateUsernameBtn').addEventListener('click', function() {
                        const username = document.getElementById('username').value.trim();
                        
                        if (!username) {
                            alert('Veuillez entrer un nom d\'utilisateur ou email');
                            return;
                        }

                       

                        $.ajax({
                            url: 'index.php?router=getRemisesUser',
                            method: 'POST',
                            data: { 
                                identifier: username
                            },
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                const resultDiv = document.getElementById('username-results');
                                if (response.success) {
                                    let userInfo = '';
                                    if (response.user) {
                                        userInfo = `<p>Nom: ${response.user.nom} ${response.user.prenom}</p>`;
                                    } else {
                                        userInfo = `<p>Utilisateur non trouvé</p>`;
                                    }

                                    let remisesInfo = '';
                                    if (response.carte.remises && response.carte.remises.length > 0) {
                                        remisesInfo = '<h4>Avantages disponibles:</h4><ul>';
                                        response.carte.remises.forEach(remise => {
                                            remisesInfo += `
                                                <li>${remise.contenu}${remise.type === 'remise' ? '%' : ''} 
                                                    (${remise.type}) - ${remise.nom}</li>
                                            `;
                                        });
                                        remisesInfo += '</ul>';
                                    } else {
                                        remisesInfo = `<p>Aucune remise disponible pour cette carte</p>`;
                                    }

                                    resultDiv.innerHTML = `
                                        <div class="success-scan">
                                            <h3>Membre vérifié !</h3>
                                            ${userInfo}
                                            ${remisesInfo}
                                        </div>
                                    `;
                                } else {
                                    resultDiv.innerHTML = `
                                        <div class="error-scan">
                                            <p>Utilisateur invalide ou non trouvé</p>
                                        </div>
                                    `;
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Status:', status);
                                console.error('Error:', error);
                                console.error('Response:', xhr.responseText);
                                const resultDiv = document.getElementById('username-results');
                                resultDiv.innerHTML = `
                                    <div class="error-scan">
                                        <p>Erreur lors de la vérification : ${error}</p>
                                    </div>
                                `;
                            }
                        });
                    });

                    document.getElementById('username').addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            document.getElementById('validateUsernameBtn').click();
                        }
                    });

                    document.getElementById('scanUserBtn').addEventListener('click', () => {
                        document.getElementById('scannerPopup').style.display = 'flex';
                        startCamera();
                    });

                    document.getElementById('enterUsernameBtn').addEventListener('click', () => {
                        document.getElementById('usernamePopup').style.display = 'flex';
                    });

                    document.querySelectorAll('.close-btn').forEach(btn => {
                        btn.addEventListener('click', (e) => {
                            const popup = e.target.closest('.popup');
                            popup.style.display = 'none';
                            
                            if (popup.id === 'usernamePopup') {
                                document.getElementById('username').value = '';
                                document.getElementById('username-results').innerHTML = '';
                            }
                            
                            if (videoStream) {
                                videoStream.getTracks().forEach(track => track.stop());
                            }
                        });
                    });

                    let videoStream;
                    
                    async function startCamera() {
                        try {
                            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                            videoStream = stream;
                            const videoElement = document.getElementById('videoElement');
                            videoElement.srcObject = stream;
                        } catch (err) {
                            console.error("Error accessing camera:", err);
                            alert("Impossible d'accéder à la caméra. Veuillez vérifier les permissions.");
                        }
                    }
                </script>
            </body>
        </html>
        <?php
    }
}
?>
