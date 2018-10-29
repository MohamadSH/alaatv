<?php

namespace App\Helpers;

class ENPayment
{
////////////////////////////////////////////////////login///////////////////////////////////////////////////
    public function login($username, $password)
    {


        $client = new \nusoap_client('https://pna.shaparak.ir/ref-payment2/jax/merchantService?wsdl', true);

        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }

        $params = array('param' => array('UserName' => $username, 'Password' => $password)); // print_r($params);
        $result = $client->call('MerchantLogin', $params);

        if ($client->fault) {
//            echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
        } else {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
//                echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
            }
        }

        //print_r($result);
        $result = $result["return"];
        if (strcmp($result["Result"], "erSucceed") == 0) {
            return ["sessionId" => $result["SessionId"]];
        } else {
            return ["error" => "خطا"];
        }
    }

////////////////////////////////////////////////////////VerifyTrans///////////////////////////////////////////////
    public function VerifyTrans($login, $RefNum)
    {

        $client = new \nusoap_client('https://pna.shaparak.ir/ref-payment2/jax/merchantService?wsdl', true);

        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }

        $params = array('context' => array('data' => array('entry' => array('key' => 'SESSION_ID', 'value' => $login))), 'verifyRequest' => array('refNumList' => array($RefNum)));

        // print_r($params);
        $result = $client->call('VerifyMerchantTrans', $params);

        if ($client->fault) {
//            echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
        } else {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
//                echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
            }
        }

        //print_r($result);
        return $result;

    }

///////////////////////////////////////////tokenVerify//////////////////////////////////////////////////////////////

    public function tokenPurchaseVerifyTransaction($params)
    {

        $wsContext = $params['WSContext'];
        $token = $params['token'];
        $referenceNumber = $params['RefNum'];

        $client = new \nusoap_client('https://pna.shaparak.ir/ref-payment2/jax/merchantService?wsdl', true);

        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }


        $params = array('param' => array('WSContext' => $wsContext, 'Token' => $token, 'RefNum' => $referenceNumber));
        $result = $client->call('VerifyMerchantTrans', $params);
        //print_r($params);

        if ($client->fault) {
//            echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
        } else {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                //echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
            }
        }

        //print_r($result);
        return $result;

    }

////////////////////////////////////////////////////getPurchaseParamsToSign/////////////////////////////////////////////////////

    public function getPurchaseParamsToSign($params)
    {


        $resNum = $params['resNum'];
        $amount = $params['amount'];
        $redirectUrl = $params['redirectUrl'];
        $transType = $params['transType'];
        $wsContext = $params['WSContext'];

        $client = new \nusoap_client('https://pna.shaparak.ir/ref-payment2/jax/merchantService?wsdl', true);

        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }

        $params = array('param' => array('WSContext' => $wsContext, 'ReserveNum' => $resNum, 'Amount' => $amount, 'AmountSpecified' => true, 'RedirectUrl' => $redirectUrl, 'TransType' => $transType));
        $result = $client->call('GenerateTransactionDataToSign', $params);
        //print_r($params);

        if ($client->fault) {
//            echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
        } else {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                //echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
            }
        }

        //print_r($result);
        $result = $result["return"];
        if (strcmp($result["Result"], "erSucceed") == 0) {
            return ["dataToSign" => $result["DataToSign"], "uniqueId" => $result["UniqueId"]];
        } else {
            return ["error" => "خطا"];
        }

    }

//////////////////////////////////////////////////generateSignedPurchaseToken/////////////////////////////////////////////////////////////

    public function generateSignedPurchaseToken($params)
    {
        $signature = $params['signature'];
        $uniqueId = $params['uniqueId'];
        $wsContext = $params['WSContext'];

        $client = new \nusoap_client('https://pna.shaparak.ir/ref-payment2/jax/merchantService?wsdl', true);

        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }


        $params = array('param' => array('WSContext' => $wsContext, 'UniqueId' => $uniqueId, 'Signature' => $signature));
        $result = $client->call('GenerateSignedDataToken', $params);
        //print_r($params);

        if ($client->fault) {
//            echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
        } else {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                //echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
            }
        }

        //print_r($result);
        $result = $result["return"];
        if (strcmp($result["Result"], "erSucceed") == 0) {
            return ["token" => $result["Token"], "userId" => $result["UserId"], "channelId" => $result["ChannelId"], "expirationDate" => $result["ExpirationDate"]];
        } else {
            return ["error" => "خطا"];
        }

    }

