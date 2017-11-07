<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

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
    * @Assert\NotBlank()
    */
    private $titolo;

    /**
    * @ORM\Column(type="string", length=100)
    * @Assert\NotBlank()
    */
    private $autore;

    /**
    * @ORM\Column(type="string", length=100)
    * @Assert\NotBlank()
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

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File(mimeTypes={ "application/pdf" }, mimeTypesMessage = "Caricare un file PDF valido")
     */
    private $filepdf;

    public function getFilepdf()
    {
        return $this->filepdf;
    }

    public function setFilepdf($file)
    {
        $this->filepdf = $file;
        return $this;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File(mimeTypes={ "application/epub+zip" }, mimeTypesMessage = "Caricare un file EPUB valido")
     */
    private $fileepub;

    public function getFileepub()
    {
        return $this->fileepub;
    }

    public function setFileepub($file)
    {
        $this->fileepub = $file;
        return $this;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File(mimeTypes={ "application/vnd.amazon.mobi8-ebook" }, mimeTypesMessage = "Caricare un file MOBI valido")
     */
    private $filemobi;
    
    public function getFilemobi()
    {
        return $this->filemobi;
    }

    public function setFilemobi($file)
    {
        $this->filemobi = $file;
        return $this;
    }

    public function __construct()
    {
        $this->codici = new ArrayCollection();
    }

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
        return $this->titolo . " - " . $this->autore . " (" . $this->isbn .")";
    }

    public function __toString() {
        return $this->getInfo();
    }

    public function getFilenamepdf() {
        return str_replace("/", "-", $this->getInfo().".pdf");
    }

    public function getFilenameepub() {
        return str_replace("/", "-", $this->getInfo().".epub");
    }

    public function getFilenamemobi() {
        return str_replace("/", "-", $this->getInfo().".mobi");
    }
}