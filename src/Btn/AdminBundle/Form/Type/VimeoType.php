<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Btn\BaseBundle\Util\Vimeo;
use Btn\AdminBundle\Form\DataTransformer\VimeoTransformer;
use Btn\AdminBundle\Validator\Constraints as BtnAssets;

class VimeoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        if ('Btn\AdminBundle\ValueObject\Vimeo' === $options['data_class']) {
            $builder->addModelTransformer(new VimeoTransformer());
        }

        if ($options['convert_to_id']) {
            $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();

                $id = Vimeo::getVideoId($data);
                if (null !== $id) {
                    $event->setData($id);
                }
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['preview'] = $options['preview'] ? true : false;
        $view->vars['preview_url'] = 'https://player.vimeo.com/video/';
        $view->vars['preview_width'] = 320;
        $view->vars['preview_height'] = 180;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined(array(
            'convert_to_id',
            'preview',
        ));

        $resolver->setDefaults(array(
            'data_class'    => 'Btn\AdminBundle\ValueObject\Vimeo',
            'convert_to_id' => true,
            'preview'       => false,
            'empty_data'    => null,
            'constraints'   => array(
                new BtnAssets\Vimeo(),
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
        return 'btn_vimeo';
    }
}
