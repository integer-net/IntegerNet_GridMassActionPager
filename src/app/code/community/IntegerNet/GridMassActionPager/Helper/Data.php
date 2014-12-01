<?php
/**
 * integer_net GmbH Magento Module
 *
 * @package    IntegerNet_GridMassActionPager
 * @copyright  Copyright (c) 2014 integer_net GmbH (http://www.integer-net.de/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     integer_net GmbH <info@integer-net.de>
 * @author     Viktor Franz <vf@integer-net.de>
 */


/**
 * Class IntegerNet_GridMassActionPager_Helper_Data
 */
class IntegerNet_GridMassActionPager_Helper_Data extends Mage_Core_Helper_Abstract
{


    /**
     *
     */
    public function addScript()
    {
        if ($head = Mage::app()->getLayout()->getBlock('head')) {
            $head->addJs('integernet_gridmassactionpager/gridmassactionpager.js');
        }
    }
}
