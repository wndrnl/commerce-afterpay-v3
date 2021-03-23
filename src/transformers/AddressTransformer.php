<?php

namespace wndr\commerce\afterpay\transformers;

use craft\commerce\elements\Order;
use craft\commerce\models\Address;
use League\Fractal\TransformerAbstract;

class AddressTransformer extends TransformerAbstract
{
    public function transform(Address $address, Order $order)
    {
        return [
            'city' => $address->city,
            'housenumber' => $address->address3,
            'housenumberaddition' => '',
            'isocountrycode' => $address->countryIso,
            'postalcode' => $address->zipCode,
            'streetname' => $address->address1,
            'referenceperson' => [
                'dob' => '1995-11-02T00:00:00', // todo
                'email' => $order->email,
                'firstname' => $address->firstName,
                'gender' => 'M', // todo
                'isolanguage' => $address->countryIso,
                'lastname' => $address->lastName,
                'phone' => $address->phone,
            ]
        ];
    }
}