<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoogleMapType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $this->assetLoader->load(array('btn_admin_jquery_ui', 'btn_admin_addresspicker_js'));

        $builder
            ->add('address', $options['adress_field'] ? 'text' : 'hidden', array(
                'required' => true,
                'label'    => false,
            ))
            ->add('route', 'hidden', array(
                'required' => false,
            ))
            ->add('streetNumber', 'hidden', array(
                'required' => false,
            ))
            ->add('country', 'hidden', array(
                'required' => false,
            ))
            ->add('locality', 'hidden', array(
                'required' => false,
            ))
            ->add('sublocality', 'hidden', array(
                'required' => false,
            ))
            ->add('postalCode', 'hidden', array(
                'required' => false,
            ))
            ->add('lat', 'hidden', array(
                'required' => false,
            ))
            ->add('lng', 'hidden', array(
                'required' => false,
            ))
            ->add('zoom', 'hidden', array(
                'required' => false,
            ))
            ->add('maptypeid', 'hidden', array(
                'required' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined(array(
            'adress_field',
        ));

        $resolver->setDefaults(array(
            'adress_field' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_google_map';
    }
}
