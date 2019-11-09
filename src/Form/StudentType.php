<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Student;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, [
                'required' => true,
                'help' => 'Enter you first name',
            ])
            ->add('lastName', null, [
                'required' => true,
                'help' => 'Enter you last name',
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $student = $event->getData();
                $form = $event->getForm();
                if (!$student || null === $student->getId()) {
                    $form->add('course', EntityType::class, [
                        'class' => Course::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('s')
                                ->orderBy('s.title', 'ASC');
                        },
                        'choice_label' => 'title',
                        'help' => 'The field can not be changed later.',
                        'required' => true,
                        'expanded' => true,
                        'multiple' => false,
                    ]);
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
