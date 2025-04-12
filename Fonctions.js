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
// Redirige l'utilisateur vers activite
function activite() {
  window.location.href = "activite.php";
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
function membre() {
  window.location.href = "pageMembre.php";
}
// Redirige l'utilisateur vers upload
function admin() {
  window.location.href = "upload.php";
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


//Permet de gerer les images dans la gallerie
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById("myModal");

    var modalImg = document.getElementById("modal-image");
    var captionText = document.getElementById("caption");

    // Obtiens les images de la galerie
    var images = document.querySelectorAll('.image-container img');
    images.forEach(function (img) {
        img.addEventListener('click', function () {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.nextElementSibling.innerHTML;
        });
    });

    // ferme le modal
    var span = document.getElementsByClassName("close")[0];

    // le modal se ferme quand l'utilisateur clique sur fermer
    span.onclick = function () {
        modal.style.display = "none";
    }

    // Si l'utilisateur clique n'importe ou, le modal se ferme
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

//Gere les parametres du calendrier
document.addEventListener('DOMContentLoaded', function() {
    // Charger la localisation française
    var script = document.createElement('script');
    script.src = 'chemin_vers_fullcalendar/locales/fr.js';
    script.defer = true;
    document.head.appendChild(script);

    var calendarEl = document.getElementById('calendrier2');
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
                       url: 'descrptionEvenements.php#evenement' + i //envemement cliquables
                   });
                   i++;
               }
           });

           //parametre du calendrier supplementaires
           var calendar = new FullCalendar.Calendar(calendarEl, {
               locale: 'fr', // Spécifier la langue française
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
           calendar.render(); //affiche le calendrier
       });

});

//Permet de gerer le telechargement de pptx
document.getElementById('pptxInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    if (!file) return;

    var reader = new FileReader();
    reader.onload = function(event) {
        var pptxBlob = event.target.result;
        var downloadLink = document.getElementById('downloadButton');
        downloadLink.href = pptxBlob;
        downloadLink.download = file.name;
        downloadLink.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

 // Calcul du total en temps réel du fichier billeterie.php
 document.querySelectorAll('input[type="number"]').forEach(input => {
  input.addEventListener('change', calculateTotal);
});

function calculateTotal() {
  const adultes = document.getElementById('adultes').value * 52;
  const enfants = document.getElementById('enfants').value * 44;
  const seniors = document.getElementById('seniors').value * 44;
  const reduits = document.getElementById('reduits').value * 44;
  
  const total = adultes + enfants + seniors + reduits;
  document.getElementById('total-price').textContent = total + ' €';
}