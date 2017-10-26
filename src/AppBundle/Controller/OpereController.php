<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Opere;
use AppBundle\Entity\Costanti;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OpereController extends Controller
{
    /**
     * @Route("/nuovaopera", name="nuovaopera")
     */
    public function nuovaoperaAction(Request $request)
    {
        $opera = new Opere();
        
        $form = $this->createFormBuilder($opera)
            ->add('titolo', TextType::class, array('label' => 'Inserisci il titolo dell\'opera'))
            ->add('autore', TextType::class, array('label' => 'Inserisci il nome dell\'autore'))
            ->add('isbn', TextType::class, array('label' => 'Inserisci ISBN'))
            ->add('save', SubmitType::class, array('label' => 'Crea nuova opera', 'attr' => array('class' => 'btn-primary btn-block')))
            ->getForm();
        
        $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {
            
            $opera = $form->getData();
            $codice = substr(sha1($opera->getInfo().Costanti::SALT),-10);
            $opera->setNomefile($codice);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($opera);
            $em->flush();

            return $this->redirect($this->generateUrl('listaopere'));
        }

        return $this->render('AppBundle:Opere:nuovaopera.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/listaopere", name="listaopere")
     */
    public function listaopereAction()
    {
        $opere = [];

        $repository = $this->getDoctrine()
                            ->getRepository('AppBundle:Opere');
        $opere = $repository->findAll();

        return $this->render('AppBundle:Opere:listaopere.html.twig', array(
            'opere' => $opere
        ));
    }

}
