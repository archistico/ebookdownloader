<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Codici
 *
 * @ORM\Table(name="codici")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CodiciRepository")
 */
class Codici
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codice", type="string", length=255, unique=true)
     */
    private $codice;

    /**
     * @var int
     *
     * @ORM\Column(name="download", type="integer")
     */
    private $download;

    /**
     * @ORM\ManyToOne(targetEntity="Opere", inversedBy="codici")
     * @ORM\JoinColumn(name="opere_id", referencedColumnName="id")
     */
    private $opere;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codice
     *
     * @param string $codice
     *
     * @return Codici
     */
    public function setCodice($codice)
    {
        $this->codice = $codice;

        return $this;
    }

    /**
     * Get codice
     *
     * @return string
     */
    public function getCodice()
    {
        return $this->codice;
    }

    /**
     * Set download
     *
     * @param integer $download
     *
     * @return Codici
     */
    public function setDownload($download)
    {
        $this->download = $download;

        return $this;
    }

    /**
     * Get download
     *
     * @return int
     */
    public function getDownload()
    {
        return $this->download;
    }
}

