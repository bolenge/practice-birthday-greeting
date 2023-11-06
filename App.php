<?php
require_once './SendMail.php';

class App
{
    public static function run(string $fileName)
    {
        if (file_exists($fileName)) {
            echo "Reading file..." . PHP_EOL;
            $firstLine = true;
            $content = explode(PHP_EOL, file_get_contents($fileName));
            if (!empty($content)) {
                foreach ($content as $line) {
                    if ($firstLine) {
                        $firstLine = false;
                    } else {
                        $tokens = explode(',', $line);
                        foreach ($tokens as $i => $token) {
                            $tokens[$i] = trim($token);
                        }
                        if (count($tokens) == 4) {
                            $date = explode('/', $tokens[2]);
                            if (count($date) == 3) {
                                if ((int)date('d') == (int)$date[0] && (int)date('m') == (int)$date[1]) {
                                    SendMail::send(
                                        $tokens[3],
                                        "Joyeux Anniversaire !",
                                        "Bonjour " . $tokens[0] . ",\nJoyeux Anniversaire !\nA bientôt,"
                                    );
                                }
                            } else {
                                echo "Cannot read birthdate for " . $tokens[0] . " " . $tokens[1] . PHP_EOL;
                            }
                        } else {
                            echo "Invalid file format" . PHP_EOL;
                        }
                    }
                }
                echo "Batch job done." . PHP_EOL;
            } else {
                echo "Error reading file '" . $fileName . "'" . PHP_EOL;
            }
        } else {
            echo "Unable to open file '" . $fileName . "'" . PHP_EOL;
        }
    }
}

App::run(__DIR__ . DIRECTORY_SEPARATOR . 'employees.txt');
