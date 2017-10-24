<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Ebook;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EbookController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $ebook = new Ebook();
        $ebook->setCodice('1234567890');
        
        $form = $this->createFormBuilder($ebook)
            ->add('codice', TextType::class, array('label' => 'Inserisci il codice del cartoncino'))
            ->add('save', SubmitType::class, array('label' => 'Crea ebook', 'attr' => array('class' => 'btn-primary btn-block')))
            ->getForm();

        return $this->render('AppBundle:Ebook:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
