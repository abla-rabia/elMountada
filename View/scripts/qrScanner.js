document.addEventListener('DOMContentLoaded', function() {
    const videoElement = document.getElementById('videoElement');
    const resultDiv = document.getElementById('scanResult');
    let videoStream;
    let html5QrcodeScanner = null;

    async function startScanner() {
        try {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "videoElement", 
                { 
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    showTorchButtonIfSupported: true
                }
            );
            
            html5QrcodeScanner.render(onScanSuccess, onScanError);
        } catch (err) {
            console.error("Erreur lors du démarrage du scanner:", err);
            alert("Impossible d'accéder à la caméra. Veuillez vérifier les permissions.");
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        // Arrêter le scanner après une lecture réussie
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
        }

        // Envoyer le code QR au serveur
        $.ajax({
            url: 'index.php?router=verifyQRCode',
            method: 'POST',
            data: { qr_code: decodedText },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showResult(`
                        <div class="success-scan">
                            <h3>Membre vérifié !</h3>
                            <p>Nom: ${response.user.nom} ${response.user.prenom}</p>
                            <p>Type de carte: ${response.carte.type}</p>
                            <p>Remises disponibles: ${response.carte.remises}</p>
                        </div>
                    `);
                } else {
                    showResult(`
                        <div class="error-scan">
                            <p>Code QR invalide ou expiré</p>
                        </div>
                    `);
                }
            },
            error: function() {
                showResult(`
                    <div class="error-scan">
                        <p>Erreur lors de la vérification</p>
                    </div>
                `);
            }
        });
    }

    function onScanError(error) {
        console.warn(`Erreur de scan: ${error}`);
    }

    function showResult(html) {
        const resultDiv = document.getElementById('scanResult');
        if (resultDiv) {
            resultDiv.innerHTML = html;
        }
    }

    // Initialiser le scanner quand on ouvre le popup
    document.getElementById('scanUserBtn').addEventListener('click', function() {
        document.getElementById('scannerPopup').style.display = 'flex';
        startScanner();
    });

    // Arrêter le scanner quand on ferme le popup
    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }
            document.getElementById('scannerPopup').style.display = 'none';
        });
    });
});