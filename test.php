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

    if (empty($result['name'])) {
        throw new Exception('Name must be set!');
    }

    if (empty($result['alias'])) {
        throw new Exception('Alias must be set!');
    }

    $projects = $result['projects'];

    foreach ($projects as $index => $prj) {
        if (empty($prj['name'])) {
            throw new Exception("Name of project {$index} must be set!");
        }
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
