<?php

namespace AppBundle\Entity;

class Ebook
{
    protected $codice;
    protected $epub;

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