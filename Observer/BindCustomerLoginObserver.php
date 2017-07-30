<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Taral\DesktopNotifications\Observer;

use Magento\Framework\Event\ObserverInterface;
use Taral\DesktopNotifications\Helper;

class BindCustomerLoginObserver implements ObserverInterface
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
        $name = $customer->getName();
        $email = $customer->getEmail();

        $data = [
            'url'=> $this->_helper->_getAdminUrl('customer/online/index'),
            'body' => "A Customer Named {$name} - {$email} has logged in recently",
            'title' => 'Customer Logged In'
        ];
        $this->_helper->pushNotification($data);
        //return $this;
    }
}
