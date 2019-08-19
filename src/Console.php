<?php namespace RemigiuszMachulaRekrutacjaHRtec\src;

require __DIR__.'/../vendor/autoload.php';

use RemigiuszMachulaRekrutacjaHRtec\src\entity\Command;

$command = new Command();
$command->setLength(sizeof($argv));
$command->setCommand((array_key_exists(1, $argv) ? $argv[1] : NULL));
$command->setUrl((array_key_exists(2, $argv) ? $argv[2] : NULL));
$command->setPath((array_key_exists(3, $argv) ? $argv[3] : NULL));

// those few line below are just for testing in CLI. They allow to shorten CLI command to "php src/console.php" if uncommented
// keep in mind, that they can disturb manual testing if used incorrectly
//$command->setLength(4);
//$command->setUrl('http://feeds.nationalgeographic.com/ng/News/News_Main');
//$command->setCommand('csv:simple');
//$command->setPath('simple_export.csv');

$csv = new CommandExecute();
$csv->execute($command);
