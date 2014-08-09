<?php

namespace Btn\AdminBundle\Factory;

use Symfony\Bundle\AsseticBundle\Factory\AssetFactory as BaseAssetFactory;

class AssetFactory extends BaseAssetFactory
{
    /** @var array $voidInputFiles */
    protected $voidInputFiles = array();

    /**
     *
     */
    public function setVoidInputFiles(array $voidInputFiles)
    {
        $this->voidInputFiles = $voidInputFiles;
    }

    /**
     * {@inheritDoc}
     */
    public function createAsset($inputs = array(), $filters = array(), array $options = array())
    {
        // filter input files
        $filteredInputs = array();
        foreach ($inputs as $key => $file) {
            if (!in_array($file, $this->voidInputFiles)) {
                $filteredInputs[] = $file;
            }
        }

        // if (count($filteredInputs) !== count($inputs) && empty($options['combine'])) {
        //     throw new \Exception('combine option is required to void assetic input files');
        // }
        return parent::createAsset($filteredInputs, $filters, $options);
    }
}
