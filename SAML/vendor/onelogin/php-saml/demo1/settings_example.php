<?php

   $spBaseUrl = 'http://cruk.exec.com/SAML/vendor/onelogin/php-saml';


   $settingsInfo = array (
        'sp' => array (
            // example: http://myapp.com/demo1/metadata.php
            'entityId' => $spBaseUrl.'/demo1/metadata.php',

            // example: http://myapp.com/demo1/index.php?acs
            'assertionConsumerService' => array (
                'url' => $spBaseUrl.'/demo1/index.php?acs',
            ),

            // example: http://myapp.com/demo1/index.php?sls
            'singleLogoutService' => array (
                'url' => $spBaseUrl.'/demo1/index.php?sls',
            ),
            'NameIDFormat' => 'emailAddress',
        ),
        'idp' => array (
            'entityId' => 'https://fs.cancer.org.uk/adfs/ls/',
            'singleSignOnService' => array (
                'url' => 'https://fs.cancer.org.uk/adfs/ls/IdpInitiatedSignon.aspx',
            ),
            'singleLogoutService' => array (
                'url' => 'https://fs.cancer.org.uk/adfs/ls/',
            ),
            'x509cert' => '-----BEGIN CERTIFICATE-----
MIIC3DCCAcSgAwIBAgIQKn/y8lSRGqNEV0sad+KclDANBgkqhkiG9w0BAQsFADAqMSgwJgYDVQQDEx9BREZTIFNpZ25pbmcgLSBmcy5jYW5jZXIub3JnLnVrMB4XDTE1MDgxOTEyNDgyMVoXDTE2MDgxODEyNDgyMVowKjEoMCYGA1UEAxMfQURGUyBTaWduaW5nIC0gZnMuY2FuY2VyLm9yZy51azCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBALcXNrAMeJiw60niI380NA9aDc5nZsCbze4gAu3ER+g3CQunvRYD+H+V2TWBkPsa/8hstNnYKcRLZc3bq68qOIvOuAwya43kEkxCXY+YB3fgszDgFZ5jEuSKaTvWh3++HttHB+gs8GwqgyNSTY+wtem0lujE9/I5cN4zpXew0E9UC4letn7l3iR8iuFueCYk+70YK95RTmS5dS1/nTzLYXW7Ctn+VXeX+TmvbsWQax7K72d4734YHMYE9zj+aaerbU812xQq9mqLF+trxGK17SNACECcEpAhhnXywueHjlFfdtBlHSrWnXb39qsWCTQ5SeaOUntLUh/r2GGANDpnLNkCAwEAATANBgkqhkiG9w0BAQsFAAOCAQEADH65xNK/98BMg9ZJ6/+g2LGH/hnIx2Ipok8u+Xq+k73wLWYtJ5jH49zC6Ob2F7xe876ESU1jumtUG/Jt9BiIDT4LmUs2SrtllQ4mXktZWTajcfO98DWmhKawKiCwUbp9mAD/Ii83mbpXMAQXG6njxfXKWo+2m5uBUuoq9pUGp4MKyMDJp1cgKdSiqSXX2fl+RFYUUjwnOieXCoLWYrp8tAxlpxcb5qZgEUNmh/aWUx09AiaMaDmokaMdHeIEPslLZfa8aLAUIxEVPClifYhevpaXEmetu/F5zQxla60LSp/ns8s+K755rvQb5l7zds/6mG4WQTyLQn4AhHkdHAFnBA==
-----END CERTIFICATE-----',
        ),
    );