<?php

echo bin2hex(random_bytes(60)).PHP_EOL;

echo  (new \DateTime())->modify('+1 hour')->format('Y-m-d H:i:s') . PHP_EOL;
