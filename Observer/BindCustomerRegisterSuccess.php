<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Taral\DesktopNotifications\Observer;

use Magento\Framework\Event\ObserverInterface;
use Taral\DesktopNotifications\Helper;

class BindCustomerRegisterSuccess implements ObserverInterface
{
	protected $_helper;

    protected $_storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Taral\DesktopNotifications\Helper\Data $helper
        )
    {
        $this->_helper = $helper;
        $this->_storeManager = $storeManager;
    }
    
    /**
     * Customer login bind process
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {   
        $customer = $observer->getCustomer();
        $name = $customer->getFirstname().' '.$customer->getLastname();
        $email = $customer->getEmail();

        $data = [
            'url'=> $this->_helper->_getAdminUrl('customer/online/index'),
            'body' => "A New Customer Named {$name} - {$email} has registered with us",
            'title' => 'Customer Registered'
        ];
        $this->_helper->pushNotification($data);
    }
}