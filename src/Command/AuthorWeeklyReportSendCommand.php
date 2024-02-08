<?php

namespace App\Command;

use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\NamedAddress;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

#[AsCommand(
    name: 'app:author-weekly-report:send',
    description: 'Add a short description for your command',
)]
class AuthorWeeklyReportSendCommand extends Command
{   
    protected static $defaultName= 'app:author-weekly-report:send';


    private UserRepository $userRepository;
    private CommentRepository $commentRepository;
    private MailerInterface $mailer;

    public function __construct(UserRepository $userRepository, CommentRepository $commentRepository, MailerInterface $mailer)
    {
        parent::__construct(null);
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
        $this->mailer = $mailer;

       
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Send weekly reports to authors ')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $io = new SymfonyStyle($input, $output);
        $authors =$this->userRepository
        ->findAllSubscribedToNewsletter();

        $io->progressStart(count($authors));
        foreach($authors as $author){
                $io->progressAdvance();
                $comments = $this->commentRepository->findAllPublishedLastWeekByAuthor($author);

                // Skip Authors who do not have published comments for the last week
                if(count($comments) === 0){
                    continue;
                }

                $email = (new TemplatedEmail())
                ->from(new NamedAddress('alienmailcarrier@example.com', 'The Space Bar'))
                ->to(new NamedAddress($author->getEmail(), $author->getFirstName()))
                ->subject('Your weekly report on the space bar')
                ->htmlTemplate('email/author-weekly-report.html.twig')
                ->context([
                    'author'=>$author,
                    'comments'=>$comments
                ]);

                $this->mailer->send($email);
        }
        $io->progressFinish();

        $io->success('Weekly reports were sent to authors');

        return Command::SUCCESS;
     
    }
}
