<?php

require_once __DIR__ . '/doc-validator.php';

$validator = new PHPDocValidator();
$validator->run();
