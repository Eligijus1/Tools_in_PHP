<?php
/*
Run Examples:
=============
In Windows:

php add_date_time_to_all_files_in_specified_directory.php "C:\Users\Eligijus\Pictures\Screenshots"

In Linux:

php add_date_time_to_all_files_in_specified_directory.php "/home/Eligijus"
*/

declare(strict_types=1);

// Check specified arguments:
if (empty($argv[1])) {
    printMessage("ERROR", "Please specify directory path.");
    return;
}

// Specify directory:
$directory = $argv[1];

// Check if specified directory exist:
if (file_exists($directory)) {
    printMessage("INFO", "The directory '{$directory}' exists.");
} else {
    printMessage("ERROR", "The directory '{$directory}' does not exists.");
    return;
}

// Checking whether a file is directory or not:
if (is_dir($directory)) {
    printMessage("INFO", "'{$directory}' is a directory.");
} else {
    printMessage("ERROR", "'{$directory}' is not a directory.");
    return;
}

// Scan files in directory:
$files = scandir($directory);

// Looping files:
foreach($files as $file) {
    $fileFullPath = $directory . DIRECTORY_SEPARATOR  . $file;

    // Skip directories and other files:
    if (!is_dir($fileFullPath) && $file !== 'desktop.ini') {
        $dateString = date ("Y.m.d_H-i-s", filemtime($fileFullPath));
        $newFileName = "{$dateString}_$file";
        $newFileFullPath = $directory . DIRECTORY_SEPARATOR  . $newFileName;

        // Before rename check, maybe first 4 symbols - number, mean it is renamed:
        if (!is_numeric(substr($file, 0, 4))) {
            rename($fileFullPath, $newFileFullPath);
            printMessage("INFO", "Renamed '{$fileFullPath}' to {$newFileFullPath}");
        }
    }
}

printMessage("INFO", "Finished renaming.");

/**
 * Simple method to print messages.
 *
 * @param string $type
 * @param string $message
 *
 * @throws Exception
 */
function printMessage(string $type, string $message): void
{
    echo date_format(new DateTime(), 'Y.m.d H:i:s') . " {$type}: {$message}" . PHP_EOL;
}

