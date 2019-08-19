<?php namespace RemigiuszMachulaRekrutacjaHRtec\tests;


use CommandExecute;
use RemigiuszMachulaRekrutacjaHRtec\src\entity\Command;

class CommandExecuteTest extends \PHPUnit_Framework_TestCase
{

    public function testIsCommandCorrect(){

        $goodCommand1 = new Command();
        $goodCommand1->setLength(4);
        $goodCommand1->setUrl('http://feeds.nationalgeographic.com/ng/News/News_Main');
        $goodCommand1->setCommand('csv:simple');
        $goodCommand1->setPath('simple_export.csv');

        $goodCommand2 = new Command();
        $goodCommand2->setLength(4);
        $goodCommand2->setUrl('http://feeds.nationalgeographic.com/ng/News/News_Main');
        $goodCommand2->setCommand('csv:extended');
        $goodCommand2->setPath('simple_export.csv');

        $badCommand1 = new Command();
        $badCommand1->setLength(4);
        $badCommand1->setUrl('http://feeds.nationalgeographic.com/ng/News/News_Main');
        $badCommand1->setCommand('csv:dsf');
        $badCommand1->setPath('simple_export.csv');

        $badCommand2 = new Command();
        $badCommand2->setLength(1);
        $badCommand2->setUrl('http://feeds.nationalgeographic.com/ng/News/News_Main');
        $badCommand2->setCommand('csv:simple');
        $badCommand2->setPath('simple_export.csv');

        $badCommand3 = new Command();
        $badCommand3->setLength(4);
        $badCommand3->setUrl('http://feeds.nationalgeographic.com/ng/News/News_Main');
        $badCommand3->setCommand('csv:simple');
        $badCommand3->setPath('simple_export');

        $badCommand4 = new Command();
        $badCommand4->setLength(4);
        $badCommand4->setUrl('sdfsdf');
        $badCommand4->setCommand('csv:simple');
        $badCommand4->setPath('simple_export.csv');

        $goodCommands = [$goodCommand1, $goodCommand2];
        $badCommands = [$badCommand1, $badCommand2, $badCommand3, $badCommand4];

        foreach ($goodCommands as $command) {
            $console = new CommandExecute();
            $result = $console->is_command_correct($command);
            $this->assertTrue($result);
        }
        foreach ($badCommands as $command) {
            $console = new CommandExecute();
            $result = $console->is_command_correct($command);
            $this->assertFalse($result);
        }
    }
}
