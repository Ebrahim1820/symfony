<?php


namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $optopns){

        $builder
            ->add('name')
            ->add('comment')
        ;

    }

}