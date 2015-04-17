<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Btn\AdminBundle\Validator\Constraints as BtnAssets;

class TranslationType extends AbstractType
{
    /** @var array */
    private $locales;

    /**
     * @param array $locales
     */
    public function setLocales(array $locales)
    {
        $this->locales = $locales;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        foreach ($this->locales as $locale) {
            if ($options['type'] === 'text') {
                $localeOptions = ['label' => false, 'addon_prepend' => 'locale.'.$locale];
            } else {
                $localeOptions = ['label' => 'locale.' . $locale, 'label_size' => 1];
            }
            $builder->add($locale, $options['type'], $localeOptions);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired('type');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_translation';
    }
}
