<?php

    namespace App\Controller\Admin;

    use App\Entity\Editor;
    use App\Forms\EditorType;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Http\Attribute\IsGranted;

    class EditorController extends AbstractController
    {
        #[Route(path: '/admin/editor/new', name: 'admin_editor_new', methods: ['GET', 'POST'])]
        #[IsGranted('ROLE_AJOUT_DE_LIVRE')]
        public function addEditor(Request $request, EntityManagerInterface $entityManager): Response
        {
            $editor = new Editor();
            $addEditorForm = $this->createForm(EditorType::class, $editor);

            $addEditorForm->handleRequest($request);

            if($addEditorForm->isSubmitted() && $addEditorForm->isValid()) {
                $entityManager->persist($editor);
                $entityManager->flush();

                return $this->redirectToRoute('admin_editor_new');
            }

            return $this->render('admin/editor/new.html.twig', [
                'editorForm' => $addEditorForm,
            ]);
        }
    }