<?php

namespace Kassner\FinancesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\SubmitButtonTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ControlType extends AbstractType implements SubmitButtonTypeInterface
{

    public function getName()
    {
        return 'control';
    }

    public function getParent()
    {
        return 'submit';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'auto_initialize' => false,
            'label' => 'Save',
            'back_url' => false,
            'back_label' => 'Back',
            'delete_url' => false,
            'delete_label' => 'Delete',
            'delete_message' => 'Are you sure?',
            'delete_role' => null
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'back_url' => $options['back_url'],
            'back_label' => $options['back_label'],
            'delete_message' => $options['delete_message'],
            'delete_label' => $options['delete_label'],
            'delete_url' => $options['delete_url'],
        ));
    }

}
