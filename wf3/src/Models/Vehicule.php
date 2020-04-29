<?php


namespace App\Models;


class Vehicule
{

    private $id_vehicule;
    private $marque;
    private $modele;
    private $couleur;
    private $immatriculation;

    /**
     * @return mixed
     */
    public function getId_vehicule()
    {
        return $this->id_vehicule;
    }

    /**
     * @param mixed $id
     */
    public function setId_vehicule($id)
    {
        $this->id_vehicule = $id;
    }

    /**
     * @return mixed
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param mixed $marque
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
    }

    /**
     * @return mixed
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * @param mixed $modele
     */
    public function setModele($modele)
    {
        $this->modele = $modele;
    }

    /**
     * @return mixed
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * @param mixed $couleur
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    }

    /**
     * @return mixed
     */
    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    /**
     * @param mixed $immatriculation
     */
    public function setImmatriculation($immatriculation)
    {
        $this->immatriculation = $immatriculation;
    }


}
