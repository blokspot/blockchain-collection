#!/usr/bin/env php
<?php

define("ROOTPATH", realpath(__DIR__));

$projectsPath = ROOTPATH . '/projects';

$errors = [];

function validateFile(string $file)
{
    $result = yaml_parse_file($file);
    if (!$result) {
        throw new Exception("Invalid format");
    }
}

foreach (glob("{$projectsPath}/*.yml") as $file) {
    $filename = basename($file);
    try {
        validateFile($file);
    } catch (Throwable $exception) {
        $errors[$filename] = $exception->getMessage();
    }
}

if (empty($errors)) {
    echo "Passed\n";
    exit(0);
}

foreach ($errors as $file => $message) {
    echo " == {$file} == \n";
    echo " == {$message} \n\n";
}
exit(1);
