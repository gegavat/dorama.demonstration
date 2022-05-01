<?php

namespace App\Form;

use App\Entity\Buyer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BuyerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => false, 'attr' =>
                ['placeholder' => 'Имя']
            ])
            ->add('phone', TelType::class, ['label' => false, 'attr' =>
                ['placeholder' => 'Телефон*']
            ])
            ->add('address', TextType::class, ['label' => false, 'attr' =>
                ['placeholder' => 'Адрес доставки*']
            ])
            ->add('personCount', IntegerType::class, [
                'label' => false,
                'empty_data' => '1',
                'attr' => [
                    'placeholder' => 'Количество приборов, 1 шт.',
                    'min' => 1,
                ]
            ])
            ->add('deliveryType', ChoiceType::class, [
                'label' => false,
                'choices'  => [
                    'Способ доставки' => null,
                    'Доставка' => Buyer::DELIVERY_TYPE_SHIPMENT,
                    'Самовывоз' => Buyer::DELIVERY_TYPE_PICKUP
                ]
            ])
            ->add('payType', ChoiceType::class, [
                'label' => false,
                'choices'  => [
                    'Оплата при получении' => Buyer::PAY_TYPE_RECEIPT
                ]
            ])
            ->add('callMe', CheckboxType::class, [
                'label' => false,
                'value' => 1,
                'attr' => [
                    'checked' => true
                ],
            ])
            ->add('comment', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Комментарий'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Buyer::class,
        ]);
    }
}
