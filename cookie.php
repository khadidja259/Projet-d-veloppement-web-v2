<?php
// Vérifie si le cookie "visites" existe
if(isset($_COOKIE['visites'])) {
    // Incrémente le nombre de visites
    $visites = $_COOKIE['visites'] + 1;
} else {
    // Première visite
    $visites = 1;
}

// Met à jour le cookie (valable 30 jours)
setcookie('visites', $visites, time() + 30*24*60*60, "/");
