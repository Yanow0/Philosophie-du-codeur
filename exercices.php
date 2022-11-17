<?php

//EXERCICE 1
enum Tri {
case TRI_CROISSANT;
case TRI_DECROISSANT;
}

/**
 * @param array<int> $tab
 * @param Tri $tri
 * @return array<int>
 */
function triTableau($monTableau, $tri)
{
    if ($tri == Tri::TRI_CROISSANT) {
        for ($i = 0; $i < count($monTableau); $i++) {
            for ($j = 0; $j < count($monTableau); $j++) {
                if ($monTableau[$i] < $monTableau[$j]) {
                    $temp = $monTableau[$i];
                    $monTableau[$i] = $monTableau[$j];
                    $monTableau[$j] = $temp;
                }
            }
        }
        return $monTableau;
    } else {
        for ($i = 0; $i < count($monTableau); $i++) {
            for ($j = 0; $j < count($monTableau); $j++) {
                if ($monTableau[$i] > $monTableau[$j]) {
                    $temp = $monTableau[$i];
                    $monTableau[$i] = $monTableau[$j];
                    $monTableau[$j] = $temp;
                }
            }
        }
        return $monTableau;
    }
    return $monTableau;
}

echo "Exercice 1 : Tri d'un tableau de nombres entiers \n";

$tab = [];
for ($i = 0; $i < 10; $i++) {
    $tab[] = rand(0, 100);
}
print_r(triTableau($tab, Tri::TRI_CROISSANT));

$tab = [];
for ($i = 0; $i < 10; $i++) {
    $tab[] = rand(0, 100);
}
print_r(triTableau($tab, Tri::TRI_DECROISSANT));

echo "\n";
echo "=========================";

//EXERCICE 2

/**
 * @param array<int> $tabA
 * @param array<int> $tabB
 * @return array<bool, int, bool, bool>
 */
function compareTableau($tabA, $tabB)
{
    $sontEgaux = true;
    foreach ($tabA as $key => $value) {
        if ($value != $tabB[$key]) {
            $sontEgaux = false;
        }
    }

    $nbValeursComm = 0;
    for ($i = 0; $i < count($tabA); $i++) {
        for ($j = 0; $j < count($tabB); $j++) {
            if ($tabA[$i] == $tabB[$j]) {
                $nbValeursComm++;
            }
        }
    }

    $estPalindrome = $tabA == array_reverse($tabB);

    $tabAContientTabB = true;
    foreach ($tabB as $value) {
        if (!in_array($value, $tabA)) {
            $tabAContientTabB = false;
        }
    }
    return [$sontEgaux, $nbValeursComm, $estPalindrome, $tabAContientTabB];
}

echo "==================== \n";
echo "Exercice 2 : \n";

$tabA = [1, 2, 3, 4, 5];
$tabB = [1, 2, 3, 4, 5];
$tabC = [1, 2, 3, 4, 5, 6];
$tabD = [5, 4, 3, 2, 1];
$tabE = [1, 2, 3, 4, 6];

print_r(compareTableau($tabA, $tabB));
print_r(compareTableau($tabA, $tabC));
print_r(compareTableau($tabA, $tabD));
print_r(compareTableau($tabA, $tabE));

//EXERCICE 3

/**
 * @param string $date1
 * @param string $date2
 * @return int
 */
function diffJour($date1, $date2)
{
    $date1 = stringToArray("-", $date1);
    $date2 = stringToArray("-", $date2);

    $timestamp1 = timestampFromDate($date1[0], $date1[1], $date1[2]);
    $timestamp2 = timestampFromDate($date2[0], $date2[1], $date2[2]);

    $difference = absolute($timestamp2 - $timestamp1);

    $nombreJour = $difference / 86400;

    return $nombreJour;
}

/**
 * @param int $month
 * @param int $day
 * @param int $year
 * @return int
 */
function timestampFromDate($day, $month, $year)
{
    $timestamp = 0;
    $timestamp += $day * 60 * 60 * 24;
    $timestamp += $month * 60 * 60 * 24 * 30;
    $timestamp += $year * 60 * 60 * 24 * 30 * 12;
    return $timestamp;
}

