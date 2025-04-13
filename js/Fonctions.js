// Redirige l'utilisateur vers l'accueil
function accueil() {
  window.location.href = "accueil.php";
}
// Redirige l'utilisateur vers la billetterie
function billetterie() {
  window.location.href = "billetterie.php";
}
// Redirige l'utilisateur vers presentation
function presentation() {
  window.location.href = "presentation.php";
}
// Redirige l'utilisateur vers tarifs
function tarifs() {
  window.location.href = "tarifs.php";
}
// Redirige l'utilisateur vers galerie
function objets_connectes() {
  window.location.href = "objets_connectes.php";
}
// Redirige l'utilisateur vers NousContacter
function contact() {
  window.location.href = "contact.php";
}
// Redirige l'utilisateur vers nvMembre
function adhesion() {
  window.location.href = "nvMembre.php";
}
// Redirige l'utilisateur vers galerieMineraux
function minerauxetfossiles() {
  window.location.href = "galerieMineraux.php";
}
// Redirige l'utilisateur vers galerieSorties
function sorties() {
  window.location.href = "galerieSorties.php";
}
// Redirige l'utilisateur vers galerieExpos
function expos() {
  window.location.href = "galerieExpos.php";
}
// Redirige l'utilisateur vers galerieDGeo
function DGeo() {
  window.location.href = "galerieDGeo.php";
}
// Redirige l'utilisateur vers listeAffiche
function listeAffiche() {
  window.location.href = "listeAffiche.php";
}
// Redirige l'utilisateur vers actualite
function revenirActualite() {
  window.location.href = "actualite.php";
}
// Redirige l'utilisateur vers listePublication
function listePublication() {
  window.location.href = "listePublication.php";
}
// Redirige l'utilisateur vers formAffiche
function Affiche() {
  window.location.href = "formAffiche.php";
}
// Redirige l'utilisateur vers formPublication
function Publication() {
  window.location.href = "formPublication.php";
}
// Redirige l'utilisateur vers formForum
function Forum() {
  window.location.href = "formForum.php";
}
// Redirige l'utilisateur vers connexion
function connexion() {
  window.location.href = "connexion.php";
}
// Redirige l'utilisateur vers deconnexion
function deconnexion() {
  window.location.href = "deconnexion.php";
}
// Redirige l'utilisateur vers pageMembre
function espaceClient() {
  window.location.href = "espaceClient.php";
}
// Redirige l'utilisateur vers upload
function admin() {
  window.location.href = "admin.php";
}
// Redirige l'utilisateur vers mdpAdmin
function mdpAdmin() {
  window.location.href = "mdpAdmin.php";
}

//Affiche le message de succes 5 secondes
setTimeout(function() {
    var message = document.getElementById('success-message');
    if (message) {
        message.innerHTML = ''; // Rend le contenu vide
    }
}, 5000); // Disparaît après 5 secondes (5000 millisecondes)


//Gere les parametres du calendrier
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendrier2');
    if (calendarEl) {
        // Charger la localisation française
        var script = document.createElement('script');
        script.src = 'chemin_vers_fullcalendar/locales/fr.js';
        script.defer = true;
        document.head.appendChild(script);

        var events = [];
        fetch('evenements.csv')
            .then(response => response.text())
            .then(text => {
                const rows = text.split('\n');
                let i = 1;
                rows.forEach(row => {
                    const data = row.split(',');
                    if (data.length >= 5) {
                        const title = data[0];
                        const start = data[1];
                        const end = data[2];
                        const color = data[3];
                        events.push({
                            title: title,
                            start: start,
                            end: end,
                            backgroundColor: color,
                            borderColor: color,
                            url: 'descrptionEvenements.php#evenement' + i
                        });
                        i++;
                    }
                });

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'fr',
                    initialView: 'dayGridMonth',
                    events: events,
                    height: 'auto',
                    contentHeight: 600,
                    aspectRatio: 2,
                    eventClick: function(info) {
                        if (info.event.url) {
                            window.location.href = info.event.url;
                            info.jsEvent.preventDefault();
                        }
                    }
                });
                calendar.render();
            });
    }
});

