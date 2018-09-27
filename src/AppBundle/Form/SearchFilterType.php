<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('intitle',\Symfony\Component\Form\Extension\Core\Type\TextType::class,array(
                'attr' => array(
                    'placeholder' => 'Title',
                ),
                'required' => false,
                'label' => false
            ))
            ->add('inauthor', \Symfony\Component\Form\Extension\Core\Type\TextType::class,array(
                'attr' => array(
                    'placeholder' => 'Author',
                ),
                'required' => false,
                'label' => false
            ))
            ->add('inpublisher', \Symfony\Component\Form\Extension\Core\Type\TextType::class,array(
                'attr' => array(
                    'placeholder' => 'Publisher',
                ),
                'required' => false,
                'label' => false
            ))
            ->add('isbn', \Symfony\Component\Form\Extension\Core\Type\TextType::class,array(
                'attr' => array(
                    'placeholder' => 'ISBN',
                ),
                'required' => false,
                'label' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_search_filter_type';
    }
}
