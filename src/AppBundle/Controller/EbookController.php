<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Codici;
use AppBundle\Entity\Opere;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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

            $cod = $this->getDoctrine()
            ->getRepository(Codici::class)
            ->findOneBy(
                array('codice' => $codice)
            );
    
            if (!$cod) {
                $this->addFlash(
                    'notice',
                    'Nessun opera con questo codice: '.$codice
                );

                return $this->redirectToRoute('homepage');
            }

            $opera = $this->getDoctrine()
                ->getRepository(Opere::class)
                ->find($cod->getOpere()->getId());

            return $this->render('AppBundle:Ebook:download.html.twig', array(
                'opera' => $opera,
                'codice' => $codice
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
        $cod = $this->getDoctrine()
            ->getRepository(Codici::class)
            ->findOneBy(
                array('codice' => $codice)
            );
    
        if (!$cod) {
            $this->addFlash(
                'notice',
                'Nessun opera con questo codice: '.$codice
            );

            return $this->redirectToRoute('homepage');
        }

        $opera = $this->getDoctrine()
            ->getRepository(Opere::class)
            ->find($cod->getOpere()->getId());
    
        return $this->render('AppBundle:Ebook:download.html.twig', array(
            'opera' => $opera,
            'codice' => $codice,
        ));
    }

    /**
     * @Route("/download/pdf/{codice}", name="downloadpdf")
     */
    public function downloadpdfAction($codice)
    {
        $cod = $this->getDoctrine()
            ->getRepository(Codici::class)
            ->findOneBy(
                array('codice' => $codice)
            );
    
        if (!$cod) {
            $this->addFlash(
                'notice',
                'Nessuna opera collegata con questo codice: '.$codice
            );

            return $this->redirectToRoute('homepage');
        }

        $opera = $this->getDoctrine()
            ->getRepository(Opere::class)
            ->find($cod->getOpere()->getId());

        $filenamepdf = $this->getParameter('filepdf_directory').'/'.$opera->getFilepdf();

        // check if file exists
        $fs = new FileSystem();
        if (!$fs->exists($filenamepdf)) {
            throw $this->createNotFoundException();
        }

        // prepare BinaryFileResponse
        $response = new BinaryFileResponse($filenamepdf);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $opera->getFilenamepdf(),
            iconv('UTF-8', 'ASCII//TRANSLIT', $opera->getFilenamepdf())
        );
        return $response;
    }

    /**
     * @Route("/download/epub/{codice}", name="downloadepub")
     */
    public function downloadepubAction($codice)
    {
        $cod = $this->getDoctrine()
            ->getRepository(Codici::class)
            ->findOneBy(
                array('codice' => $codice)
            );
    
        if (!$cod) {
            $this->addFlash(
                'notice',
                'Nessuna opera collegata con questo codice: '.$codice
            );

            return $this->redirectToRoute('homepage');
        }
      
        $opera = $this->getDoctrine()
            ->getRepository(Opere::class)
            ->find($cod->getOpere()->getId());

        $filenameepub = $this->getParameter('fileepub_directory').'/'.$opera->getFileepub();

        // check if file exists
        $fs = new FileSystem();
        if (!$fs->exists($filenameepub)) {
            throw $this->createNotFoundException();
        }

        // prepare BinaryFileResponse
        $response = new BinaryFileResponse($filenameepub);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $opera->getFilenameepub(),
            iconv('UTF-8', 'ASCII//TRANSLIT', $opera->getFilenameepub())
        );
        return $response;
    }

    /**
     * @Route("/download/mobi/{codice}", name="downloadmobi")
     */
    public function downloadmobiAction($codice)
    {
        $cod = $this->getDoctrine()
            ->getRepository(Codici::class)
            ->findOneBy(
                array('codice' => $codice)
            );
    
        if (!$cod) {
            $this->addFlash(
                'notice',
                'Nessuna opera collegata con questo codice: '.$codice
            );

            return $this->redirectToRoute('homepage');
        }
      
        $opera = $this->getDoctrine()
            ->getRepository(Opere::class)
            ->find($cod->getOpere()->getId());

        $filenamemobi = $this->getParameter('filemobi_directory').'/'.$opera->getFilemobi();

        // check if file exists
        $fs = new FileSystem();
        if (!$fs->exists($filenamemobi)) {
            throw $this->createNotFoundException();
        }

        // prepare BinaryFileResponse
        $response = new BinaryFileResponse($filenamemobi);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $opera->getFilenamemobi(),
            iconv('UTF-8', 'ASCII//TRANSLIT', $opera->getFilenamemobi())
        );
        return $response;
    }
}
