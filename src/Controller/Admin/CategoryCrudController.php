<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Создать категорию');
            });
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Категория')
            ->setEntityLabelInPlural('Категории')
            ->setPageTitle(Crud::PAGE_INDEX, '%entity_label_plural%')
            ->setPageTitle(Crud::PAGE_NEW, 'Создание новой категории')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Название категории');
        yield TextField::new('icon', 'Код иконки');
        yield ChoiceField::new('status', 'Статус категории')->setChoices([
            'Основная' => Category::STATUS_MAIN,
            'Дополнительная (скрытая)' => Category::STATUS_ADDITIONAL,
        ]);
    }

}
