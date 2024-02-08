<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Context;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Form\Model\UserRegistrationFormModel;




class RegistrationController extends AbstractController
{

    public function __construct(private UserRepository $userRepository, private EntityManagerInterface $entityManager)
    {
    }
    #[Route('/register', name: 'app_register', )]
    public function register(MailerInterface $mailer, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager) : Response
    {
        $user = new UserRegistrationFormModel();


        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var UserRegistrationFormModel $userModel   
             */
            $userModel = $form->getData();

            $user = new User();
            $user->setFirstName('Mystery');
            $user->setSubscribeToNewsletter(false);
            $user->setEmail($userModel->email);

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $userModel->plainPassword //$form->get('plainPassword')->getData()
                )
            );
            // $form['agreeTerms']->getData()
            if (true === $userModel->agreeTerms) {
                $user->agreeTerms();
            }

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $email = (new TemplatedEmail())
                ->from(new Address('alienmailer@example.com', 'The Space Bar'))
                ->to(new Address($user->getEmail(), $user->getFirstName()))
                ->subject('Welcome to the Space Bar')
                ->htmlTemplate('email/welcome.html.twig')
                ->context([
                    // 'user'=>$user
                ]);
            // ->text("Nice to meet you " . $user->getFirstName() . "!")
            // ->html("<h1>Nice to meet you {$user->getFirstName()} ! </h1>" );

            $mailer->send($email);

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/update', name: 'app_update')]
    public function update(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager) : Response
    {
        $users = $this->userRepository->findAll();
        foreach ($users as $user) {
            $user->setFirstName('UserTest');
            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();
        dd($users);
    }


}
