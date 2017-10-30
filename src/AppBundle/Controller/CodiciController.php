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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

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
            ->add('opere', EntityType::class, array('label' => 'Scegli l\'opera', 
                            'class' => 'AppBundle:Opere',
                            'choice_label' => 'getInfo', 
                            ))
            ->add('save', SubmitType::class, array('label' => 'Crea nuovo codice', 'attr' => array('class' => 'btn-primary btn-block')))
            ->getForm();
        
        $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {
            
            
            
            // Conta il numero di codici per un opera e aggiungi alle info
            // ...
            
            $codice = $form->getData();
            
            $opera = $this->getDoctrine()
                    ->getRepository(Opere::class)
                    ->find($codice->getOpere()->getId());
            
            $codice->setOpere($opera);

            $codice->setCodice(substr(sha1($opera->getInfo().Costanti::SALT),-10));
            $codice->setDownload(Costanti::MAXDOWNLOAD);
            
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

