<?php

class GetCheckoutIdResponse
{

}

// {
//     "storeId": "72305408",
//     "checkoutId": "f2dd6a9e-4a1c-4c30-9a0e-4ead4f59e909",
//     "orderId": "31da1addc129a",
//     "transactionType": "SALE",
//     "approvedAmount": {
//       "total": 130,
//       "currency": "EUR",
//       "components": {
//         "subtotal": 115,
//         "vatAmount": 2,
//         "shipping": 2
//       }
//     },
//     "transactionStatus": "APPROVED",
//     "transactionFailure": {
//       "code": "2303",
//       "reason": "Invalid credit card number"
//     },
//     "paymentMethodUsed": {
//       "cards": {
//         "cardNumber": "414746******0083",
//         "expiryDate": {
//           "month": "03",
//           "year": "2031"
//         },
//         "brand": "VISA"
//       },
//       "tokenBasedTransaction": {
//         "value": "234ljl124l12",
//         "reusable": true,
//         "declinedDuplicates": false,
//         "cardNumber": "414746******0083",
//         "transactionSequence": "FIRST",
//         "schemeTransactionId": "012243800355698"
//       },
//       "payPal": {
//         "referenceNumber": "string"
//       },
//       "paymentMethodType": "string"
//     },
//     "currencyConversion": {
//       "dccOffered": true,
//       "exchangeRate": "1.2986",
//       "marginRatePercentage": "3"
//     },
//     "ipgTransactionDetails": {
//       "ipgTransactionId": "8154886515",
//       "transactionResult": "APPROVED",
//       "approvalCode": "N:-30031:No terminal setup"
//     },
//     "requestSent": {
//       "merchantTransactionId": "AB-1234",
//       "orderDetails": {
//         "customerId": "1234567890",
//         "invoiceNumber": "96126098",
//         "dynamicMerchantName": "Merchant XYZ",
//         "purchaseOrderNumber": "123055342",
//         "basket": {
//           "lineItems": [
//             {
//               "itemIdentifier": "Item001",
//               "name": "Mobile",
//               "price": 98,
//               "quantity": 1,
//               "shippingCost": 10,
//               "valueAddedTax": 22,
//               "miscellaneousFee": 0,
//               "total": 130
//             }
//           ]
//         },
//         "billing": {
//           "person": {
//             "firstName": "John",
//             "lastName": "Doe",
//             "dateOfBirth": "1975-01-31",
//             "name": "John Doe"
//           },
//           "contact": {
//             "phone": "4567278956",
//             "mobilePhone": "7834561235",
//             "email": "john@testemail.com",
//             "fax": "5555555767"
//           },
//           "address": {
//             "address1": "House No: 2, street -5",
//             "address2": "Weberstr",
//             "city": "BONN ",
//             "company": "Test company",
//             "country": "Germany",
//             "postalCode": "53113 ",
//             "region": "Nordrhein-Westfalen"
//           }
//         },
//         "shipping": {
//           "person": {
//             "firstName": "John",
//             "lastName": "Doe",
//             "dateOfBirth": "1975-01-31",
//             "name": "John Doe"
//           },
//           "contact": {
//             "phone": "4567278956",
//             "mobilePhone": "7834561235",
//             "email": "john@testemail.com",
//             "fax": "5555555767"
//           },
//           "address": {
//             "address1": "House No: 2, street -5",
//             "address2": "Weberstr",
//             "city": "BONN ",
//             "company": "Test company",
//             "country": "Germany",
//             "postalCode": "53113 ",
//             "region": "Nordrhein-Westfalen"
//           }
//         }
//       },
//       "checkoutSettings": {
//         "locale": "de_DE",
//         "preSelectedPaymentMethod": "cards",
//         "webHooksUrl": "https://yourapp.com/data",
//         "redirectBackUrls": {
//           "successUrl": "https://www.successexample.com",
//           "failureUrl": "https://www.failureexample.com"
//         }
//       },
//       "paymentMethodDetails": {
//         "cards": {
//           "authenticationPreferences": {
//             "challengeIndicator": "01",
//             "scaExemptionType": "LOW_VALUE_EXEMPTION",
//             "skipTra": false
//           },
//           "createToken": {
//             "customTokenValue": "234ljl124l12",
//             "declineDuplicateToken": false,
//             "reusable": true,
//             "toBeUsedFor": "UNSCHEDULED"
//           },
//           "tokenBasedTransaction": {
//             "value": "234ljl124l12",
//             "transactionSequence": "FIRST",
//             "schemeTransactionId": "012243800355698"
//           }
//         },
//         "sepaDirectDebit": {
//           "mandateReference": "3RBQVEE",
//           "signatureDate": "2021-06-15",
//           "transactionSequenceType": "SINGLE",
//           "mandateReferenceUrl": "https://www.example.com"
//         },
//         "payPal": {
//           "riskData": {
//             "clientMetaId": "trc-123",
//             "merchantParameters": "string"
//           }
//         }
//       }
//     }
//   }