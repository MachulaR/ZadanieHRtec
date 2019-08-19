<?php namespace RemigiuszMachulaRekrutacjaHRtec\src;

use RemigiuszMachulaRekrutacjaHRtec\src\csv\CsvExtended;
use RemigiuszMachulaRekrutacjaHRtec\src\csv\CsvSimple;
use RemigiuszMachulaRekrutacjaHRtec\src\entity\Command;

class CommandExecute{

    public function execute(Command $command){

        if (!$this->is_command_correct($command)) {
            echo "Invalid command. Check command and try again.";
            exit;
        }
        $file_operations = new FileOperations();
        $file_operations->check_path($command->getPath());

        echo "Connecting... \n";

        $xml = $file_operations->download_xml($command->getUrl());

        echo "Connected. Proceeding further...\n";


        $list = $file_operations->prepare_data_from_xml($xml);

        if ($command->getCommand() == 'csv:simple') {

            $csv_simple = new CsvSimple();
            $mode = $csv_simple->check_csv_file($command);
            $file_operations->save_to_file($command->getPath(), $list, $mode);

        } else if ($command->getCommand() == 'csv:extended'){

            $csv_extended = new CsvExtended();
            $mode = $csv_extended->check_csv_file($command);
            $file_operations->save_to_file($command->getPath(), $list, $mode);

        } else {
            echo "Oops. Something went wrong! Try again. \n";
            exit;
        }
        echo "All operations ended. Your file is ready!";

    }

    public function read_from_cli()
    {
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        return $line;
    }

    public function is_command_correct(Command $command)
    {
        if (!($command->getLength() == 4)) {
            return false;
        }

        if (!($command->getCommand() == 'csv:simple' || $command->getCommand() == 'csv:extended')) {
            return false;
        }

        if (!(preg_match('/^(http|https):\\/\\/[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $command->getUrl()))) {
            return false;
        }

        $file_operations = new FileOperations();
        if (!($file_operations->is_filepath($command->getPath()))) {
            return false;
        }

        return true;
    }

}