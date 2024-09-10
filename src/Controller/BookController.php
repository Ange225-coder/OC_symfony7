<?php

    namespace App\Controller;

    use App\Entity\Book;
    use Doctrine\ORM\EntityManagerInterface;
    use Pagerfanta\Doctrine\ORM\QueryAdapter;
    use Pagerfanta\Pagerfanta;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    #[Route(path: '/book')]
    class BookController extends AbstractController
    {
        #[Route(path: '', name: 'book_list', methods: ['GET'])]
        public function bookList(EntityManagerInterface $entityManager, Request $request): Response
        {
            $bookList = Pagerfanta::createForCurrentPageWithMaxPerPage(
                new QueryAdapter($entityManager->getRepository(Book::class)->createQueryBuilder('b')),
                $request->query->get('page', 1),
                10
            );

            return $this->render('book/bookList.html.twig', [
                'bookList' => $bookList,
            ]);
        }



        #[Route(path: '/book/{id}', name: 'book_details', requirements: ['id' => '\d+'], methods: ['GET'])]
        public function bookDetails(int $id, EntityManagerInterface $entityManager): Response
        {
            $book = $entityManager->getRepository(Book::class)->find($id);

            return $this->render('book/bookDetails.html.twig', [
                'book' => $book,
            ]);
        }
    }