<?php

namespace Btn\AdminBundle\Form\Type;

use Btn\BaseBundle\Util\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * {@inheritdoc}
 */
class Select2AjaxType extends Select2Type
{

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined(array(
            'data_route_path',
            'cache',
            'min_input_length'
        ));

        /**
         * Route path should return ajax response:
         * [
         *  {
                id: 'id',
                text: 'text'
         * }
         * ]
         */
        $resolver->setAllowedTypes('data_route_path', array('string', 'null'));
        $resolver->setAllowedTypes('cache', array('bool'));
        $resolver->setAllowedTypes('min_input_length', array('integer'));

        $resolver->setDefaults([
            'data_route_path' => null,
            'cache' => true,
            'min_input_length' => 3
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $viewData = $form->getViewData();
        if(isset($viewData['id']) && isset($viewData['text'])){
            $view->vars['attr']['btn-select2-ajax-id'] = $viewData['id'];
            $view->vars['attr']['btn-select2-ajax-text'] = $viewData['text'];
            $view->vars['value'] = null;
        }
        $view->vars['attr']['btn-select2-is-ajax'] = 1;
        $view->vars['attr']['btn-select2-route-path'] = $this->router->getRouteCollection()->get($options['data_route_path'])->getPath();
        $view->vars['attr']['btn-select2-ajax-cache'] = $options['cache'];
        $view->vars['attr']['btn-select2-min-length'] = $options['min_input_length'];
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'ajax';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return Form::getFormName(array(
            'alias' => $this->getAlias(),
            'class' => TextType::class,
        ));
    }
}
