<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 20/09/2018
 * Time: 14:27
 */

namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->add('adresse');
        $builder->add('prenom', null, array('attr' => array('class' => 'inputText')));
        $builder->add('phoneNumber', null, array('attr' => array('class' => 'inputText')));



    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

}