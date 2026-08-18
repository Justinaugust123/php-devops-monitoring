<?php

header('Content-Type: text/plain; version=0.0.4');

echo "# HELP php_app_requests_total Total application requests\n";
echo "# TYPE php_app_requests_total counter\n";
echo "php_app_requests_total 1\n";

echo "# HELP php_app_up Application availability\n";
echo "# TYPE php_app_up gauge\n";
echo "php_app_up 1\n";

echo "# HELP php_app_info PHP application information\n";
echo "# TYPE php_app_info gauge\n";
echo 'php_app_info{version="1.0",language="php"} 1' . "\n";
