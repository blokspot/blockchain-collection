#!/usr/bin/env php

<?php

define("ROOTPATH", realpath(__DIR__));

$projectsPath = ROOTPATH . '/projects';

try {
    foreach (glob("{$projectsPath}/*.yml") as $file) {
        $result = yaml_parse_file($file);
        if (!$result) {
            $filename = basename($file);
            throw new Exception("Invalid format of '{$filename}'");
        }
    }
} catch (Throwable $exception) {
    echo $exception->getMessage();
    die(1);
}

echo "Passed\n";
exit(0);