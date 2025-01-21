/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import "./styles/app.scss";

const burger = document.querySelector(".burger");
const nav = document.querySelector(".nav-links");

burger.addEventListener("click", () => {
  nav.classList.toggle("nav-active");
  burger.classList.toggle("toggle");
});

document.addEventListener("DOMContentLoaded", function () {
  const addToCartForms = document.querySelectorAll(".add-to-cart-form");

  addToCartForms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      e.preventDefault(); // Empêche la soumission du formulaire de manière classique

      const formData = new FormData(this);
      const actionUrl = this.getAttribute("action");

      // Envoi de la requête AJAX pour ajouter au panier
      fetch(actionUrl, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Mettre à jour le compteur du panier
            const cartCount = document.querySelector(".cart-count");
            cartCount.textContent = data.cartLength;

            // Afficher un message de succès ou une notification
            alert("Produit ajouté au panier !");
          } else {
            alert("Erreur lors de l'ajout au panier.");
          }
        })
        .catch((error) => {
          console.error("Erreur:", error);
        });
    });
  });

  // Logique pour basculer entre le formulaire de connexion et d'inscription
  const switchToRegister = document.getElementById("switch-to-register");
  const switchToLogin = document.getElementById("switch-to-login");
  const loginForm = document.getElementById("login-form");
  const registerForm = document.getElementById("register-form");
  const formIntro = document.getElementById("form-intro");

  if (
    switchToRegister &&
    switchToLogin &&
    loginForm &&
    registerForm &&
    formIntro
  ) {
    switchToRegister.addEventListener("click", function (event) {
      event.preventDefault();
      loginForm.style.display = "none";
      registerForm.style.display = "block";
      formIntro.textContent =
        "Entre tes informations pour t'inscrire et passer au paiement :";
    });

    switchToLogin.addEventListener("click", function (event) {
      event.preventDefault();
      registerForm.style.display = "none";
      loginForm.style.display = "block";
      formIntro.textContent =
        "Entre tes informations pour te connecter et passer au paiement :";
    });
  }
});
