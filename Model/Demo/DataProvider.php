<?php

namespace KO\Demo\Model\Demo;

use KO\Demo\Model\ResourceModel\Demo\Collection;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Cms\Model\ResourceModel\Block\Collection
     */
    public $collection;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;
    public $storeManager;

    /**
     * @var array
     */
    private $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $blockCollectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $blockCollectionFactory;
        $this->storeManager = $storeManager;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $temp=[];
        $tempthread=[];
        $baseurl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Magento\Cms\Model\Block $block */
        foreach ($items as $block) {
            $this->loadedData[$block->getId()] = $block->getData();
            $temp = $block->getData();
        }

        $data = $this->dataPersistor->get('ko_demo');

        if (!empty($data)) {
            $block = $this->collection->getNewEmptyItem();
            $block->setData($data);

            $this->loadedData[$block->getId()] = $block->getData();

            $this->dataPersistor->clear('ko_demo');
        }

        if (empty($this->loadedData)) {
            return $this->loadedData;
        } else {
            $t2[$block->getId()] = $temp;
            return $t2;
        }
    }
}
