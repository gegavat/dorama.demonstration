<?php

namespace App\Controller\Admin;

use App\Entity\Configurator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class ConfiguratorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Configurator::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Создать группу');
            });
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Группа')
            ->setEntityLabelInPlural('Группы')
            ->setPageTitle(Crud::PAGE_INDEX, '%entity_label_plural%')
            ->setPageTitle(Crud::PAGE_NEW, 'Создание новой группы')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Имя группы');
        yield TextField::new('label', 'Отображаемая подпись');
        yield BooleanField::new('is_multiple', 'Множественный выбор')
            ->setHelp('Возможность выбора нескольких ингредиентов');
        yield BooleanField::new('is_required', 'Обязательность выбора')
            ->setHelp('Обязательный выбор ингредиентов');
        yield AssociationField::new('product', 'Блюда')->setFormTypeOptions([
            'by_reference' => false,
        ]);
    }
}
