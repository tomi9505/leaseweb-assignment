<?php

namespace App\Form;

use App\Entity\ServerList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ServerListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fileName', FileType::class, [
                'label' => 'Server List (Excel file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                'required' => true,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/vnd.ms-excel',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid MS Excel sheet',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServerList::class,
        ]);
    }
}
