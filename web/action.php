<?
header('Content-type: application/json');

$action = $_REQUEST["action"];
$device_id = $_REQUEST["device_id"];
$command = "light_command " . $action . ' ' . $device_id;
$result;
$result_code;
exec($command . " 2>&1", $result, $result_code);

if ($result_code != 0) {
  http_response_code(500);
}
echo json_encode([
  "command" => $command,
  "result" => $result,
]);
?>
