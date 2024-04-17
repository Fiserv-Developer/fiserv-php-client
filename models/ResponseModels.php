<?php
use Fiserv\models\FiservObject;

class GetCheckoutIdResponse extends FiservObject
{
    public string $storeId;
    public string $checkoutId;
    public string $orderId;
    public string $transactionType;
    public approvedAmount $approvedAmount;
    public string $transactionStatus;
    public requestSent $requestSent;
    public paymentLink $paymentLink;
}

class approvedAmount extends FiservObject
{
    public string $total;
    public string $currency;
    public components $components;
}

class components extends FiservObject
{
    public string $subtotal;
    public string $vatAmount;
    public string $shipping;
}

class requestSent extends FiservObject
{
    public orderDetails $orderDetails;
    public checkoutSettings $checkoutSettings;
    public paymentMethodDetails $paymentMethodDetails;
}

class orderDetails extends FiservObject
{

}

class checkoutSettings extends FiservObject
{
    public string $locale;
    public redirectBackUrls $redirectBackUrls;
}

class redirectBackUrls extends FiservObject
{
    public string $successUrl;
    public string $failureUrl;
}

class paymentMethodDetails extends FiservObject
{
    public cards $cards;
    public sepaDirectDebit $sepaDirectDebit;
    public payPal $payPal;
    public tokenBasedTransaction $tokenBasedTransaction;

    public function __construct($json = false)
    {
        $this->requiredFields = [
            'cards',
        ];

        FiservObject::__construct($json);
    }
}

class tokenBasedTransaction extends FiservObject
{
    public string $value;
    public string $transactionSequence;
}

class payPal extends FiservObject
{
    public riskData $riskData;
}

class riskData extends FiservObject
{
}

class sepaDirectDebit extends FiservObject
{
    public string $transactionSequenceType;
}

class cards extends FiservObject
{
    public authenticationPreferences $authenticationPreferences;
    public TokenBasedTransaction $tokenBasedTransaction;
    public createToken $createToken;

    public function __construct($json = false)
    {
        $this->requiredFields = [
            'createToken',
        ];

        FiservObject::__construct($json);
    }
}


class authenticationPreferences extends FiservObject
{
    public string $challengeIndicator;
    public bool $skipTra;
}

// {
//     "storeId": "72305408",
//     "checkoutId": "IUBsFE",
//     "orderId": "72110c52-5f65-4206-8981-fa6406439aee",
//     "transactionType": "SALE",
//     "approvedAmount": {
//       "total": 25,
//       "currency": "EUR",
//       "components": {
//         "subtotal": 20,
//         "vatAmount": 2,
//         "shipping": 3
//       }
//     },
//     "transactionStatus": "INITIATED",
//     "requestSent": {
//       "orderDetails": {},
//       "checkoutSettings": {
//         "redirectBackUrls": {
//           "successUrl": "https://www.success.com/",
//           "failureUrl": "https://www.failureexample.com"
//         }
//       },
//       "paymentMethodDetails": {
//         "cards": {
//           "authenticationPreferences": {
//             "challengeIndicator": "01"
//           },
//           "tokenBasedTransaction": {
//             "value": "ApoorvaTest9thNov",
//             "transactionSequence": "SUBSEQUENT"
//           }
//         },
//         "sepaDirectDebit": {
//           "transactionSequenceType": "SINGLE"
//         },
//         "payPal": {
//           "riskData": {}
//         }
//       }
//     }
//   }