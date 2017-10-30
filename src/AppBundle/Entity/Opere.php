<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="opere")
 */
class Opere
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
    private $titolo;

    /**
    * @ORM\Column(type="string", length=100)
    */
    private $autore;

    /**
    * @ORM\Column(type="string", length=100)
    */
    private $isbn;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private $nomefile;


    /**
     * @ORM\OneToMany(targetEntity="Codici", mappedBy="opere")
     */
    private $codici;


    public function getId()
    {
        return $this->id;
    }

    public function getNomefile()
    {
        return $this->nomefile;
    }

    public function setNomefile($nomefile)
    {
        $this->nomefile = $nomefile;
    }

    public function getAutore()
    {
        return $this->autore;
    }

    public function setAutore($autore)
    {
        $this->autore = $autore;
    }

    public function getTitolo()
    {
        return $this->titolo;
    }

    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

    public function getInfo()
    {
        return $this->titolo . " - " . $this->autore . "(" . $this->isbn .")";
    }
}