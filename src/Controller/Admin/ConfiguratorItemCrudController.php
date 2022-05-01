<?php

namespace App\Controller\Admin;

use App\Entity\ConfiguratorItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ConfiguratorItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ConfiguratorItem::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Ингредиент')
            ->setEntityLabelInPlural('Ингредиенты')
            ->setPageTitle(Crud::PAGE_INDEX, '%entity_label_plural%')
            ->setPageTitle(Crud::PAGE_NEW, 'Создание нового ингредиента')
            ->setSearchFields(['configurator.name'])
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Название');
        yield AssociationField::new('configurator', 'Группа ингредиента');
        yield MoneyField::new('price', 'Цена')->setCurrency('RUR');
    }
}
