<?php

    namespace App\Controller\Admin;

    use App\Entity\Book;
    use App\Forms\BookType;
    use Doctrine\ORM\EntityManagerInterface;
    use Pagerfanta\Doctrine\ORM\QueryAdapter;
    use Pagerfanta\Pagerfanta;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Security\Http\Attribute\IsGranted;

    //#[IsGranted('ROLE_ADMIN')]
    #[Route(path: '/admin/book')]
    class BookController extends AbstractController
    {
        #[Route(path: '/new', name: 'admin_book_new', methods: ['GET', 'POST'])]
        #[IsGranted('ROLE_AJOUT_DE_LIVRE')]
        public  function addBook (Request $request, EntityManagerInterface $entityManager): Response
        {
            $book = new Book();
            $addBookForm = $this->createForm(BookType::class, $book);

            $addBookForm->handleRequest($request);

            if($addBookForm->isSubmitted() && $addBookForm->isValid()) {
                $entityManager->persist($book);
                $entityManager->flush();

                return $this->redirectToRoute('admin_book_new');
            }

            return $this->render('admin/book/new.html.twig', [
                'bookForm' => $addBookForm,
            ]);
        }


        #[Route(path: '/list', name: 'admin_book_list', methods: ['GET'])]
        public function bookList(EntityManagerInterface $entityManager, Request $request): Response
        {
            //pagination here
            $bookList = Pagerfanta::createForCurrentPageWithMaxPerPage(
                new QueryAdapter($entityManager->getRepository(Book::class)->createQueryBuilder('b')),
                $request->query->get('page', 1),
                10
            );

            return $this->render('admin/book/list.html.twig', [
                'bookList' => $bookList,
            ]);
        }


        #[Route(path: '/{id}', name: 'admin_book_details', requirements: ['id' => '\d+'], methods: ['GET'])]
        public function bookDetails(int $id, EntityManagerInterface $entityManager): Response
        {
            $book = $entityManager->getRepository(Book::class)->find($id);

            if ($book !== null) {
                $this->denyAccessUnlessGranted('ROLE_EDITION_DE_LIVRE');
            }

            return $this->render('admin/book/details.html.twig', [
                'book' => $book,
            ]);
        }
    }