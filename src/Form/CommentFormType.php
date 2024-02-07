<?php


namespace App\Form;

use App\Entity\Comment;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\TextType;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType as SymfonyTextType;

class CommentFormType extends AbstractType
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;


    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Comment|null $comment */
        $comment = $options['data'] ?? null;
        $isEdit  = $comment && $comment->getId();
        // $location = $comment ? $comment->getLocation() : null;


        $builder
            ->add('name', SymfonyTextType::class, [
                'help' => 'Choose a name for your comment!',
            ])
            ->add('comment', TextareaType::class, [
                'attr' => [ 'rows' => 10 ]
            ])
            ->add('commentedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('author', UserSelectTextType::class)
            ->add('location', ChoiceType::class, [
                'placeholder' => 'Choose a location ',
                'choices'     => [
                    'The Solar System'   => 'solar_system',
                    'Near a star'        => 'star',
                    'Interstellar Space' => 'interstellar_space'
                ],
                'required'    => false,
            ]);

        // if($location){
        // $builder->add('specificLocationName', ChoiceType::class, [
        //     'placeholder' => 'Where exactly?',
        //     'choices'     => $this->getLocationNameChoices($location),
        //     'required'    => false,
        // ]);
        // }

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var Comment|null $data */
                $data = $event->getData();
                if (!$data) {
                    return;
                }

                $this->setupSpecificLocationNameField(
                    $event->getForm(),
                    $data->getLocation(),
                );
            }

        );

        $builder->get('location')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->setupSpecificLocationNameField(
                    $form->getParent(),
                    $form->getData(),
                );
            }
        );
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

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([

            'data_class' => Comment::class
        ]);
    }



    private function getLocationNameChoices(string $location) : array
    {
        $planets             = [
            'Mercury',
            'Venus',
            'Earth',
            'Mars',
            'Jupiter',
            'Saturn',
            'Uranus',
            'Neptune',
        ];
        $stars               = [
            'Polaris',
            'Sirius',
            'Alpha Centauari A',
            'Alpha Centauari B',
            'Betelgeuse',
            'Rigel',
            'Other'
        ];
        $locationNameChoices = [
            'solar_system'       => array_combine($planets, $planets),
            'star'               => array_combine($stars, $stars),
            'interstellar_space' => null,
        ];

        return $locationNameChoices[$location] ?? null;
    }

    public function setupSpecificLocationNameField(FormInterface $form, ?string $location)
    {
        if (null === $location) {
            $form->remove('specificLocationName');
            return;
        }

        $choices = $this->getLocationNameChoices($location);

        if (null === $choices) {

            $form->remove('specificLocationName');
            return;
        }

        $form->add('specificLocationName', ChoiceType::class, [
            'placeholder' => 'Where exactly?',
            'choices'     => $choices,
            'required'    => false,
        ]);

    }

}