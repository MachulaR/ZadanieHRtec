<?php namespace RemigiuszMachulaRekrutacjaHRtec\src;

const HEADLINES = ['title', 'description', 'link', 'pubDate', 'creator'];

class FileOperations
{

    public function check_data_in_file($path){
        $f = fopen($path, 'r');
        $first_line_in_file = fgets($f);
        $first_line_in_file = trim($first_line_in_file);
        fclose($f);

        $first_line = '';
        foreach (HEADLINES as $headline){
            $first_line .=$headline.',';
        }
        $first_line = rtrim($first_line,',');

        return ($first_line_in_file == $first_line);
    }

    public function save_to_file($path, $list, $mode)
    {
        if($mode == 'w'){
            array_unshift($list, HEADLINES);
        }

        $fp = fopen($path, $mode);

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }

    public function download_xml($url){
        $xml = @simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOWARNING);
        if (false === $xml) {
            $this->terminate('Failed during connecting. Check your URL and try again.');
        }
        return $xml;
    }

    public function prepare_data_from_xml($xml)
    {
        $list = [];
        foreach ($xml->channel->item as $item) {
            $tmp_array = [];
            array_push($tmp_array, (isset($item->title) ? $item->title : 'NOT EXIST'));
            array_push($tmp_array, (isset($item->description) ? trim(strip_tags($item->description)) : 'NOT EXIST'));
            array_push($tmp_array, (isset($item->link) ? $item->link : 'NOT EXIST'));
            $time = strtotime( (string)($item->pubDate) );
            array_push($tmp_array, (isset($item->pubDate) ? $this->PLStrftime('%d %F %Y %T', $time) : 'NOT EXIST'));
            array_push($tmp_array, (isset($item->creator) ? $item->creator : 'NOT EXIST'));

            $list[] = $tmp_array;
        }
        return $list;
    }

    public function check_path($path)
    {
        $dirname = dirname($path);
        if (!is_dir($dirname)) {
            echo "The folder(s) not exist. Create them? (yes/no) \n";
            $error = 1;
            while ($error == 1) {
                $read = new CommandExecute();
                switch (trim($read->read_from_cli())) {
                    case "yes":
                        mkdir($dirname, 0755, true);
                        $error = 0;
                        break;
                    case "no":
                        echo "ABORTING!\n";
                        exit;
                        break;
                    default:
                        echo "Command unclear. Check command and try again.\n";
                }
            }
            echo "Thank you. Proceeding further now... \n";
        }
    }

    public function is_filepath($path)
    {
        $path = trim($path);

        $file_parts = pathinfo($path);
        if (!array_key_exists('extension', $file_parts)) {
            return false;
        } else if (empty($file_parts['extension'])) {
            return false;
        } else if ($file_parts['extension'] != 'csv') {
            echo "Invalid file extension. We only support: .csv";
            return false;
        }

        if (!defined('WINDOWS_SERVER')) {
            $tmp = dirname(__FILE__);
            if (strpos($tmp, '/', 0) !== false) define('WINDOWS_SERVER', false);
            else define('WINDOWS_SERVER', true);
        }

        if (preg_match('/^[^*?"<>|:]*$/', $path)) return true; // good to go

        if (WINDOWS_SERVER) {
            if (strpos($path, ":") == 1 && preg_match('/[a-zA-Z]/', $path[0])) {
                $tmp = substr($path, 2);
                $bool = preg_match('/^[^*?"<>|:]*$/', $tmp);
                return ($bool == 1);
            }
            return false;
        }
        return false;
    }

    private function PLStrftime($format, $timestamp = 0)
    {

        if ($timestamp == 0) {
            $timestamp = time();
        }

        if (strpos($format, '%F') !== false) {
            $mies = date('m', $timestamp);

            switch ($mies) {
                case 1:
                    $mies = 'stycznia';
                    break;
                case 2:
                    $mies = 'lutego';
                    break;
                case 3:
                    $mies = 'marca';
                    break;
                case 4:
                    $mies = 'kwietnia';
                    break;
                case 5:
                    $mies = 'maja';
                    break;
                case 6:
                    $mies = 'czerwca';
                    break;
                case 7:
                    $mies = 'lipca';
                    break;
                case 8:
                    $mies = 'sierpnia';
                    break;
                case 9:
                    $mies = 'września';
                    break;
                case 10:
                    $mies = 'października';
                    break;
                case 11:
                    $mies = 'listopada';
                    break;
                case 12:
                    $mies = 'grudnia';
                    break;
            }
            return strftime(str_replace('%F', $mies, $format), $timestamp);
        }
        return strftime($format, $timestamp);
    }

    protected function terminate($message = '')
    {
        die($message);
    }
}