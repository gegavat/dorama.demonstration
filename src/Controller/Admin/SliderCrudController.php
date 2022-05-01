<?php

namespace App\Controller\Admin;

use App\Entity\Slider;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SliderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slider::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Слайд')
            ->setEntityLabelInPlural('Слайды')
            ->setPageTitle(Crud::PAGE_INDEX, '%entity_label_plural%')
            ->setPageTitle(Crud::PAGE_NEW, 'Создание нового слайда')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('header', 'Заголовок слайда');
        yield TextField::new('text', 'Текст слайда');
        yield ColorField::new('bg_color', 'Цвет фона слайда')
            ->setHelp('Будет использован, если нет фонового изображения');
        yield TextareaField::new('imageFile', 'Фоновое изображение')
            ->onlyOnForms()
            ->setFormType(VichImageType::class);
    }

}
