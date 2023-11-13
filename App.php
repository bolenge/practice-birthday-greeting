<?php
require_once './SendMail.php';

class App
{
    public function run(string $fileName)
    {
        $employees = $this->getEmployeesFileLines($fileName);

        if (!empty($employees)) {
            $firstLine = true;

            foreach ($employees as $employee) {
                if ($firstLine) {
                    $firstLine = false;
                } else {
                    $employeeInfos = $this->parseEmployeeInfos($employee);

                    $this->sendEmployeeMailBirthday($employeeInfos);
                }
            }

                echo "Batch job done." . PHP_EOL;
        }
    }

    public function readEmployeesFile (string $fileName): string
    {
        if (file_exists($fileName)) {
            echo "Reading file..." . PHP_EOL;

            return file_get_contents($fileName);
        }

        echo "Unable to open file '" . $fileName . "'" . PHP_EOL;

        return '';
    }

    public function getEmployeesFileLines (string $fileName): array
    {
        $fileContent = $this->readEmployeesFile($fileName);

        if (empty($fileContent)) {
            echo "Error reading file " . PHP_EOL;
            return [];
        }

        return explode(PHP_EOL, $fileContent);
    }

    public function parseEmployeeInfos (string $employeeInfos): array
    {
        $employeeInfos = explode(',', $employeeInfos);

        foreach ($employeeInfos as $i => $token) {
            $employeeInfos[$i] = trim($token);
        }

        if (count($employeeInfos) !== 4) {
            echo "Invalid file format" . PHP_EOL;

            return [];
        }

        return $employeeInfos;
    }

    public function parseEmployeeBirthDate (array $employeeInfos): array
    {
        $date = explode('/', $employeeInfos[2]);

        if (count($date) !== 3) {
            echo "Cannot read birthdate for " . $employeeInfos[0] . " " . $employeeInfos[1] . PHP_EOL;

            return [];
        }

        return $date;
    }

    public function isEmployeeBirthDate (array $employeeBirthDate): bool
    {
        return (int)date('d') == (int)$employeeBirthDate[0] && (int)date('m') == (int)$employeeBirthDate[1];
    }

    public function sendEmployeeMailBirthday(array $employee)
    {
        if (!empty($employee)) {
            $birthDate = $this->parseEmployeeBirthDate($employee);

            if (!empty($birthDate) && $this->isEmployeeBirthDate($birthDate)) {
                SendMail::send(
                    $employee[3],
                    "Joyeux Anniversaire !",
                    "Bonjour " . $employee[0] . ",\nJoyeux Anniversaire !\nA bientôt,"
                );
            }
        }
    }
}

(new App())->run(__DIR__ . DIRECTORY_SEPARATOR . 'employees.txt');