//////////////////////////////////////////////////logout//////////////////////////////////////////////////
    public function logout($login)
    {

        $client = new \nusoap_client('https://pna.shaparak.ir/ref-payment2/jax/merchantService?wsdl', true);

        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }

        $params = array('context' => array('data' => array('entry' => array('key' => 'SESSION_ID', 'value' => $login))));


        $result = $client->call('MerchantLogout', $params); //print_r($params);

        if ($client->fault) {
//            echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
        } else {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                //echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
            }
        }

        //print_r($result);
        return $result;

    }


/////////////////////////////////////////////////ReverseMerchantTrans////////////////////////////////////////////////////////
    public function ReverseMerchantTrans($params)
    {

        $MerchantLogin = $params['MerchantLogin'];
        $RefNum = $params['RefNum'];
        $Token = $params['Token'];
        $Amount = $params['Amount'];


        $client = new nusoap_client('https://pna.shaparak.ir/ref-payment2/jax/merchantService?wsdl', true);

        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }

        $params = array('context' => array('data' => array('entry' => array('key' => 'SESSION_ID', 'value' => $MerchantLogin))),
            'reverseRequest' => array('Amount' => $Amount, 'RefNum' => $RefNum));


        $result = $client->call('ReverseMerchantTrans', $params);

        if ($client->fault) {
            echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>';
            print_r($result);
            echo '</pre>';
        } else {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                //echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
            }
        }

        return $result;

    }
////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////reportTransaction//////////////////////////////////////////////////////

//    public function reportTransaction($login)
//    {
//
//        $MerchantLogin = $login['MerchantLogin'];
//        $RefNum = $login['RefNum'];
//        $Token = $login['Token'] ;
//        $Amount = $login['Amount'] ;
//
//        $client = new \nusoap_client('https://pna.shaparak.ir/ref-payment2/jax/merchantService?wsdl',true);
//
//        $err = $client->getError();
//        if ($err) {
//            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
//            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
//            exit();
//        }
//
//        $params = array('context' => array('data' => array('entry' => array('key' => 'SESSION_ID','value' => $MerchantLogin))),
//            'reverseRequest' => array('Amount' => $Amount,'RefNum' => $RefNum));
//
//
//        $result = $client->call('ReverseMerchantTrans', $params);
//
//        if ($client->fault) {
////            echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
//        } else {
//            $err = $client->getError();
//            if ($err) {
//                echo '<h2>Error</h2><pre>' . $err . '</pre>';
//            } else {
//                //echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
//            }
//        }
//
//
//
//        // print_r($result);
//        return $result;
//
//    }

////////////////////////////////////////////////////detailReportTransaction/////////////////////////////////////////////////////
//    public function detailReportTransaction($login)
//    {
//
//
//
//        $client = new \nusoap_client('https://pna.shaparak.ir/ref-payment/jax/merchantAuth?wsdl',true);
//
//        $err = $client->getError();
//        if ($err) {
//            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
//            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
//            exit();
//        }
//
//        $params = array('context' => array('data' => array('entry' => array('key' => 'SESSION_ID','value' => $login))),'detailReportRequest' => array('offset' => '0', 'length' => '20'));
//
//
//        $result = $client->call('detailReportTransaction', $params); print_r($params);
//
//        if ($client->fault) {
////            echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
//        } else {
//            $err = $client->getError();
//            if ($err) {
//                echo '<h2>Error</h2><pre>' . $err . '</pre>';
//            } else {
//                //echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
//            }
//        }
//
//
//        // print_r($result);
//        return $result;
//
//    }
}