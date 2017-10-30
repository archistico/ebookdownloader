<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Opere;
use AppBundle\Entity\Codici;
use AppBundle\Entity\Costanti;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CodiciController extends Controller
{
    /**
     * @Route("/codice/lista", name="codicelista")
     */
    public function codicelistaAction()
    {
        $codici = [];

        $repository = $this->getDoctrine()
                            ->getRepository('AppBundle:Codici');
        $codici = $repository->findAll();

        return $this->render('AppBundle:Codici:codicelista.html.twig', array(
            'codici' => $codici
        ));
    }

    /**
     * @Route("/codice/nuovo", name="codicenuovo")
     */
    public function codicenuovoAction(Request $request)
    {
        $codice = new Codici();
        
        $form = $this->createFormBuilder($codice)
            ->add('codice', TextType::class, array('label' => 'Inserisci il codice dell\'ebook'))
            ->add('save', SubmitType::class, array('label' => 'Crea nuova opera', 'attr' => array('class' => 'btn-primary btn-block')))
            ->getForm();
        
        $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {
            
            $codice = $form->getData();
            $codice->setCodice(substr(sha1('Emilie'.Costanti::SALT),-10));
            $codice->setDownload(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($codice);
            $em->flush();

            return $this->redirect($this->generateUrl('codicelista'));
        }

        return $this->render('AppBundle:Codici:codicenuovo.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

