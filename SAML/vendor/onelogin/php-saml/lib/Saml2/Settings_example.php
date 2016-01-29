<?php

$settings = array (
   
    'strict' => false,

    
    'debug' => false,

    
    'sp' => array (
       
        'entityId' => '',
      
        'assertionConsumerService' => array (
           
            'url' => '',
        
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ),
       
        'singleLogoutService' => array (
         
            'url' => '',
     
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
     
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
       
        'x509cert' => '',
        'privateKey' => '',

    ),

   
    'idp' => array (
       
        'entityId' => 'http://fs.cancer.org.uk/adfs/services/trust',
        
        'singleSignOnService' => array (
            
            'url' => '',
            
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        
        'singleLogoutService' => array (
            
            'url' => '',
           
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
       
        'x509cert' => 'MIIC4jCCAcqgAwIBAgIQWwflgON3mrpLeAah4fNf/zANBgkqhkiG9w0BAQsFADAtMSswKQYDVQQDEyJBREZTIEVuY3J5cHRpb24gLSBmcy5jYW5jZXIub3JnLnVrMB4XDTE1MDgxOTEyNDgyMVoXDTE2MDgxODEyNDgyMVowLTErMCkGA1UEAxMiQURGUyBFbmNyeXB0aW9uIC0gZnMuY2FuY2VyLm9yZy51azCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAMX+CbWFiA355SyvTgY4jjbGpdxifhkq0orM+CsvI0c5Cvam/EqbQpiSDav0tnKM8RotOYJxnq7T61Q8K9p7wmO6VFYsypig5U2VTNhGD9IxyzmFEObMfPOEWXDaP3jPShFlviji/e9a9Cq7lNF7N4NTjDxXbKYO7AvoI9WcBTCZG5N57a6L0nLpAdDO1k8zmdSIrcmNAuPtEMsW3dPo/54jZDEQh9AeMK9oH7q23WG/YLXMcvdTCXA60mwB2pVAZ43Hvk3t50TSHgaxOu7t4MF8ScAPA+cgGcTRZLvr0PZwL3oY78h13/aHSQQwoR03kD57ZYgLRtoeKkJZc3e3Ep0CAwEAATANBgkqhkiG9w0BAQsFAAOCAQEAsU2w4n6mj2ldvgk27rrKAO1NsFO5QfOFYcDU4fwOZv7x7k6CqxIjl4i7IjnqZxsU0W+B//0b5Pb+pKfCkQ/USqwSkxvR3Yc6+NhU0oXGPSFEqr1+DHOh2Bcmu74LO4OeRE4Y6nHPvKJQN/mqyiO3sJ0Vema0/69wext8wdq68Pl3V0xvARhg2+gs6cflmVt9+ug7x0oKQGO4JhLyzPkikhX0racGFt9nXyDZw1WjFeImnEvThq65SgYUMig9+cMgBFsuYHm9zTwYuSvgUpXROUVHbU1vohA50d0EP2itsjzEjGc37gCERoFcEN9UHTUCnsHUtL5/HCnkAKjmt443ug==',
      
        // 'certFingerprint' => '',
        // 'certFingerprintAlgorithm' => 'sha1',
    ),
);