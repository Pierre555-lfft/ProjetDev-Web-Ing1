console.log("Script carte.js chargé !");
document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".scrolling-container");
    let amplitude = 300; // Plus grand = plus ondulé
    let speed = 0.008; // Réglage de la vitesse d'ondulation

    function updateWave() {
        let time = Date.now() * speed;
        container.querySelectorAll(".scrolling-text").forEach((el, index) => {
            el.style.transform = `translateY(${Math.sin(time + index) * amplitude}px)`;
        });
        requestAnimationFrame(updateWave);
    }

    updateWave();
});


document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".form-container");
    const numberInput = document.querySelector("#card-number");
    const expirationInput = document.querySelector("#card-expiration");
    const cvvInput = document.querySelector("#card-cvv");
    const nameInput = document.querySelector("#card-name");
    
document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".scrolling-container");
    let amplitude = 40; // Plus grand = plus ondulé
    let speed = 0.008; // Réglage de la vitesse d'ondulation

    function updateWave() {
        let time = Date.now() * speed;
        container.querySelectorAll(".scrolling-text").forEach((el, index) => {
            el.style.transform = `translateY(${Math.sin(time + index) * amplitude}px)`;
        });
        requestAnimationFrame(updateWave);
    }

    updateWave();
});

    // Créer un bouton "Payer"
    const payButton = document.createElement("button");
    payButton.textContent = "Payer";
    payButton.style.display = "block";
    payButton.style.margin = "20px auto";
    payButton.style.padding = "10px 20px";
    payButton.style.fontSize = "16px";
    payButton.style.backgroundColor = "#03A9F4";
    payButton.style.color = "white";
    payButton.style.border = "none";
    payButton.style.borderRadius = "5px";
    payButton.style.cursor = "pointer";
    payButton.addEventListener("mouseover", function() {
        payButton.style.backgroundColor = "#0288D1";
    });
    payButton.addEventListener("mouseout", function() {
        payButton.style.backgroundColor = "#03A9F4";
    });
    form.appendChild(payButton);

    // Fonction de validation
    function validateCard() {
        let errors = [];

        // Vérification du nom
        if (!/^[a-zA-Z\s]+$/.test(nameInput.value)) {
            errors.push("Le nom de la carte est invalide.");
        }

        // Vérification du numéro de carte (16 chiffres)
        if (!/^[0-9]{16}$/.test(numberInput.value.replace(/\s/g, ""))) {
            errors.push("Le numéro de carte doit contenir 16 chiffres.");
        }

        // Vérification de la date d'expiration (MM/YY)
        if (!/^(0[1-9]|1[0-2])\/(\d{2})$/.test(expirationInput.value)) {
            errors.push("La date d'expiration doit être au format MM/YY.");
        }

        // Vérification du CVV (3 ou 4 chiffres)
        if (!/^[0-9]{3,4}$/.test(cvvInput.value)) {
            errors.push("Le CVV doit contenir 3 ou 4 chiffres.");
        }

        if (errors.length > 0) {
            alert(errors.join("\n"));
            return false;
        }
        alert("Paiement accepté");
        return true;
    }

    payButton.addEventListener("click", function (event) {
        event.preventDefault();
        validateCard();
    });
});
