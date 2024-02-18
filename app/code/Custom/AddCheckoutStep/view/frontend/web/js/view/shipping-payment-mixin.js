//If your new step is the first step,
// you have to create mixins for the payment and shipping steps.
// Otherwise, two steps will be activated on the loading of the checkout.
define(
    [
        'ko'
    ], function (ko) {
        'use strict';

        var mixin = {
            initialize: function() {
                //set visible to be initially false to have your step show first
                this.visilbe = ko.observable(false);
                this._super();
                return this;
            }
        };

        return function(target) {
            return target.extend(mixin);
        };

    }
);
