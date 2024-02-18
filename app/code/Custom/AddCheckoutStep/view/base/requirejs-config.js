var config = {
    'config': {
        'mixins': {
            'Magento_Checkout/js/view/shipping': {
                'Custom_AddCheckoutStep/js/view/shipping-payment-mixin': true
            },
            'Magento_Checkout/js/view/payment': {
                'Custom_AddCheckoutStep/js/view/shipping-payment-mixin': true
            }
        }
    }
}
