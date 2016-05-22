<?php

namespace GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'data' =>  "Photo " . date("Y-m-d h:i:s")
            ])
            ->add('file')
            ->add('sort', null, [
                'data' => 0
            ])
            ->add('description', null, [
                'data' =>  "empty description"
            ])
            ->add('categories')
            ->add('isMain')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GalleryBundle\Entity\Image'
        ));
    }
}
