<?php
session_start();
if (empty($_SESSION['lights'])) {
  $_SESSION['lights'] = [
    ['name' => 'Light 1', 'id' => '1', 'on' => false],
    ['name' => 'Light 2', 'id' => '2', 'on' => false],
    ['name' => 'Light 3', 'id' => '3', 'on' => false],
    ['name' => 'Light 4', 'id' => '4', 'on' => false],
  ];
}
$lights = $_SESSION['lights'];

function getLightClasses($light, $onButton) {
  $classes = 'mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect action-button';
  if ($light['on'] == $onButton) {
    $classes = $classes . ' action-button-offish';
  }
  return $classes;
}

?>

<html>
  <head>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript">
      function changeLight(deviceId, turnOn, onButtonId, offButtonId) {
        action = turnOn ? "on" : "off";
        get('action.php?action=' + action + '&deviceId=' + deviceId);
        if (turnOn) {
          document.getElementById(onButtonId).classList.add('action-button-offish');
          document.getElementById(offButtonId).classList.remove('action-button-offish');
        } else {
          document.getElementById(onButtonId).classList.remove('action-button-offish');
          document.getElementById(offButtonId).classList.on('action-button-offish');
        }
      }

      function get(url) {
          var xmlHttp = new XMLHttpRequest();
          xmlHttp.onreadystatechange = function() { 
              if (xmlHttp.readyState == 4 && xmlHttp.status != 200)
                  alert("Error calling " + url + " " + xmlHttp.status + " " + xmlHttp.readyState)
          }
          xmlHttp.open("GET", url, true); // true for asynchronous 
          xmlHttp.send(null);
      }
    </script>
    <style>
      .action-button {
        padding: 0;
        width: calc(50% - 20px);
        margin: 10;
        height: 70px;
        line-height: 70px;
      }

      .action-button-offish {
        opacity: 0.5;
      }
    </style>
  </head>
  <body>
    <div class="mdl-grid">
      <?php foreach ($lights as $light) { ?>
        <div class="mdl-cell mdl-cell--4-col">
          <div class="mdl-card mdl-shadow--2dp" style="width: 100%">
            <div class="mdl-card__title">
              <h4><?= $light['name'] ?> <?= $light['on'] ?></h4>
            </div>
            <div class="mdl-card__actions mdl-card--border" style="padding: 0; font-size: 0;">
              <?
                $onId = $light['id'] . 'on';
                $offId = $light['id'] . 'off';
              ?>
              <a class="<?=getLightClasses($light, true)?>"
                 onclick="changeLight(<?=$light['id']?>, true, '<?=$onId?>', '<?=$offId?>')"
                 id="<?=$onId?>"
                 href="#">
                On
              </a>
              <a class="<?=getLightClasses($light, false)?>"
                 onclick="changeLight(<?=$light['id']?>, false, '<?=$onId?>', '<?=$offId?>')"
                 id="<?=$offId?>"
                 href="#">
                Off
              </a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </body>
</html>
