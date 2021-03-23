<?php

namespace wndr\commerce\afterpay\transformers;

use craft\commerce\elements\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform(Order $order): array
    {
        $data = [
            'ordernumber' => $order->number,
            'currency' => $order->getPaymentCurrency(),
            'ipaddress' => \Craft::$app->getRequest()->remoteIP
        ];

        if($order->billingAddress) {
            $data['billtoaddress'] = (new AddressTransformer())->transform($order->billingAddress, $order);
        }

        if($order->shippingAddress) {
            $data['shiptoaddress'] = (new AddressTransformer())->transform($order->shippingAddress, $order);
        }

        return $data;
    }
}