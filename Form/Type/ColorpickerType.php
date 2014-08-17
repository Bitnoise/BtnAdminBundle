<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Btn\AdminBundle\Form\DataTransformer\ColorTransformer;
use Btn\AdminBundle\Validator\Constraints as BtnAssert;

class ColorpickerType extends AbstractType
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'constraints' => array(
                new BtnAssert\Color(),
            ),
            'attr' => array(
                'data-btn-colorpicker' => true,
                'class' => 'btn-colorpicker',
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
        return 'btn_colorpicker';
    }
}
