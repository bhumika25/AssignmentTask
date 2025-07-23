<?php
// --- CORS HEADERS ---
header("Access-Control-Allow-Origin:  http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// --- Require your app files ---
require_once 'src/Parsers/Broker1Parser.php';
require_once 'src/Parsers/Broker2Parser.php';
require_once 'src/Services/PolicyService.php';
require_once 'src/Services/StatsService.php';
require_once 'src/Utils/DataFormatter.php';


$formatter = new DataFormatter();
$parsers = [
    ['file' => __DIR__ . "/data/broker1.csv", 'parser' => new Broker1Parser($formatter)],
    ['file' => __DIR__ . "/data/broker2.csv", 'parser' => new Broker2Parser($formatter)]
];

$csvReader = new CSVReader();

$policyService = new PolicyService($parsers, $csvReader);
$statsService = new StatsService();
$policies = $policyService->getAllPolicies();
error_log("REQUEST_URI: " . $_SERVER["REQUEST_URI"]);
error_log("PATH_INFO: " . ($_SERVER["PATH_INFO"] ?? 'not set'));
error_log("SCRIPT_NAME: " . $_SERVER["SCRIPT_NAME"]);
error_log("PHP_SELF: " . $_SERVER["PHP_SELF"]);

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
error_log("Requested path: " . $path);


switch ($path) {
    case '/api/policies':
        if (isset($_GET['broker'])) {
            $filtered = array_filter($policies, fn($p) => in_array(strtolower($_GET['broker']), array_map('strtolower', $p)));
            echo json_encode(array_values($filtered));
        } else {
            echo json_encode($policies);
        }
        break;

    case '/api/getpolicies':
        echo json_encode($policies);
        break;

    case '/api/stats':
        echo json_encode($statsService->calculate($policies));
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Not found']);
}
