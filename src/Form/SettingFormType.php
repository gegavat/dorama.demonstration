<?php

namespace App\Form;

use App\Entity\Setting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('siteName', null, ['label' => 'Имя сайта'])
            ->add('phone', null, ['label' => 'Номер телефона'])
            ->add('emails', null, ['label' => 'Email адреса для уведомлений (через запятую)'])
            ->add('instagram', null, ['label' => 'Инстаграм аккаунт'])
            ->add('vk', null, ['label' => 'Профиль Vk'])
            ->add('telegram', null, ['label' => 'Телеграм аккаунт'])
            ->add('Submit', SubmitType::class, ['label' => 'Применить'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Setting::class,
        ]);
    }
}
