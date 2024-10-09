<?php

    namespace App\Controller;

    use App\Entity\User;
    use App\Form\RegistrationFormType;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Component\Security\Http\Attribute\IsGranted;

    class RegistrationController extends AbstractController
    {
        #[IsGranted('ROLE_ADMIN')]
        #[Route('/admin/user/new', name: 'user_register')]
        public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
        {
            $user = new User();
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));

                $entityManager->persist($user);
                $entityManager->flush();

                // do anything else you need here, like send an email

                return $this->redirectToRoute('home');
            }

            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form,
            ]);
        }
    }
