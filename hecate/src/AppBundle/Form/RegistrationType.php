<?php


namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class RegistrationType extends AbstractType
{

public function buildForm(FormBuilderInterface $builder, array $options)
{
  $builder
    ->add('profile', null)
    ->add('atCount', null);


}


  public function getParent()
  {
      return 'FOS\UserBundle\Form\Type\RegistrationFormType';
  }

  public function getName()
  {
      return 'app_user_registration';
  }

}
