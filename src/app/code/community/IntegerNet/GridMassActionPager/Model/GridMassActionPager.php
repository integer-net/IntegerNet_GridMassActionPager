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
 * Class IntegerNet_GridMassActionPager_Model_GridMassActionPager
 */
class IntegerNet_GridMassActionPager_Model_GridMassActionPager
{


    /**
     * @return Varien_Object
     */
    public function getPager()
    {
        $pager = Mage::getSingleton('adminhtml/session')->getData('__integernet_gridmassactionpager_model_gridmassactionpager');

        if (!($pager instanceof Varien_Object)) {
            $pager = new Varien_Object();
            Mage::getSingleton('adminhtml/session')->setData('__integernet_gridmassactionpager_model_gridmassactionpager', $pager);
        }

        return $pager;
    }


    /**
     * @param array $ids
     * @param int $limit
     *
     * @return self
     */
    public function init(array $ids, $limit)
    {
        $this->getPager()->setData(array(
            'current' => 0,
            'limit' => $limit,
            'total' => count($ids),
            'pages' => array_chunk($ids, $limit),
        ));

        return $this;
    }


    /**
     * @return array|null
     */
    public function getPageIds()
    {
        if ($this->getPager()->hasData('final')) {
            return null;
        }

        $key = sprintf('pages/%s', $this->getPager()->getData('current'));
        return $this->getPager()->getData($key);
    }


    /**
     * @param bool $asAjax
     * @param null|string $message
     *
     * @return string|array
     */
    public function getStatus($asAjax = true, $message = null)
    {
        $message = $message ? $message : Mage::helper('integernet_gridmassactionpager')->__('Process item from {{from}} to {{to}} of {{of}}');

        $search = array(
            '{{from}}',
            '{{to}}',
            '{{of}}',
        );

        if (!$this->getPageIds()) {

            $replace = array(0, 0, 0);

        } else {

            $replace = array(
                $this->getPager()->getData('current') * $this->getPager()->getData('limit') + 1,
                $this->getPager()->getData('current') * $this->getPager()->getData('limit') + count($this->getPageIds()),
                $this->getPager()->getData('total'),
            );
        }

        $message = str_replace($search, $replace, $message);

        $status = array(
            'final' => $this->getPageIds() ? false : true,
            'message' => $message,
        );

        if ($asAjax) {
            return Mage::helper('core')->jsonEncode($status);
        }

        return $status;
    }


    /**
     * @return self
     */
    public function next()
    {
        $current = $this->getPager()->getData('current');
        $pageCount = count($this->getPager()->getData('pages'));

        if ($current < ($pageCount - 1)) {

            $this->getPager()->setData('current', ++$current);

        } else {

            $this->getPager()->setData('final', true);
        }

        return $this;
    }
}
