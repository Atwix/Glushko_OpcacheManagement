<?php
/**
 * @author Roman Glushko
 * @copyright Copyright (c) 2017 Roman Glushko (http://www.linkedin.com/in/glushko-roman/)
 * @package Glushko_OpcacheManagement
 */

namespace Glushko\OpcacheManagement\Block\Adminhtml\Management\Index\Tab\CachedScripts;

use Glushko\OpcacheManagement\Service\Opcache\Information\CachedScripts\CachedScriptsCollection;
use Glushko\OpcacheManagement\Service\Opcache\Information\CachedScripts\CachedScriptsCollectionFactory;
use Magento\Backend\Block\Template\Context as BackendBlockContext;
use Magento\Backend\Block\Widget\Grid\Extended as ExtendedGridWidget;
use Magento\Backend\Helper\Data as BackendDataHelper;

/**
 * Class CachedScriptsGrid
 */
class CachedScriptsGrid extends ExtendedGridWidget
{
    /**
     * @var CachedScriptsCollectionFactory
     */
    protected $cachedScriptsCollectionFactory;

    /**
     * @param BackendBlockContext $context
     * @param BackendDataHelper $backendHelper
     * @param CachedScriptsCollectionFactory $cachedScriptsCollectionFactory
     * @param array $data
     */
    public function __construct(
        BackendBlockContext $context,
        BackendDataHelper $backendHelper,
        CachedScriptsCollectionFactory $cachedScriptsCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $backendHelper, $data);

        $this->cachedScriptsCollectionFactory = $cachedScriptsCollectionFactory;
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('cachedScriptsGrid');
        $this->setDefaultSort('script_path');
        $this->setDefaultDir('desc');
        $this->setUseAjax(true);
        $this->setEmptyText(__('No scrips have been cached yet.'));
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/getCachedScripts', ['_current' => true]);
    }

    /**
     * @inheritdoc
     */
    protected function _prepareCollection()
    {
        /** @var CachedScriptsCollection $cachedScriptsCollection */
        $cachedScriptsCollection = $this->cachedScriptsCollectionFactory->create();

        $this->setCollection($cachedScriptsCollection);

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'script_path',
            [
                'header' => __('Script Path'),
                'align' => 'left',
                'index' => 'script_path',
            ]
        );

        $this->addColumn(
            'information',
            [
                'header' => __('Information'),
                'align' => 'center',
                'index' => 'information',
                'sortable' => false,
                'filter' => false,
            ]
        );

        $this->addColumn(
            'action',
            [
                'header' => __('Action'),
                'align' => 'center',
                'filter' => false,
                'sortable' => false,
                'renderer' => 'Glushko\OpcacheManagement\Block\Adminhtml\Management\Index\Tab\CachedScripts\Grid\CachedScriptsActionRenderer'
            ]
        );

        return parent::_prepareColumns();
    }
}