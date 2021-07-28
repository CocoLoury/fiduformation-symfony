<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Entity\Contact;
use App\Entity\Film;
use App\Entity\Realisateur;
use App\Entity\TableEx;
use App\Entity\Tag;
use App\Form\ContactAvatarType;
use App\Form\ContacType;
use App\Form\TableType;
use App\Repository\ContactRepository;
use App\Repository\FilmRepository;
use App\Repository\TableExRepository;
use App\Repository\TagRepository;
use App\Service\UploadFileService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param FilmRepository $filmRepository
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $em, FilmRepository $filmRepository): Response
    {
//        $form = $this->createForm(TableType::class);

//        $form = $this->createFormBuilder()
//            ->add('titre', TextType::class, [
//                'label' => 'Titre de film',
//                'attr' => [
//                    'placeholder' => 'Veuillez mettre le nom du film'
//                ],
//                'required' => false
//            ])
//            ->add('description', TextareaType::class)
//            ->add('telephone', TelType::class)
//            ->add('email', EmailType::class)
//            ->add('liste', ChoiceType::class, [
//                'choices' => [
//                    'aaa' => 'aa',
//                    'bbb' => 'bb',
//                    'aaaa' => 'aaa',
//                    'bbbb' => 'bbb'
//                ],
//                'expanded' => false,
//                'multiple' => true
//            ])
//            ->add('enregistrer', SubmitType::class)
//            ->getForm();

//        $form->handleRequest($request);
//        if($form->isSubmitted() && $form->isValid()) {
//            $table = $form->getData();
//            $em->persist($table);
//
//            try {
//                $em->flush();
//            } catch (UniqueConstraintViolationException $e) {
//                $this->addFlash('error', sprintf('Le titre %s existe déjà.', $table->getTitre()));
//                return $this->redirectToRoute('app_index');
//            }
//        }
//
//        return $this->render('front/front.html.twig', [
//            'form' => $form->createView()
//        ]);


//        $acteur1 = new Acteur();
//        $acteur1->setName('Omar Sy');
//        $acteur2 = new Acteur();
//        $acteur2->setName('Chris Pratt');
//        $acteur3 = new Acteur();
//        $acteur3->setName('Bryce Dallas Howard');
//
//        $realisateur = new Realisateur();
//        $realisateur->setName('Colin Trevorrow');
//
//        $film = new Film();
//        $film
//            ->setName('Jurrasic World')
//            ->addActeur($acteur1)
//            ->addActeur($acteur2)
//            ->addActeur($acteur3)
//            ->setRealisateur($realisateur);
//        $em->persist($film);
//        $em->flush();
//
//        $film = $filmRepository->findAll();
//        dd($film);

//        $tags = $repository->findAll();
//        return $this->render('front/front.html.twig', [
//            'tags' => $tags
//        ]);

//        /** @var  Tag $tag */
//        $tag = $repository->findOneById(1);
//        dd($tag);
//        $tableEx = new TableEx();
//        $tableEx->setTitre('table pour tags');
//
//        $tag->setTableEx($tableEx);
//        $em->persist($tag);
//        $em->flush();

//        $tags = ['tags1', 'pirate', 'superman', 'devops'];
//        foreach ($tags as $label) {
//            $tag = new Tag();
//            $tag->setLabel($label);
//            $em->persist($tag);
//        }
//
//        $em->flush();
//
//        $tagList = $repository->findAll();
//        dd($tagList);
//        $table = $repository->findOneById(1);
//        $em->remove($table);
//        $em->flush();
//
//        $table = $repository->findOneById(1);
//        dd($table);

//        $tableEx = new TableEx();
//        $tableEx
//            ->setTitre('titre')
//            ->setGrostext('text');
//
//        $em->persist($tableEx);
//        $em->flush();
//
//        dump($tableEx);die;

        return new Response('okok');

    }

    /**
     * @Route("/form", name="app_form")
     * @param Request $request
     * @return Response
     */
    public function form(Request $request)
    {
        $form = $this-> createFormBuilder()
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Veuillez mettre un nom'
                ],
                'required' => true
            ])
            ->add('objet', TextType::class)
            ->add('text', TextareaType::class)
            ->add('numTel', TelType::class, [
                'label' => 'Numéro de téléphone'
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Adresse email'
            ])
            ->add('selectService', ChoiceType::class, [
                'choices' => [
                    'Fiducial' => '1',
                    'Sofiral' => '2',
                    'Y-Proximité' => '3',
                    'Autres Sociétés' => '4'
                ],
                'multiple' => false
            ])
            ->add('cgu', CheckboxType::class, [
                'label' => 'Accepter les CGU pour continuer',
                'required' => true
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistré'
            ])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $response = $form->getData();
            dd($response);
        }

        return $this->render('form/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contact", name="app_contact")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param UploadFileService $uploadFileService
     * @return Response
     */
    public function contact(
        EntityManagerInterface $em,
        Request $request,
        UploadFileService $uploadFileService
    )
    {


        $contact = new Contact();
        $form = $this->createForm(ContactAvatarType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /** @var Contact $contact */
            $contact = $form->getData();

            $uploadedFile = $form->get('avatarFile')->getData();

            $fileUri = $uploadFileService->upload($uploadedFile, UploadFileService::AVATAR_DIR);

            $contact->setAvatar($fileUri);

            $em->persist($contact);
            $em->flush();

            $this->addFlash('notice', 'Contact sauvegardé');
        }
        return $this->render('form/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contacts", name="app_contacts")
     * @param ContactRepository $repository
     * @return Response
     */
    public function contacts(ContactRepository $repository)
    {
        $contacts = $repository->findAll();
        return $this->render('front/contacts.html.twig', [
            'contacts' => $contacts
        ]);
    }
}