<?php

namespace AppBundle\Form;

use AppBundle\Repository\TicketTypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {  
		$locale = strtoupper($options['current_locale']);
		
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class) 
            ->add('birthday', DateType::class, array(
				'widget' => 'single_text',
				'label'  => 'Subject',
				'attr'   =>  array(
					'class'   => 'datepicker')
				)
			)
            ->add('country', CountryType::class, [ 
                'preferred_choices' => [
                    $locale
                ]
            ])
            ->add('reduction', CheckboxType::class, array(
                'label' => 'Tarif réduit ',
                'required'  =>  false
			)) 
        ;
    }
 
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Ticket',
			'current_locale' => null,
        ]);
    }
}