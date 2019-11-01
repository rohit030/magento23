<?php
namespace Rc\DeleteItems\Controller\Items;

use Magento\Framework\App\Action\Context;
use Magento\Checkout\Model\Cart as CustomerCart;

class Remove extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Magento\Checkout\Model\Cart
     */
    protected $cart;

    /**
     * @param Context $context
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param CustomerCart $cart
     */
    public function __construct(
        Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        CustomerCart $cart
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->cart = $cart;

        parent::__construct($context);
    }

    public function execute()
    {
        $itemId = $this->getRequest()->getPost('item_id');

        $this->cart->removeItem($itemId)->save();

        $allItems = $this->cart->getQuote()->getAllVisibleItems();

        $itemCount = count($allItems);

        $message = __(
            'You have deleted item from shopping cart.'
        );
        $this->messageManager->addSuccessMessage($message);

        $response = [
            'success' => true,
            'itemcount' => $itemCount,
        ];

        $this->getResponse()->representJson(
            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($response)
        );
    }
}