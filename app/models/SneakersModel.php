<?php

class SneakersModel
{
    private $db;

    public function __construct()
    {
        /** Door het maken van een database instantie
         *  kunnen we de database functies gebruiken
         *  en hebben we een verbinding met de database
         */
        $this->db = new Database();
    }

    public function getAllSneakers()
    {
        $sql = 'SELECT SNKS.Id
                      ,SNKS.Merk
                      ,SNKS.Model 
                      ,SNKS.Type
                      ,FORMAT(SNKS.Prijs, 2, "nl_NL") as Prijs       
        
                FROM Sneakers as SNKS
                
                ORDER BY SNKS.Merk ASC';

        $this->db->query($sql);

        return $this->db->resultSet();
    }
    
    public function insertSneaker($post)
    {
        $sql = "INSERT INTO Sneakers (Merk
                                     ,Model
                                     ,Type
                                     ,Prijs
                                     ,IsActief
                                     ,DatumAangemaakt
                                     ,DatumGewijzigd)
                VALUES              (:merk
                                    ,:model
                                    ,:type
                                    ,:prijs
                                    ,1
                                    ,SYSDATE(3)
                                    ,SYSDATE(3))";

        $this->db->query($sql);
        $this->db->bind(':merk', $post['merk'], PDO::PARAM_STR);
        $this->db->bind(':model', $post['model'], PDO::PARAM_STR);
        $this->db->bind(':type', $post['type'], PDO::PARAM_STR);
        $this->db->bind(':prijs', $post['prijs'], PDO::PARAM_STR);
        return $this->db->execute();
    }
    
    public function delete($id)
    {
        $sql = 'DELETE FROM Sneakers WHERE Id = :id';

        $this->db->query($sql);
        $this->db->bind(':id', $id, PDO::PARAM_INT);

        return $this->db->execute();
    }
}