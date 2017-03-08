## Spree Sharks API

This API will be used for Apple TV push notifications.

### Get all registered devices
`curl -X GET http://spreesharks.tlangelani.co.za/api`

### Register new device
`curl -X POST -H 'Content-Type: application/x-www-form-urlencoded' -d 'email=abc@example.com&token=123xyz' http://spreesharks.tlangelani.co.za/api`