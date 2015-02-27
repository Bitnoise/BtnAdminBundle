<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Btn\AdminBundle\Form\DataTransformer\ColorTransformer;
use Btn\AdminBundle\Validator\Constraints as BtnAssert;

class ColorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addModelTransformer(new ColorTransformer());

        $this->assetLoader->load('btn_admin_colorpicker');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'constraints' => array(
                new BtnAssert\Color(),
            ),
            'attr' => array(
                'btn-colorpicker' => true,
                'class'           => 'btn-colorpicker',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_color';
    }
}
