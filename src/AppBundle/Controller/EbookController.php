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
        return $this->render('AppBundle:Ebook:index.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/nuovo", name="nuovo")
     */
    public function nuovoAction(Request $request)
    {
        $ebook = new Ebook();
        $ebook->setCodice('1234567890');
        
        $form = $this->createFormBuilder($ebook)
            ->add('codice', TextType::class)
            ->add('save', 'submit', array('label' => 'Crea ebook'))
            ->getForm();

        return $this->render('AppBundle:Ebook:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
