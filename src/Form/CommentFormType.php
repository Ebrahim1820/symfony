<?php


namespace App\Form;
use App\Entity\Comment;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\TextType;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType as SymfonyTextType;

class CommentFormType extends AbstractType
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository){

        $this->userRepository = $userRepository;


    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {



        $builder
            ->add('name', SymfonyTextType::class, [
                'help' => 'Choose a name for your comment!',
            ])
            ->add('comment')
            ->add('commentedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('author', UserSelectTextType::class)
        ;
        
        // ('author', EntityType::class, [
        //     'class'        => User::class,
        //     'choice_label' => function (User $user) {
        //         return sprintf('(%d) %s', $user->getId(), $user->getEmail());
        //     },
         
        //     'placeholder'=>'Choose an author',
        //     'choices'=>$this->userRepository
        //     ->findAllEmailAlphabetical(),
        //  'invalid_message' => 'Symfony is too smart for your hacking'
        //  ])
    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults([

            

            'data_class'=>Comment::class
        ]);
    }

}