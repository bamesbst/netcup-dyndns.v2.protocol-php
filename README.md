# netcup-dyndns.v2.protocol-php
*This project is a service to use netcup.de-hosted domains as a ddns-domains using the dyndns-v2-protocol on a php server.*
*It is not affiliated with the company netcup GmbH.*
*netcup is a registered trademark of netcup GmbH, Karlsruhe, Germany.*

## Requirements
* Be a netcup customer: https://www.netcup.de – or for international customers: https://www.netcup.eu
    * You don't have to be a domain reseller to use the necessary functions for this client – every customer with a domain may use it.
* netcup API key and API password, which can be created within your CCP at https://ccp.netcup.net
* A device (e.g. Router: FritzBox / Telekom Speedport) or software which is supporting the dyndns-v2-protocol.
  * See https://www.noip.com/integrate/request for an example
* A PHP-server-configuration that supports submitting of the *PHP_AUTH parameters*.
  * See https://www.php.net/manual/de/features.http-auth.php for more information
  + You could maybe use the *.htaccess configuration* to provide a *RewriteRule*.
* A domain ;-)

## Features
### Implemented
* PHP-Call using the dyndns-protocol.
* Reducing the TTL-time to 300 seconds.
* Authentication with username and password.
* Return-messages (dyndns-protocol [QUIET=on] and for debugging [QUIET=off]).


### Missing
* Support for IPv6 addresses.
* Multiple user-support (actually only one static user supported).
* Multiple domain-support (actually only one static domain supported).

## Getting started
### Configuration
Configuration is very simple:
* Copy `config.dist.php` to `config.php`
    * `cp config.dist.php config.php`
* Fill out `config.php` with the required values. The options are explained in there.
* Configure your device with the domain, where you are hosting this service.
* Enjoy!

### How to use
This is an example call:
`http://username:password@dyndns.example.de/index.php?hostname=yourhostname&myip=1.1.1.3`

## Example outputs
* `good IP` - Successful DDNS update
* `nochg IP` - No change in the IP-Address / No DDNS update needed
* `badauth` - Authentication failure
* `911` - Error (see debugging messages [turn of the QUIET-option] for further information)



If you have ideas on how to improve this script, please don't hesitate to create an issue or provide me with a pull request. Thank you!
