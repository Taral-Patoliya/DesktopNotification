<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Taral\DesktopNotifications\Observer;

use Magento\Framework\Event\ObserverInterface;
use Taral\DesktopNotifications\Helper;

class BindCustomerOrderPlace implements ObserverInterface
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

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getOrder();
        $increment = $order->getIncrementId();
        $firstName = $order->getCustomerFirstname();
        $lastName = $order->getCustomerLastname();
        
    	$data = [
            'url'=> $this->_helper->_getAdminUrl('customer/online/index'),
            'body' => "A new order {$increment} has been placed by {$firstName} {$lastName}",
            'title' => "New Order {$increment}"
        ];
        $this->_helper->pushNotification($data);
    }

}