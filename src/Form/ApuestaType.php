<?php

namespace App\Form;

use App\Entity\Apuesta;
use App\Entity\NumerosLoteria;
use App\Entity\Sorteo;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApuestaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroLoteria', EntityType::class, [
                'class' => NumerosLoteria::class,
'choice_label' => 'id',
            ])
            ->add('sorteo', EntityType::class, [
                'class' => Sorteo::class,
'choice_label' => 'id',
            ])
            ->add('usuario', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apuesta::class,
        ]);
    }
}
