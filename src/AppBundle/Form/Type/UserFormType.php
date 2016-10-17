<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Collection;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('language', 'choice', array(
                'choices' => array(
                    'de' => 'German',
                    'en' => 'English'
                ),
                'required'    => true,
                'attr' => ['class' => 'app-form__control']
            ))
            ->add('plainPassword','text',['label'=>'Password','required' => true, 'attr' => ['class' => 'app-form__control']])
            ->add('username','text',['label' => 'Username', 'required' => true, 'attr' => ['class' => 'app-form__control']])
            ->add('email','email',['label'=>'Email','required' => true, 'attr' => ['class' => 'app-form__control']])
            ->add('enabled', 'checkbox', ['label' => 'Enabled', 'required' => false, 'attr' => ['class' => '']])
            ->add('Save', 'submit', ['label' => 'Save', 'attr' => ['class' => 'btn btn-block btn-lg btn-primary']]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false
        ]);
    }

    public function getName()
    {
        return '';
    }
}