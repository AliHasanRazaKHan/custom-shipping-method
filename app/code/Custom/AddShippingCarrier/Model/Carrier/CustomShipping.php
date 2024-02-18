<?php

declare(strict_types=1);

namespace Custom\AddShippingCarrier\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;

class CustomShipping extends AbstractCarrier implements CarrierInterface
{
    protected $_code = 'customshipping';
    protected $_isFixed = true;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        private ResultFactory $rateResultFactory,
        private MethodFactory $rateMethodFactory,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }


    /**
     * Custom Shipping Rates Collector
     *
     * @param RateRequest $request
     * @return Result|bool
     */
    public function collectsRates(RateRequest $request): Result|bool
    {
        if(!$this->getConfigFlag('active'))
        {
            return false;
        }

        /**
         * @var Method $method
         */
        $method = $this->rateMethodFactory->create();

        $method->setCarrier($this->_code)
            ->setCarrierTitle($this->getConfigData('title'))
            ->setMethod($this->_code)
            ->setMethodTitle($this->getConfigData('name'));

        $shippingCost = (float) $this->getConfigData('shipping_cost');
        $method->setPrice($shippingCost)
            ->setCost($shippingCost);

        /**
         * @var Result $result
         */
        $result = $this->rateResultFactory->create();
        $result->append($method);

        return $result;

    }

    public function getAllowedMethods():array
    {
        return [$this->_code => $this->getConfigData('name')];
    }
}
