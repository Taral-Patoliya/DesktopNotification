<?php 


namespace Taral\DesktopNotifications\Helper;

/**
* 
*/
class Data extends \Magento\Framework\Url\Helper\Data
{

	const XML_PATH_ENABLE = 'denot/general/enabled';
	const XML_PATH_APPID = 'denot/app/app_id';
	const XML_PATH_APPKEY = 'denot/app/app_key';
	const XML_PATH_APPSECRET = 'denot/app/app_secret';
	const XML_PATH_APPCHANNEL = 'denot/app/app_channel';
	const XML_PATH_APPEVENT = 'denot/app/app_event';
	const XML_PATH_DEBUG	= 'denot/app/app_debug';
	const XML_PATH_STATUS = 'denot/general/enabled';

	protected $context;
	
	protected $storeManager;

	protected $scopeConfig;

	protected $pusher;

	protected $_objectManager;


	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\ObjectManagerInterface $objectManager
	)
	{
		$this->storeManager = $storeManager;
		$this->scopeConfig = $scopeConfig;
		$store = $this->storeManager->getStore()->getCode();
		$this->_objectManager = $objectManager;
		$this->pusher = $this->_objectManager->create('Pusher',array('auth_key'=>$this->_getAppKey($store),'secret'=>$this->_getAppSecret($store),'app_id'=>$this->_getAppId($store),'options'=>array('encrypted'=>true)));
		
		

		//$this->pusher = new Pusher($this->_getAppKey($store),$this->_getAppSecret($store),$this->_getAppId($store));
		parent::__construct($context);
	}

	public function _getAppId($store = 'default')
	{
		return $this->scopeConfig->getValue(self::XML_PATH_APPID,$store);
	}

	public function _getAppKey($store = 'default')
	{
		return $this->scopeConfig->getValue(self::XML_PATH_APPKEY,$store);
	}

	public function _getAppSecret($store = 'default')
	{
		return $this->scopeConfig->getValue(self::XML_PATH_APPSECRET,$store);
	}

	public function _getAppChannel($store='default')
	{
		return $this->scopeConfig->getValue(self::XML_PATH_APPCHANNEL,$store);	
	}

	public function _getAppEvent($store='default')
	{
		return $this->scopeConfig->getValue(self::XML_PATH_APPEVENT,$store);	
	}

	public function _getIsDebug($store= 'default')
	{
		return $this->scopeConfig->getValue(self::XML_PATH_DEBUG,$store);		
	}

	public function _isEnabled($store = 'default')
	{
		return $this->scopeConfig->getValue(self::XML_PATH_STATUS,$store);			
	}

	public function _getAdminUrl($path = '')
	{
		return $path;
	}

	public function pushNotification($data)
	{
		try{
			return $this->pusher->trigger($this->_getAppChannel(),$this->_getAppEvent(),$data);
		}catch(Exception $e)
		{
			return false;
		}

	}


}