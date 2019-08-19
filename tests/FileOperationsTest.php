<?php namespace RemigiuszMachulaRekrutacjaHRtec\tests;

use RemigiuszMachulaRekrutacjaHRtec\src\FileOperations;

class FileOperationsTest extends \PHPUnit_Framework_TestCase
{

    public function testCheckDataInFile(){

        $file_operations = new FileOperations();

        $this->assertTrue($file_operations ->check_data_in_file(__DIR__.'/csv/test1.csv'));
        $this->assertFalse($file_operations ->check_data_in_file(__DIR__.'/csv/test2.csv'));
        $this->assertFalse($file_operations ->check_data_in_file(__DIR__.'/csv/test3.csv'));
        $this->assertFalse($file_operations ->check_data_in_file(__DIR__.'/csv/test4.csv'));
        $this->assertFalse($file_operations ->check_data_in_file(__DIR__.'/csv/test5.csv'));
        $this->assertFalse($file_operations ->check_data_in_file(__DIR__.'/csv/test6.csv'));
        $this->assertFalse($file_operations ->check_data_in_file(__DIR__.'/csv/test7.csv'));
    }

    public function testIsFilePath(){

        $file_operations = new FileOperations();

        $this->assertTrue($file_operations->is_filepath('aa.csv'));
        $this->assertTrue($file_operations->is_filepath('aa/a.csv'));
        $this->assertFalse($file_operations->is_filepath('aa'));
        $this->assertFalse($file_operations->is_filepath('aa.cs'));
        $this->assertTrue($file_operations->is_filepath('C:\xampp\htdocs\RemigiuszMachulaRekrutacjaHRtec/simple_exports.csv'));
        $this->assertTrue($file_operations->is_filepath('/RemigiuszMachulaRekrutacjaHRtec/simple_exports/.csv'));
        $this->assertTrue($file_operations->is_filepath('/simple_exports/.csv'));
        $this->assertFalse($file_operations->is_filepath('/?/.csv'));
    }


    public function testIncorrectURLDownloadXML(){
        $url1 = 'http://www.google.pl';
        $url2 = '';
        $urls = [$url1, $url2];

        $stub = new class () extends FileOperations
        {
            protected function terminate($message = '')
            {
                return false;
            }
        };

        foreach ($urls as $url) {
            $xml = $stub->download_xml($url);

            if ($xml) {
                $xml = true;
            }
            $this->assertFalse($xml);
        }
    }

    //testowy url pusty?
    public function testCorrectURLDownloadXML(){
        $url1 = 'http://feeds.nationalgeographic.com/ng/News/News_Main';
        $url2 = 'http://feeds.nationalgeographic.com/ng/News/News_Main';

        $urls = [$url1, $url2];

        $stub = new class () extends FileOperations
        {
            protected function terminate($message = '')
            {
                return false;
            }
        };

        foreach ($urls as $url) {
            $xml = $stub->download_xml($url);

            if ($xml) {
                $xml = true;
            }
            $this->assertTrue($xml);
        }
    }

}
