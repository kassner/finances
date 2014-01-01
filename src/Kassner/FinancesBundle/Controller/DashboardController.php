<?php

namespace Kassner\FinancesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kassner\FinancesBundle\Form\DashboardCategoryType;

/**
 * Dashboard controller.
 */
class DashboardController extends Controller
{

    /**
     * Dashboard
     *
     * @Route("/", name="home")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $data = $request->get('kassner_financesbundle_dashboard_category');
        $filterForm = $this->createForm(new DashboardCategoryType(), $data, array(
            'action' => $this->generateUrl('home'),
            'method' => 'GET',
        ));

        $period = (empty($data['period']) ? 'this_month' : $data['period']);
        $type = (empty($data['type']) ? 'expense' : $data['type']);
        $categories = $this->get('finances.service.category')->getTop10($period, $type);

        return array(
            'categories' => $categories,
            'filter' => $filterForm->createView()
        );
    }

}
