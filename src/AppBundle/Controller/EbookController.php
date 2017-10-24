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
    public function indexAction(Request $request)
    {
        $ebook = new Ebook();
        //$ebook->setCodice('1234567890');
        
        $form = $this->createFormBuilder($ebook)
            ->add('codice', TextType::class, array('label' => 'Inserisci il codice del cartoncino'))
            ->add('save', SubmitType::class, array('label' => 'Crea ebook', 'attr' => array('class' => 'btn-primary btn-block')))
            ->getForm();
        
        $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {
            
            $ebook = $form->getData();
            $ebook->setEpub('file.epub');

            $em = $this->getDoctrine()->getManager();
            $em->persist($ebook);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage'));
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
            ->getRepository(Ebook::class)
            ->findOneBy(
                array('codice' => $codice)
            );
    
        if (!$ebook) {
            throw $this->createNotFoundException(
                'Nessun ebook ha questo codice '.$codice
            );
        }
    
        return $this->render('AppBundle:Ebook:download.html.twig', array(
            'ebook' => $ebook,
        ));
    }

}
