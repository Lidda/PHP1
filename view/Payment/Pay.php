<?php
  /*
   * Make sure to disable the display of errors in production code!
   */
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  require_once ("../../Logic/mollie/vendor/autoload.php");
  require_once ("../../Logic/mollie/examples/functions.php");
  /*
   * Initialize the Mollie API library with your API key.
   *
   * See: https://www.mollie.com/dashboard/developers/api-keys
   */
  $mollie = new \Mollie\Api\MollieApiClient();
  $mollie->setApiKey("test_Ds3fz4U9vNKxzCfVvVHJT2sgW5ECD8");

  // print_r($mollie);

  $payment = $mollie->payments->create([
      "amount" => [
          "currency" => "EUR",
          "value" => "10.00"
      ],
      "description" => "Fund ACNL website",
      "redirectUrl" => "http://632005.infhaarlem.nl/view/Payment/redirect.php",
      "webhookUrl"  => "http://thijsotter.infhaarlem.nl/payment-inf2b/webhook.php",
  ]);

  header("Location: " . $payment->getCheckoutUrl(), true, 303);
?>
