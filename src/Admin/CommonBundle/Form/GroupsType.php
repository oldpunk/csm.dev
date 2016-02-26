<?php

namespace Admin\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('label'=>'Название'))
            ->add('content', 'text', array('label'=>'Описание'))
            ->add('is_blocked', 'checkbox', array('label'=>'Заблокирована', 'required'=> false))
            ->add('users', 'entity', array(
                'class'=>'AdminCommonBundle:Users',
                'multiple'=>true,
                'expanded'=>true,
                'property' => 'login'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
           'data_class' => 'Admin\CommonBundle\Entity\Groups'
        ));
    }

    public function getName()
    {
        return 'admin_common_bundle_groups_type';
    }
}
