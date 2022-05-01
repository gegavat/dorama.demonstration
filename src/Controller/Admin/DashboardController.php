<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Configurator;
use App\Entity\ConfiguratorItem;
use App\Entity\Product;
use App\Entity\Slider;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(CategoryCrudController::class)->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cafe Loc');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Вернуться на сайт', 'fa fa-home', 'main');
        yield MenuItem::linkToCrud('Категории блюд', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Блюда', 'fas fa-utensils', Product::class);
        yield MenuItem::subMenu('Конфигураторы', 'fas fa-tools')->setSubItems([
            MenuItem::linkToCrud('Группы', 'far fa-dot-circle', Configurator::class),
            MenuItem::linkToCrud('Ингредиенты', 'far fa-dot-circle', ConfiguratorItem::class)
        ]);
        yield MenuItem::linkToCrud('Слайдер', 'fas fa-exchange-alt', Slider::class);
        yield MenuItem::linktoRoute('Настройки', 'fa fas fa-cog', 'admin-setting')->setPermission('ROLE_ADMIN');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()->setSearchFields(null);
    }
}
