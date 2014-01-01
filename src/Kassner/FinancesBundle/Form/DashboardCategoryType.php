<?php

namespace Kassner\FinancesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DashboardCategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', array(
                'choices' => array(
                    'expense' => 'Expense',
                    'income' => 'Income',
                ),
                'multiple' => false,
                'required' => true,
            ))
            ->add('period', 'choice', array(
                'choices' => array(
                    'this_month' => 'This month',
                    'last_month' => 'Last month',
                    'this_year' => 'This year',
                    'last_year' => 'Last year',
                ),
                'multiple' => false,
                'required' => true,
            ))
        ;
    }

    public function getName()
    {
        return 'kassner_financesbundle_dashboard_category';
    }

}
