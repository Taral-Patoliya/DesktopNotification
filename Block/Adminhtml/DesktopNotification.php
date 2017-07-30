<?php

namespace Taral\DesktopNotifications\Block\Adminhtml;

class DesktopNotification extends \Magento\Framework\View\Element\Template
{
	protected $_template = '';

	protected $_session;

	protected $_helper;

	protected $_storeManager;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Backend\Model\Auth\Session $authSession,
		\Taral\DesktopNotifications\Helper\Data $helper,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		array $data = []
		)
	{
		$this->_session = $authSession;
		$this->_helper = $helper;
		$this->_storeManager = $storeManager;

		if($this->_session->isLoggedIn() && $this->_helper->_isEnabled())
		{
			$this->_template = 'notification.phtml';
		}
		parent::__construct($context);

		/*echo $this->getUrl('customer/online/index');die;*/
	}

	public function getWidgetOptionsJson(array $customOptions = array())
	{
		$options =[
		'secret'  => $this->_helper->_getAppKey(),
		'channel' => $this->_helper->_getAppChannel(),
		'event'	  => $this->_helper->_getAppEvent(),
		'icon'	  => $this->getViewFileUrl('Magento_Theme/favicon.ico'),
		'log_enabled' => $this->_helper->_getIsDebug()
		];

		$options = array_replace_recursive($options, $customOptions);
		return json_encode($options);
	}
}