<?php

namespace App\Form;

use App\Entity\NumerosLoteria;
use App\Entity\Sorteo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SorteoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('prize')
            // ->add('winner')
            // ->add('fecha_inicio')
            ->add('fecha_fin')
            ->add('cost')
//             ->add('numerosLoteria', EntityType::class, [
//                 'class' => NumerosLoteria::class,
// 'choice_label' => 'id',
// 'multiple' => true,
//             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sorteo::class,
        ]);
    }
}
