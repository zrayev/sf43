<?php

namespace App\Form;

use App\Entity\Department;
use App\Entity\Skill;
use App\Entity\Staff;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName')
            ->add('email')
            ->add('phone')
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.title', 'ASC');
                },
                'choice_label' => 'title',
                'required' => true,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('comments')
            ->add('departments', EntityType::class, [
                'class' => Department::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.title', 'ASC');
                },
                'choice_label' => 'title',
                'required' => true,
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Staff::class,
        ]);
    }
}
