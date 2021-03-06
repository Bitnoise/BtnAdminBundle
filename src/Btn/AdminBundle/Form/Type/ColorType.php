<?php

namespace Btn\AdminBundle\Form\Type;

use Btn\BaseBundle\Util\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setOptional(array(
            'basic_colors',
            'show_spectrum',
        ));

        $resolver->setDefaults(array(
            'basic_colors'  => null,
            'show_spectrum' => null,
            'show_advanced' => null,
            'show_basic'    => null,
            'constraints'   => function(Options $options, $value) {
                $value[] = new BtnAssert\Color();

                return $value;
            },
            'attr' => array(
                'btn-colorpicker' => true,
                'class'           => 'btn-colorpicker',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        if (!empty($options['basic_colors'])) {
            if (is_array($options['basic_colors'])) {
                $view->vars['attr']['btn-colorpicker-basic-colors'] = json_encode($options['basic_colors']);
            } elseif (is_string($options['basic_colors'])) {
                $view->vars['attr']['btn-colorpicker-basic-colors'] = $options['basic_colors'];
            }
        }
        if (null !== $options['show_spectrum']) {
            $view->vars['attr']['btn-colorpicker-spectrum'] = $options['show_spectrum'] ? 'true' : 'false';
        }
        if (null !== $options['show_advanced']) {
            $view->vars['attr']['btn-colorpicker-advanced'] = $options['show_advanced'] ? 'true' : 'false';
        }
        if (null !== $options['show_basic']) {
            $view->vars['attr']['btn-colorpicker-basic'] = $options['show_basic'] ? 'true' : 'false';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return Form::getFormName(array(
            'alias' => 'text',
            'class' => TextType::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_color';
    }
}
