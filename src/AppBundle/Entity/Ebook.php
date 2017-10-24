<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ebook")
 */
class Ebook
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @ORM\Column(type="string", length=100)
    */
    private $codice;

    /**
    * @ORM\Column(type="string", length=100)
    */
    private $epub;

    public function getCodice()
    {
        return $this->codice;
    }

    public function setCodice($codice)
    {
        $this->codice = $codice;
    }

    public function getEpub()
    {
        return $this->epub;
    }

    public function setEpub($epub)
    {
        $this->epub = $epub;
    }
}