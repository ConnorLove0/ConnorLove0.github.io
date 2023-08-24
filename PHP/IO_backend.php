<?php
// Helper function to check is a number is an Armstrong number
function isArmstrong($number) {
    $sum = 0;
    $tempNum = $number;
    $digits = strlen((string) $number);

    while ($tempNum > 0) {
        $remainder = $tempNum % 10;
        $sum += pow($remainder, $digits);
        $tempNum = (int)($tempNum / 10);
    }

    return $sum === $number;
}

// Helper function to check is a number is a Prime number
function isPrime($number) {
    $number = intval($number);
    if ($number < 2) {
        return false;
    }

    for ($i = 2; $i <= sqrt($number); $i++) {
        if (($number % $i) === 0) {
        return false;
        }
    }
    return true;
}

// Helper function to check is a number is an Fibonacci number
function isFibonacci($number) {
    $fibonacci = [0, 1];

    while (end($fibonacci) <= $number) {
        if (end($fibonacci) === $number) {
            return true;
        }
        $next = end($fibonacci) + prev($fibonacci);
        $fibonacci[] = $next;
    }

    return false;
}

function process_numbers($numbers) {
    // Validate the input and filter numbers to respective text files
    $primeFile = fopen('prime.txt', 'w');
    $armstrongFile = fopen('armstrong.txt', 'w');
    $fibonacciFile = fopen('fibonacci.txt', 'w');
    $noneFile = fopen('none.txt', 'w');

    $uniquePrimes = array(); // Store unique prime numbers here
    $uniqueArmstrong = array(); // Store unique Armstrong numbers here
    $uniqueFibonacci = array(); // Store unique Fibonacci numbers here


    foreach ($numbers as $number) {
        $number = trim($number);

        $isPrime = false;
        $isArmstrong = false;
        $isFibonacci = false;

        // Check if the number is prime
        if (isPrime($number)) {
            if(!in_array($number, $uniquePrimes)) {
                fwrite($primeFile, $number . "\n");
                $uniquePrimes[] = $number;
            }
            $isPrime = true;
        }

        // Check if the number is an Armstrong number
        if (isArmstrong($number)) {
            if(!in_array($number, $uniqueArmstrong)) {
                fwrite($armstrongFile, $number . "\n");
                $uniqueArmstrong[] = $number;

            }
            $isArmstrong = true;
        }

        // Check if the number is a Fibonacci number
        if (isFibonacci($number)) {
            if(!in_array($number, $uniqueFibonacci)) {
                fwrite($fibonacciFile, $number . "\n");
                $uniqueFibonacci[] = $number;
            }
            $isFibonacci = true;
        }

        // If the number is not Prime, Armstrong, or Fibonacci, add it to none.txt
        if (!$isPrime && !$isArmstrong && !$isFibonacci) {
            fwrite($noneFile, $number . "\n");
        }
    }

    // Close the files
    fclose($primeFile);
    fclose($armstrongFile);
    fclose($fibonacciFile);
    fclose($noneFile);
}

function reset_app() {
    $files = ['prime.txt', 'armstrong.txt', 'fibonacci.txt', 'none.txt'];
    foreach ($files as $file) {
        echo "Clearing contents of $file\n";
        file_put_contents($file, "");
    }

    // Clear the cookie by setting its expiration to the past
    setcookie('app_first_time', 'false', time() - 3600, "/"); // Set the expiration to 1 hour ago
}

function read_file($fileName) {
    $filePath = __DIR__ . '/' . $fileName;
    if (file_exists($filePath)) {
        return nl2br(file_get_contents($filePath));
    } else {
        return "File not found!";
    }
}
// Handle AJAX requests
if (isset($_GET['operation'])) {
    if ($_GET['operation'] === 'read' && isset($_GET['file'])) {
        $fileType = $_GET['file'];
        switch ($fileType) {
            case 'armstrong.txt':
                echo read_file('armstrong.txt');
                break;
            case 'fibonacci.txt':
                echo read_file('fibonacci.txt');
                break;
            case 'prime.txt':
                echo read_file('prime.txt');
                break;
            case 'none.txt':
                echo read_file('none.txt');
                break;
            default:
                echo "Invalid file type!";
        }
        exit();
    } elseif ($_GET['operation'] === 'reset') {
        reset_app();
        echo "App has been reset!";
    }
}

?>