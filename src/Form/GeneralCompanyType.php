<?php

namespace App\Form;

use App\Entity\GeneralCompany;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class GeneralCompanyType extends AbstractType
{
    /**
     * @param $label
     * @param $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration('Nom', 'Nom de l\'entreprise générale'))
            ->add('address', TextType::class, $this->getConfiguration('Adresse', 'Entrez l\'adresse'))
            ->add('postalCode', TextType::class, $this->getConfiguration('Code Postal', 'Entrez le code postal'))
            ->add('city', TextType::class, $this->getConfiguration('Ville', 'Entrez la ville'))
            ->add('phone', TextType::class, $this->getConfiguration('Téléphone', 'Entrez le numero'))
            ->add('email', EmailType::class, $this->getConfiguration('Email', 'Entrez l\'adresse email'))
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GeneralCompany::class,
        ]);
    }
}