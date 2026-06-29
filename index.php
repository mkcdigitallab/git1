<?php

require "controller.php";

$wallets      = [];
$transactions = [];

function afficherMenu()
{
    echo "\n===== MENU DISTRIBUTEUR =====\n";
    echo "1. Créer Wallet\n";
    echo "2. Faire Dépôt\n";
    echo "3. Faire Retrait\n";
    echo "4. Lister les Transactions\n";
    echo "0. Quitter\n";
}

do {
    afficherMenu();

    $choix = trim(readline("Choix : "));

    switch ($choix) {
        case "1":
            controllerCreerWallet($wallets);
            break;

        case "2":
            controllerDepot($wallets, $transactions);
            break;

        case "3":
            controllerRetrait($wallets, $transactions);
            break;

        case "4":
            controllerTransactions($transactions);
            break;

        case "0":
            echo "Au revoir !\n";
            break;

        default:
            echo "Choix invalide, veuillez réessayer\n";
    }

} while ($choix != "0");
