Use this PHP code to send SMS using the SureSMS SMS Gateway. 

SureSMS
=======

You need to have a paid account with <a href="https://www.suresms.com">SMS Gateway</a> in order to send SMS messages with this code. Account is free, but you pay for each SMS. 

Example
-------

``` php
$recipient = '12345678';
$sender = 'SureSMS';
$SureSMS = new SureSMS('myUsername', 'myPassword'); 
$SureSMS->send("Helo world!", $recipient, $sender);
```
