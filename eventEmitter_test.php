<?php
require_once "eventEmitter.php";

use event\EventEmmitter;

class Room{
    public function userInhome($data){
        print_r("class Room event userInhome data:".$data.PHP_EOL);
    }
    public function __invoke($data){
        print_r("class Room event __invoke data:".$data.PHP_EOL);
    }
    public static function roomInfo($data){
        print_r("class Room event roomInfo data:".$data.PHP_EOL);
    }
    public function userOutHome($data){
        print_r("class Room event userOutHome data:".$data.PHP_EOL);
    }
}

function messageEvent1($data){
    print_r("messageEvent1 data:".$data.PHP_EOL);
}

function messageEvent2($data){
    print_r("messageEvent2 data:".$data.PHP_EOL);
}

$eventManger = new EventEmmitter();
$room = new Room();
// $room->userInhome("before");
// $eventManger->on("test",call_user_func(array($room,"userInhome")));
$eventManger->on("test",array($room,"userInhome"));
$eventManger->on("test",array($room,"userOutHome"));
$eventManger->on("test","Room::roomInfo");

$eventManger->on("test",'messageEvent1');
$eventManger->once("test",'messageEvent2');

$clourse1 = function($data){
    print_r("clourse1 data:".$data.PHP_EOL);
};

$clourse2 = function($data){
    print_r("clourse2 data:".$data.PHP_EOL);
};

$eventManger->on("test",$clourse1);
$eventManger->once("test",$clourse2);

$eventManger->emit("test"," first");
$eventManger->emit("test"," second");