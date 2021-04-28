<?php

namespace App\Form;

use App\Entity\ClassRoom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ClassRoomType
 * @package App\Form
 */
class ClassRoomType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('class', TextType::class, [
                'required' => true,
                'label' => 'Class room'
            ])
            ->add('created', DateType::class, [
                'widget'=>'single_text',
                'required'=>true,
                'label' => 'Created'
            ])
            ->add('active', CheckboxType::class, [
                'label'    => 'Active',
                'required' => false,
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClassRoom::class,
        ]);
    }
}
