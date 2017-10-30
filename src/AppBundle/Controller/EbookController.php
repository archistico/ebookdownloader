<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Codici;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EbookController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $ebook = new Codici();
        
        $form = $this->createFormBuilder($ebook)
            ->add('codice', TextType::class, array('label' => 'Inserisci il codice del cartoncino'))
            ->add('find', SubmitType::class, array('label' => 'Cerca ebook', 'attr' => array('class' => 'btn-primary btn-block')))
            ->getForm();
        
        $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {
            
            $codice = $form->getData()->getCodice();

            $ebook = $this->getDoctrine()
                ->getRepository(Codici::class)
                ->findOneBy(
                    array('codice' => $codice)
                );
    
            if (!$ebook) {
                $this->addFlash(
                    'notice',
                    'Nessun ebook con questo codice: '.$codice
                );

                return $this->redirectToRoute('homepage');                
            }
    
            return $this->render('AppBundle:Ebook:download.html.twig', array(
                'ebook' => $ebook,
            ));
        }

        return $this->render('AppBundle:Ebook:index.html.twig', array(
            'form' => $form->createView(),
        ));        
    }


    /**
     * @Route("/download/{codice}", name="download")
     */
    public function downloadAction($codice)
    {
        $ebook = $this->getDoctrine()
            ->getRepository(Codici::class)
            ->findOneBy(
                array('codice' => $codice)
            );
    
        if (!$ebook) {
            $this->addFlash(
                'notice',
                'Nessun ebook con questo codice: '.$codice
            );

            return $this->redirectToRoute('homepage');
        }
    
        return $this->render('AppBundle:Ebook:download.html.twig', array(
            'ebook' => $ebook,
        ));
    }

}
