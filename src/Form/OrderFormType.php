<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('buyer', BuyerFormType::class, [
                'label' => false,
                'allow_extra_fields' => true,
                'constraints' => [
                    new Assert\Type("App\Entity\Buyer"),
                    new Assert\Valid()
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить заказ',
                'attr' => ['class' => 'save save-order btn btn-success'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'required' => false,
        ]);
    }
}
