<?php

require_once __DIR__ . '/doc-validator.php';

use script\PHPDocValidator;

$validator = new PHPDocValidator();
$validator->run();
