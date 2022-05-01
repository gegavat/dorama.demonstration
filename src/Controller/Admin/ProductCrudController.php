<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Блюдо')
            ->setEntityLabelInPlural('Блюда')
            ->setPageTitle(Crud::PAGE_INDEX, '%entity_label_plural%')
            ->setPageTitle(Crud::PAGE_NEW, 'Создание нового блюда')
            ->setSearchFields(['name', 'category.name'])
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        if ( $pageName !== Crud::PAGE_INDEX ) {
            return $this->getFields();
        } else {
            $allFields = $this->getFields();
            return [
                $allFields['name'],
                $allFields['category'],
                $allFields['isActive'],
                $allFields['is_popular'],
                $allFields['priceMain'],
                $allFields['configurators'],
            ];
        }
    }

    protected function getFields() : array
    {
        return [
            'name' => TextField::new('name', 'Название'),
            'category' => AssociationField::new('category', 'Категория блюда'),
            'isActive' => BooleanField::new('isActive', 'Включено'),
            'is_popular' => BooleanField::new('is_popular', 'Популярное блюдо'),
            'configurators' => AssociationField::new('configurators', 'Конфигураторы')->setFormTypeOptions([
                'by_reference' => false,
            ]),
            'description' => TextareaField::new('description', 'Описание'),
            'priceMain' => MoneyField::new('priceMain', 'Цена')->setCurrency('RUR'),
            'priceCross' => MoneyField::new('priceCross', 'Цена перечеркнутая')->setCurrency('RUR'),
            'rating' => ChoiceField::new('rating', 'Рейтинг (количество звезд)')->setChoices([
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5
            ]),
            'weight' => IntegerField::new('weight', 'Вес, гр.'),
            'imageFile' => TextareaField::new('imageFile', 'Изображение')
                ->onlyOnForms()
                ->setFormType(VichImageType::class)
                ->setHelp("Размер изображения должен быть: " . $_ENV['PRODUCT_IMAGE_WIDTH'] . 'x' . $_ENV['PRODUCT_IMAGE_HEIGHT'] . "px"),
        ];
    }
}
