<?php

namespace Admin\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', 'text', array('label'=>'Логин'))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Введенные пароли не совпадают.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => false,
                'first_options'  => array('label' => 'Пароль'),
                'second_options' => array('label' => 'Проверка пароля'),
            ))
            ->add('avatar', 'image', array(
                    'label'=>'Аватар',
                    'required' => false,
                    'mapped' =>false
                )
            )
            ->add('fio', 'text', array('label'=>'ФИО'))
            ->add('email', 'email', array(
                'required' => false,
                'label' => 'E-mail'
            ))
            ->add('isBlocked', 'checkbox', array(
                'required' => false,
                'label' => 'Заблокировать пользователя'
            ))
            ->add('groups', 'entity', array(
                'class' => 'Admin\CommonBundle\Entity\Groups',
                'multiple' => true,
                'expanded' => true,
                'property' => 'title'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\CommonBundle\Entity\Users'
        ));
    }

    public function getName()
    {
        return 'admin_common_bundle_users_type';
    }
}
