<?php
use Fiserv\models\FiservObject;

class PostCheckoutsResponse extends FiservObject
{
    public CheckoutModel $checkout;
}

class CheckoutModel extends FiservObject
{
    public string $storeId;
    public string $checkoutId;
    public string $redirectionUrl;
}

class GetCheckoutIdResponse extends FiservObject
{
    public string $field;
}

class PostCheckoutsRequest extends FiservObject
{
    public string $field;
}


// "checkout": {
//     "storeId": "72305408",
//     "checkoutId": "IUBsFE",
//     "redirectionUrl": "https://checkout-lane.com/?checkoutId=IUBsFE"
//   }