<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Personne;
use App\Repository\EquipeRepository;
use Egulias\EmailValidator\Warning\AddressLiteral;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $editedObject = $builder->getData();
        $equipe = (new Equipe())->setNom("pas d'équipe");
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('equipeId', EntityType::class, [
                'empty_data' => null,
                'attr'=> ['class'=> 'form-check-input mt-0'],
                'class'=> Equipe::class,
                'multiple'=> true,
                'expanded' => true,
                'placeholder'=> "Pas d'équipe",
                'required'=> false,
                'query_builder' => function (EquipeRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