//Permet de gerer le telechargement de pptx
document.addEventListener('DOMContentLoaded', function() {
    const pptxInput = document.getElementById('pptxInput');
    if (pptxInput) {
        pptxInput.addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (!file) return;

            var reader = new FileReader();
            reader.onload = function(event) {
                var pptxBlob = event.target.result;
                var downloadLink = document.getElementById('downloadButton');
                if (downloadLink) {
                    downloadLink.href = pptxBlob;
                    downloadLink.download = file.name;
                    downloadLink.style.display = 'block';
                }
            };
            reader.readAsDataURL(file);
        });
    }
});

// Calcul du total en temps réel du fichier billeterie.php
document.addEventListener('DOMContentLoaded', function() {
    const numberInputs = document.querySelectorAll('input[type="number"]');
    if (numberInputs.length > 0) {
        numberInputs.forEach(input => {
            input.addEventListener('change', calculateTotal);
        });
    }
});

function calculateTotal() {
    const adultes = document.getElementById('adultes').value * 52;
    const enfants = document.getElementById('enfants').value * 44;
    const seniors = document.getElementById('seniors').value * 44;
    const reduits = document.getElementById('reduits').value * 44;
    
    const total = adultes + enfants + seniors + reduits;
    const totalElement = document.getElementById('total-price');
    if (totalElement) {
        totalElement.textContent = total + ' €';
    }
}

// Gestionnaire d'événements pour l'envoi des emails
document.addEventListener('DOMContentLoaded', function() {
    const sendEmailsBtn = document.getElementById('sendEmailsBtn');
    if (sendEmailsBtn) {
        sendEmailsBtn.addEventListener('click', async function() {
            const fromEmail = document.getElementById('fromEmail').value;
            const emailSubject = document.getElementById('emailSubject').value;
            const emailContent = document.getElementById('emailContent').value;
            const fileInput = document.getElementById('fileInput');
            const statusMessage = document.getElementById('statusMessage');

            // Validation des champs
            if (!fromEmail || !emailSubject || !emailContent) {
                statusMessage.innerHTML = "Veuillez remplir tous les champs obligatoires";
                return;
            }

            // Création du FormData
            const formData = new FormData();
            formData.append('fromEmail', fromEmail);
            formData.append('emailSubject', emailSubject);
            formData.append('emailContent', emailContent);

            // Ajout du fichier s'il y en a un
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (file.size > 10 * 1024 * 1024) {
                    statusMessage.innerHTML = "Erreur : Le fichier joint est trop volumineux (maximum 10 MB)";
                    return;
                }
                formData.append('attachment', file);
            }

            // Affichage du message de chargement
            statusMessage.innerHTML = "Envoi des emails en cours...";

            try {
                const response = await fetch('envoyerEmails.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }

                const result = await response.text();
                statusMessage.innerHTML = result;
                
                // Réinitialisation du formulaire après succès
                if (!result.includes("erreur")) {
                    fileInput.value = '';
                    document.querySelector('.file-info').textContent = 
                        'Formats acceptés : CSV, Excel, PDF, Word, Text, Images (JPG, PNG)';
                }
            } catch (error) {
                statusMessage.innerHTML = "Erreur lors de l'envoi des emails : " + error.message;
                console.error('Erreur:', error);
            }
        });
    }
});

// Validation de l'email
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('fromEmail');
    if (emailInput) {
        emailInput.addEventListener('input', function(e) {
            const email = e.target.value;
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            if (emailRegex.test(email)) {
                e.target.style.borderColor = '#7c5308';
                e.target.setCustomValidity('');
            } else {
                e.target.style.borderColor = '#ff4444';
                e.target.setCustomValidity('Veuillez entrer une adresse email valide');
            }
        });
    }
});