<?php


namespace App\Form;
use App\Entity\Comment;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType as SymfonyTextType;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $optopns){

        $builder
            ->add('name', SymfonyTextType::class, [
                'help'=>'Choose something catche!',
            ])
            ->add('comment')
            ->add('commentedAt', null, [
                'widget'=>'single_text'
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults([

            'data_class'=>Comment::class
        ]);
    }

}