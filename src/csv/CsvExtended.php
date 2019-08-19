<?php namespace RemigiuszMachulaRekrutacjaHRtec\src\csv;

use RemigiuszMachulaRekrutacjaHRtec\src\CommandExecute;
use RemigiuszMachulaRekrutacjaHRtec\src\entity\Command;
use RemigiuszMachulaRekrutacjaHRtec\src\FileOperations;

class CsvExtended implements CsvInterface
{
    public function check_csv_file(Command $command)
    {
        if (file_exists($command->getPath())) {

            echo "File exist. We have to check that file. It can take a moment.\n";

            $file_operations = new FileOperations();
            if ($file_operations->check_data_in_file($command->getPath())) {
                echo "File OK. Proceeding further \n";
                $mode = 'a';
            } else {
                echo "The file probably does not contain valid data. Choose one of the actions:\n" .
                    "Overwrite file (data in the file will be lost) -> Enter 'overwrite'\n" .
                    "Keep data in file and add to the file without headers -> Enter 'add'\n" .
                    "Cancel - Enter 'cancel'\n";
                $error = 1;
                while ($error == 1) {
                    $read = new CommandExecute();
                    switch (strtolower(trim($read->read_from_cli()))) {
                        case "add":
                            $mode = "a";
                            $error = 0;
                            break;
                        case "overwrite":
                            $mode = "w";
                            $error = 0;
                            break;
                        case "cancel":
                            echo "ABORTING!\n";
                            exit;
                            break;
                        default:
                            echo "Command unclear. Check command and try again.\n";
                    }
                }
                echo "Thank you. Proceding further now... \n";
            }
        } else {
            $mode = 'w';
        }
        return $mode;
    }

}

