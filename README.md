# oid2weid
OID 2 WEID Konverter

Converts an OID to WEID or a WEID to an OID.

## What is WEID?
https://look-up.webfan3.de/?goto=oid%3A1.3.6.1.4.1.37553.8

## Usage
```php
$oid = '1.3.6.1.4.1.37553.8.9';
$weid = \WeidOidConverter::oid2weid($oid); // weid:9-1
$oid2 = \WeidOidConverter::weid2oid($weid);
print_r(($oid ===$oid2) ? 'OK' : 'ERROR'); 
```


## Authors
https://www.viathinksoft.com

