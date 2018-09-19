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
            ->setMethod('POST')
            ->add('intitle',\Symfony\Component\Form\Extension\Core\Type\TextType::class,array(
                'required' => false,
                'label' => 'Titre'
            ))
            ->add('inauthor', \Symfony\Component\Form\Extension\Core\Type\TextType::class,array(
                'required' => false,
                'label' => 'Auteur'
            ))
            ->add('inpublisher', \Symfony\Component\Form\Extension\Core\Type\TextType::class,array(
                'required' => false,
                'label' => 'Editeur'
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
