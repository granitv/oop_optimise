<?php


namespace App\Models;


class Association
{

private $id;
    private $conducteur;
    private $vehicule;

    /**
     * @return mixed
     */
    public function getVehicule()
    {
        return $this->vehicule;
    }

    /**
     * @param mixed $vehicule
     */
    public function setVehicule($vehicule)
    {
        $this->vehicule = $vehicule;
    }

    /**
     * @return mixed
     */
    public function getConducteur()
    {
        return $this->conducteur;
    }

    /**
     * @param mixed $conducteur
     */
    public function setConducteur($conducteur)
    {
        $this->conducteur = $conducteur;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
