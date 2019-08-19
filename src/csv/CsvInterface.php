<?php namespace RemigiuszMachulaRekrutacjaHRtec\src\csv;

use RemigiuszMachulaRekrutacjaHRtec\src\entity\Command;

interface CsvInterface
{

    public function check_csv_file(Command $command);

}