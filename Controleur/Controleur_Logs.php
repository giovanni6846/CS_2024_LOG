<?php

use App\Modele\Modele_Logs;
use App\Modele\Modele_User;

//$type = ''  Type d'action description
//$action = 1 Action précise (lecture,ecriture,suppression)
if (isset($_SESSION['idUtilisateur'])) {
    $Utilisateur = Modele_User::Utilisateur_Select_id($_SESSION['idUtilisateur']);
    Modele_Logs::Write_Logs($Utilisateur,$type,$action);
} else {
    $Utilisateur = Modele_User::Utilisateur_Select_Login($_REQUEST["compte"]);
    Modele_Logs::Write_Logs($Utilisateur,$type,$action);
}


