<?php

require "services.php";

function controllerCreerWallet(&$wallets)
{
    echo "Nom du client : ";
    $client = trim(readline());

    echo "Téléphone : ";
    $telephone = trim(readline());

    echo "Code secret (4 caractères) : ";
    $code = trim(readline());

    echo "Solde initial : ";
    $solde = (float) readline();

    $resultat = serviceCreerWallet($wallets, $client, $telephone, $code, $solde);

    echo $resultat . "\n";
}

function controllerDepot(&$wallets, &$transactions)
{
    echo "Téléphone : ";
    $telephone = trim(readline());

    echo "Montant : ";
    $montant = (float) readline();

    $resultat = serviceDepot($wallets, $transactions, $telephone, $montant);

    echo $resultat . "\n";
}

function controllerRetrait(&$wallets, &$transactions)
{
    echo "Téléphone : ";
    $telephone = trim(readline());

    echo "Montant : ";
    $montant = (float) readline();

    $resultat = serviceRetrait($wallets, $transactions, $telephone, $montant);

    echo $resultat . "\n";
}

function controllerTransactions($transactions)
{
    echo "Filtrer par téléphone ? (laisser vide pour tout afficher) : ";
    $telephone = trim(readline());

    $telephone = $telephone == "" ? null : $telephone;

    $liste = serviceListeTransactions($transactions, $telephone);

    if (count($liste) == 0) {
        echo "Aucune transaction trouvée\n";
        return;
    }

    echo "\n--- Historique des transactions ---\n";
    foreach ($liste as $transaction) {
        echo $transaction . "\n";
    }
    echo "----------------------------------\n";
}
