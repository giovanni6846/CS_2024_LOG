<?php

namespace App\Modele;

use App\Utilitaire\Singleton_WritePDO;
use PDO;

class Modele_Logs
{
    static function Write_Logs($idUtilisateur,$type,$action)
    {
        $connexionPDO = Singleton_WritePDO::getInstance();

        $requetePreparee = $connexionPDO->prepare(
            'INSERT INTO `logs` (`user_id`, `action_id`, `details`) 
                    VALUES (:paramUser_id, :paramAction_id, :paramdetails);'
        );

        $requetePreparee->bindParam('paramUser_id', $idUtilisateur);
        $requetePreparee->bindParam('paramAction_id', $action);
        $requetePreparee->bindParam('paramdetails', $type);

        $requetePreparee->execute();

    }
}