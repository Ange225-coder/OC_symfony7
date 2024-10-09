<?php

    namespace App\Controller\Admin;

    use App\Entity\Author;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use App\Forms\AuthorType;
    use Symfony\Component\Routing\Annotation\Route;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\Security\Http\Attribute\IsGranted;

    #[Route(path: '/admin/author')]
    class AuthorController extends AbstractController
    {
        //#[IsGranted('ROLE_ADMIN')]
        #[IsGranted('ROLE_AJOUT_DE_LIVRE')]
        #[Route(path: '/new', name: 'admin_author_new')]
        public function new(Request $request, EntityManagerInterface $entityManager): Response
        {

            //has same role with #[IsGranted('ROLE_ADMIN')
            //$this->denyAccessUnlessGranted('ROLE_ADMIN');

            $author = new Author();

            $formType = $this->createForm(AuthorType::class, $author);

            $formType->handleRequest($request);

            if($formType->isSubmitted() && $formType->isValid()) {
                $entityManager->persist($author);
                $entityManager->flush();

                return $this->redirectToRoute('admin_author_new');
            }

            return $this->render('admin/author/new.html.twig', [
                'form' => $formType,
            ]);
        }


        #[isGranted('IS_AUTHENTICATED')]
        #[Route(path: '/list', name: 'admin_author_list', methods: ['GET'])]
        public function list(EntityManagerInterface $entityManager): Response
        {
            $authors = $entityManager->getRepository(Author::class)->findAll();

            return $this->render('admin/author/list.html.twig', [
                'authors' => $authors,
            ]);
        }



        #[Route(path: '/{id}', name: 'admin_author_details', requirements: ['id' => '\d+'], methods: ['GET'])]
        public function details(int $id, EntityManagerInterface $entityManager): Response
        {
            $author = $entityManager->getRepository(Author::class)->find($id);

            if($author !== null) {
                $this->denyAccessUnlessGranted('ROLE_EDITION_DE_LIVRE');
            }

            return $this->render('admin/author/details.html.twig', [
                'author' => $author,
            ]);
        }
    }