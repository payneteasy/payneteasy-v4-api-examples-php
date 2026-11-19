Contains framework code for using PaynetEasy API v4 protected with OAuth 1.0a
with RSA-SHA256 signature method.

Please note that this is a work in progress.

At this time, only OAuth 1.0a-related communication is covered in the examples.

## Requirements

PHP 7.0 or newer with the curl and openssl extensions. HTTPS connections use
the CA certificates of the operating system.

## Private key

`test-private-key.pem` is an example key and must not be used for real requests.
Generate your own RSA key (at least 2048 bits), for example:

    openssl genrsa -out private-key.pem 2048

Keep the key outside the web root, make it readable only by the user running
the examples and set its path in the `PAYNETEASY_PRIVATE_KEY_FILE` environment
variable.