/**
 * @param string $delimiter
 * @param string $string
 * @return array<string>
 */
function stringToArray($delimiter, $string)
{
    $tab = [];
    $temp = "";
    for ($i = 0; $i < sizeString($string); $i++) {
        if ($string[$i] == $delimiter) {
            $tab[] = $temp;
            $temp = "";
        } else {
            $temp .= $string[$i];
        }
    }
    $tab[] = $temp;
    return $tab;
}

/**
 * @param string $string
 * @return int
 */
function sizeString($string)
{
    $i = 0;
    while (isset($string[$i])) {
        $i++;
    }
    return $i;
}

/**
 * @param int $number
 * @return int
 */
function absolute($number)
{
    if ($number < 0) {
        return -$number;
    } else {
        return $number;
    }
}

echo "==================== \n";
echo "Exercice 3 : \n";

echo diffJour("01-01-2019", "01-01-2020");
echo "\n";
echo diffJour("01-01-2019", "02-01-2019");

//EXERCICE 4

/**
 * @param int $id
 * @param float $montant
 * @param TypePaiement $typePaiement
 * @return int
 */

class Transaction
{
    public $id;
    public $montant;
    public $idCommande;
    public $typePaiement;
    public $token;

    public function __construct($id, $montant, $idCommande, $typePaiement, $token)
    {
        $this->id = $id;
        $this->montant = $montant;
        $this->idCommande = $idCommande;
        $this->typePaiement = $typePaiement;
        $this->token = $token;
    }
}

/**
 * @param array<Transaction> $tabTransactions
 * @return array<Transaction>
 */
function valideTransactions($tabTransactions)
{
    $transactionsInvalides = [];
    if (count($tabTransactions) > 0) {
        for ($i = count($tabTransactions) - 1; $i >= 0; $i--) {
            if ($i > 0) {
                $tokenCalcule = hash('sha256', $tabTransactions[$i]->id . $tabTransactions[$i]->montant . $tabTransactions[$i]->idCommande . $tabTransactions[$i]->typePaiement . $tabTransactions[$i - 1]->token);
                if ($tabTransactions[$i]->token != $tokenCalcule) {
                    $transactionsInvalides[] = $tabTransactions[$i];
                }
            } else {
                break;
            }
        }
    }
    return $transactionsInvalides;
}

echo "=================== \n";
echo "Exercice 4 : \n";

$transactions1 = [
    new Transaction(1, 25.58, 3, 2, "6d715649b31dceb5d092a68161ed18998b78e3c0ccf98c48665bd2a2fab95d4a"),
    new Transaction(2, 34, 5, 2, "7fb2016c8a2534503b8a0d08771d5c14ca4efb92044da28192e8648b31211134"),
    new Transaction(3, 12, 6, 1, "72200e576cf623581ca8cbe2cf367494a0be83e282d9a0841812c3f81ab68650"),
    new Transaction(4, 67, 7, 0, "ea2e9932a8abc9119dc73bc440b310e0d427416b039323349aafeb52ca4f5b96"),
];

$transactions2 = [
    new Transaction(1, 25.58, 3, 2, "6d715649b31dceb5d092a68161ed18998b78e3c0ccf98c48665bd2a2fab95d4a"),
    new Transaction(2, 14, 5, 2, "7fb2016c8a2534503b8a0d087f1d5c14ca4efb92044da28192e8648b31211134"),
    new Transaction(3, 12, 6, 1, "72200e576cf623581ca8cbe2cf367494a0be83e282d9a0841812c3f81ab68650"),
    new Transaction(4, 67, 7, 0, "ea2e9932a8abc9119dc73bc440b310e0d427416b039323349aafeb52ca4f5b96"),
];

echo "\n";
echo "Tableau des transactions invalides du tableau 1 (tableau vide normalement) : \n";

$transacInv1 = valideTransactions($transactions1);
print_r($transacInv1);

echo "\n";
echo "Tableau des transactions invalides du tableau 2 : \n";

$transacInv2 = valideTransactions($transactions2);
print_r($transacInv2);
