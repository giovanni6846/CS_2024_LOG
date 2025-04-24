<?php

namespace App\Modele;

use App\Utilitaire\Singleton_ReadPDO;
use App\Utilitaire\Singleton_WritePDO;
use PDO;

class Modele_User
{
    static function Utilisateur_Select_id($idUtilisateur)
    {
            $connexionPDO = Singleton_ReadPDO::getInstance();
            // Préparer la requête pour vérifier si l'utilisateur existe
            $requetePreparee = $connexionPDO->prepare('
                SELECT * FROM `users` WHERE idUtilisateur = :idUtilisateur;
                    ');
            $requetePreparee->bindParam('idUtilisateur', $idUtilisateur);
            $requetePreparee->execute();

            $tableauReponse = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);

            // Vérifier si aucun utilisateur n’a été trouvé
            if (empty($tableauReponse)) {
                $connexionPDO = Singleton_WritePDO::getInstance();
                // Préparer l'insertion de l'utilisateur si il n'existe pas
                $requeteInsertion = $connexionPDO->prepare('
                    INSERT INTO `users` (idUtilisateur, login)
                    VALUES (:idUtilisateur, :login);
                    ');
                // Ici tu dois avoir les infos à insérer : $username et $email
                $requeteInsertion->bindParam('idUtilisateur', $_SESSION['idUtilisateur']);
                $requeteInsertion->bindParam('login', $_SESSION['login']);
                $requeteInsertion->execute();
                Modele_User::Utilisateur_Select_id($_SESSION['idUtilisateur']);
            } else {
                return $tableauReponse[0]['id'];
            }
    }

    static function Utilisateur_Select_Login($login)
    {
        $connexionPDO = Singleton_ReadPDO::getInstance();
        // Préparer la requête pour vérifier si l'utilisateur existe
        $requetePreparee = $connexionPDO->prepare('
                SELECT * FROM `users` WHERE login = :login;
                    ');
        $requetePreparee->bindParam('login', $login);
        $requetePreparee->execute();

        $tableauReponse = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
        if (empty($tableauReponse)) {
            $utilisateur = Modele_Utilisateur::Utilisateur_Select_ParLogin($login);
            $connexionPDO = Singleton_WritePDO::getInstance();
            // Préparer l'insertion de l'utilisateur si il n'existe pas
            $requeteInsertion = $connexionPDO->prepare('
                    INSERT INTO `users` (idUtilisateur, login)
                    VALUES (:idUtilisateur, :login);
                    ');
            // Ici tu dois avoir les infos à insérer : $username et $email
            $requeteInsertion->bindParam('idUtilisateur', $utilisateur['idUtilisateur']);
            $requeteInsertion->bindParam('login', $login);
            $requeteInsertion->execute();
            Modele_User::Utilisateur_Select_id($utilisateur['idUtilisateur']);
        } else {
            return $tableauReponse[0]['id'];
        }
    }
}