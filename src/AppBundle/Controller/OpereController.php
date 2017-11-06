<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Opere;
use AppBundle\Entity\Costanti;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Filesystem\Filesystem;

class OpereController extends Controller
{
    /**
     * @Route("admin/opera/nuova", name="operanuova")
     */
    public function nuovaoperaAction(Request $request)
    {
        $opera = new Opere();
        
        $form = $this->createFormBuilder($opera)
            ->add('titolo', TextType::class, array('label' => 'Inserisci il titolo dell\'opera'))
            ->add('autore', TextType::class, array('label' => 'Inserisci il nome dell\'autore'))
            ->add('isbn', TextType::class, array('label' => 'Inserisci ISBN'))
            ->add('filepdf', FileType::class, array('label' => 'Carica il file PDF', 'attr' => array('class' => 'form-control-file'))) 
            ->add('save', SubmitType::class, array('label' => 'Crea nuova opera', 'attr' => array('class' => 'btn-primary btn-block')))
            ->getForm();
        
        $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {
            
            $opera = $form->getData();
            $codice = substr(sha1($opera->getInfo().Costanti::SALT),-10);
            $opera->setNomefile($codice);

            $filepdf = $opera->getFilepdf();
            $filenamepdf = $codice.'.'.$filepdf->guessExtension();
            $filepdf->move($this->getParameter('filepdf_directory'), $filenamepdf);            
            $opera->setFilepdf($filenamepdf);

            $em = $this->getDoctrine()->getManager();
            $em->persist($opera);
            $em->flush();

            return $this->redirect($this->generateUrl('operalista'));
        }

        return $this->render('AppBundle:Opere:nuovaopera.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("admin/opera/lista", name="operalista")
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

    /**
     * @Route("admin/opere/delete/{id}", name="operecancella")
     */
    public function deleteAction($id)
    {
        $opera = $this->getDoctrine()
            ->getRepository(Opere::class)
            ->findOneBy(
                array('id' => $id)
            );
    
        if (!$opera) {
            $this->addFlash(
                'notice',
                'Nessun opera con questo id: '.$id
            );
            return $this->redirectToRoute('operalista');
        }

        // CONTROLLARE CHE NON CI SIANO CODICI ATTIVI

        // Cancella anche il file
        $fs = new Filesystem();
        $filenamepdf = $this->getParameter('filepdf_directory').'/'.$opera->getFilepdf();
                
        $em = $this->getDoctrine()->getManager();
        $em->remove($opera);
        $em->flush();    

        try {
            $fs->remove($filenamepdf);
        } catch (IOExceptionInterface $e) {
            echo "Errore nella cancellazione del file: ".$filenamepdf."  ".$e->getPath();
        }
        
        return $this->redirectToRoute('operalista');

    }
}
