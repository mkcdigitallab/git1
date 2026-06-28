<?php

$wallets = [];
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

function telephoneValide($telephone)
{
    if (strlen($telephone) != 9) {
        return false;
    }

    $prefixes = ["77", "78", "76", "70", "75"];

    foreach ($prefixes as $prefixe) {
        if (substr($telephone, 0, 2) == $prefixe) {
            return true;
        }
    }

    return false;
}

function codeValide($code)
{
    return strlen($code) == 4;
}

function telephoneExiste($wallets, $telephone)
{
    foreach ($wallets as $wallet) {
        if ($wallet["telephone"] == $telephone) {
            return true;
        }
    }

    return false;
}

function codeExiste($wallets, $code)
{
    foreach ($wallets as $wallet) {
        if ($wallet["code"] == $code) {
            return true;
        }
    }

    return false;
}

function chercherWallet($wallets, $telephone)
{
    foreach ($wallets as $index => $wallet) {
        if ($wallet["telephone"] == $telephone) {
            return $index;
        }
    }

    return -1;
}

function creerWallet(&$wallets)
{
    echo "Nom du client : ";
    $client = trim(readline());

    echo "Téléphone : ";
    $telephone = trim(readline());

    echo "Code secret (4 caractères) : ";
    $code = trim(readline());

    echo "Solde initial : ";
    $solde = (float) readline();

    if (
        $client == "" ||
        $telephone == "" ||
        $code == ""
    ) {
        echo "Champs obligatoires\n";
        return;
    }

    if (!telephoneValide($telephone)) {
        echo "Téléphone invalide\n";
        return;
    }

    if (!codeValide($code)) {
        echo "Le code doit contenir 4 caractères\n";
        return;
    }

    if ($solde < 0) {
        echo "Solde invalide\n";
        return;
    }

    if (telephoneExiste($wallets, $telephone)) {
        echo "Téléphone déjà utilisé\n";
        return;
    }

    if (codeExiste($wallets, $code)) {
        echo "Code déjà utilisé\n";
        return;
    }

    $wallets[] = [
        "client" => $client,
        "telephone" => $telephone,
        "code" => $code,
        "solde" => $solde
    ];

    echo "Wallet créé avec succès\n";
}

function faireDepot(&$wallets, &$transactions)
{
    echo "Téléphone : ";
    $telephone = trim(readline());

    $position = chercherWallet($wallets, $telephone);

    if ($position == -1) {
        echo "Wallet introuvable\n";
        return;
    }

    echo "Montant : ";
    $montant = (float) readline();

    if ($montant <= 0) {
        echo "Montant invalide\n";
        return;
    }

    $wallets[$position]["solde"] += $montant;

    $transactions[] = "DEPOT - $telephone - $montant CFA";

    echo "Dépôt effectué\n";
}

function calculerFrais($montant)
{
    $frais = $montant * 0.01;

    if ($frais > 5000) {
        $frais = 5000;
    }

    return $frais;
}

function faireRetrait(&$wallets, &$transactions)
{
    echo "Téléphone : ";
    $telephone = trim(readline());

    $position = chercherWallet($wallets, $telephone);

    if ($position == -1) {
        echo "Wallet introuvable\n";
        return;
    }

    echo "Montant retrait : ";
    $montant = (float) readline();

    if ($montant <= 0) {
        echo "Montant invalide\n";
        return;
    }

    $frais = calculerFrais($montant);
    $total = $montant + $frais;

    if ($wallets[$position]["solde"] < $total) {
        echo "Solde insuffisant\n";
        return;
    }

    $wallets[$position]["solde"] -= $total;

    $transactions[] =
        "RETRAIT - $telephone - $montant CFA - frais $frais";

    echo "Retrait effectué\n";
}

function afficherTransactions($transactions)
{
    if (count($transactions) == 0) {
        echo "Aucune transaction\n";
        return;
    }

    foreach ($transactions as $transaction) {
        echo $transaction . "\n";
    }
}

do {

    afficherMenu();

    $choix = readline("Choix : ");

    switch ($choix) {

        case 1:
            creerWallet($wallets);
            break;

        case 2:
            faireDepot($wallets, $transactions);
            break;

        case 3:
            faireRetrait($wallets, $transactions);
            break;

        case 4:
            afficherTransactions($transactions);
            break;

        case 0:
            echo "Fin du programme\n";
            break;

        default:
            echo "Choix invalide\n";
    }

} while ($choix != 0);

?>
