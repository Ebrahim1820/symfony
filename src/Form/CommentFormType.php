<?php


namespace App\Form;
use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $optopns){

        $builder
            ->add('name')
            ->add('comment')
        ;

    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults([

            'data_class'=>Comment::class
        ]);
    }

}