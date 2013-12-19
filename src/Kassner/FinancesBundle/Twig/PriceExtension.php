<?php

namespace Kassner\FinancesBundle\Twig;

class PriceExtension extends \Twig_Extension
{

    public function getName()
    {
        return 'price';
    }

    public function getFilters()
    {
        return array(
            'price' => new \Twig_Filter_Method($this, 'priceFormat', array('is_safe' => array('html')))
        );
    }

    public function priceFormat($number)
    {
        $number = round($number, 2);
        $html = '<span class="amount">';
        $html .= 'R$ ';
        $html .= number_format($number, 2, ',', '.');
        $html .= '</span>';

        return $html;
    }

}
