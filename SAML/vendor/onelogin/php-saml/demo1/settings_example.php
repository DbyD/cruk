<?php

   $spBaseUrl = 'http://cruk.loc/SAML/vendor/onelogin/php-saml';


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
            'entityId' => 'https://app.onelogin.com/saml/metadata/514832',
            'singleSignOnService' => array (
                'url' => 'https://app.onelogin.com/trust/saml2/http-post/sso/514832',
            ),
            'singleLogoutService' => array (
                'url' => 'https://app.onelogin.com/trust/saml2/http-redirect/slo/514832',
            ),
            'x509cert' => '-----BEGIN CERTIFICATE-----
MIIECDCCAvCgAwIBAgIUZnt8lWKvm+0PaU9mXIliYYeaxukwDQYJKoZIhvcNAQEF
BQAwUzELMAkGA1UEBhMCVVMxDDAKBgNVBAoMA1BhYzEVMBMGA1UECwwMT25lTG9n
aW4gSWRQMR8wHQYDVQQDDBZPbmVMb2dpbiBBY2NvdW50IDc3NDgxMB4XDTE2MDIw
MzA4MDgxOVoXDTIxMDIwNDA4MDgxOVowUzELMAkGA1UEBhMCVVMxDDAKBgNVBAoM
A1BhYzEVMBMGA1UECwwMT25lTG9naW4gSWRQMR8wHQYDVQQDDBZPbmVMb2dpbiBB
Y2NvdW50IDc3NDgxMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAu8u3
4BzOkQHCzXuSWXD1/jZVBH9MvQNc8Ddos+evjFBKvb9rmJLIUXKFN13YjNVFSCFN
FyA67eMK7AUHNE1YsPpPo+o73gfGqC9Wktc0a2C29Zhabo1osLRgDsOONJOkd9+l
PwVhVB9qkcYFSGo1U1RT0gr7CDDR0wJL/RBqzi9kntnGUyXIk/7GO3/bkW7NYby1
Z5AdRyifLPC187KOrt38PiEYSTQLwyFEsj37QKxbC9zQvw7ex6qS+l7lEPRKMsWv
3JUROVRAKpKZ/EDtRAQangu81Gf79byYP6SGr6dVX6Nmu9ue0UF7zg93fYWIPjoG
gOLGQ1NrMu3PG2Ho8wIDAQABo4HTMIHQMAwGA1UdEwEB/wQCMAAwHQYDVR0OBBYE
FGf6lddkRtYdkenirlHTzu2MnrjNMIGQBgNVHSMEgYgwgYWAFGf6lddkRtYdkeni
rlHTzu2MnrjNoVekVTBTMQswCQYDVQQGEwJVUzEMMAoGA1UECgwDUGFjMRUwEwYD
VQQLDAxPbmVMb2dpbiBJZFAxHzAdBgNVBAMMFk9uZUxvZ2luIEFjY291bnQgNzc0
ODGCFGZ7fJVir5vtD2lPZlyJYmGHmsbpMA4GA1UdDwEB/wQEAwIHgDANBgkqhkiG
9w0BAQUFAAOCAQEAfb8ZeWVgTdozm/s5z7MIupW4qBDwvjdNe4BrLi9SkhVxwyZp
xfLD+pIY07HKPalWqoP6WMEwxCBr9AKjQwNdndidQrHk58suCfC6we+DvQ+oR3P+
xJlPUwtabbD4+od8+DvUunIOFbi5IzP9qQHNIY9/e0ZxhS4D2njrYKS+qoxMlr2z
40uvGXnELuPVYjbDjJLA83HDvLba5X+ev6HOld8M9fBr4N05XFdzo4LwYb4C5tTM
R85ex1u42VZpwQvgl9/w58e73xmBuXfCjt0fJRER09crtYw+I1EWPThkyDY3hWRv
Zs/uzAYH/dkf2Aqsg0gimqoMPWCaTtIjGrbNqA==
-----END CERTIFICATE-----
',
        ),
    );