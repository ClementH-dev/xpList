<?php

namespace App\Form;

use App\Entity\ChecklistItemTemplate;
use App\Entity\ChecklistTemplate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChecklistItemTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'label' => 'Intitulé',
                'attr' => ['placeholder' => 'Saisissez un intitulé']
            ])
            ->add('isRequired', CheckboxType::class, [
                'label' => 'Obligatoire',
                'required' => false
            ])
            ->add('position', HiddenType::class, [
                'attr' => ['class' => 'item-position']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChecklistItemTemplate::class,
        ]);
    }
}
