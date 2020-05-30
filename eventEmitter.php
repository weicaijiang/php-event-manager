<?php
namespace event;

//是否开启匹配模式
// if(function_exists('FNMATCH')){
//     define('FNMATCH',true);
// }else{
//     define('FNMATCH',false);
// }

class EventEmmitter{

    
    // public static $instance = null;
    // /**
    //  *
    //  * @return EventManager
    //  */
    // public static function getInstance()
    // {
    //     if (!self::$instance) {
    //         self::$instance = new self();
    //     }

    //     return self::$instance;
    // }

    /**
     * @var array
     */
    protected $listeners = array();
    /**
     * fire event
     * @param string $event
     * @param mixed $args
     * @return int 触发次数
     */
    public function emit($event,$dataArr){
        $tempListeners = array();
        //删除一次性的
        $emittedCount = 0;
        // print_r($this->listeners[$event]);
        foreach($this->listeners[$event] as $name => $listener){
            //一次性
            if(1 == $listener['isOnce']){

            }else{
                $tempListeners[] = $listener;
            }
            // print_r($listener);
            //调用函数
            call_user_func($listener['callback'],$dataArr);
            ++$emittedCount;
        }
        $this->listeners[$event] = $tempListeners;
        return $emittedCount;
    }

    /**
     * attach a event listener
     * @param string $event
     * @param callback 
     */
    public function on($event, $callback){
        if(!isset($this->listeners[$event])){
            $this->listeners[$event] = array();
        }
        $listener = array(
            'isOnce'=>0,//不是一次性
            'callback'=>$callback,
        );
        // print_r($listener);
        array_push($this->listeners[$event], $listener);
    }

    /**
     * attach a event listener once
     * @param string $event
     * @param callback 
     */
    public function once($event, $callback){
        if(!isset($this->listeners[$event])){
            $this->listeners[$event] = array();
        }
        $listener = array(
            'isOnce'=>1,//一次性
            'callback'=>$callback,
        );
        // print_r($listener);
        array_push($this->listeners[$event], $listener);
    }

    /**
     * turn off event
     */
    public function off($event){
        if(isset($this->listeners[$event])){
            unset($this->listeners[$event]);
        }
    }

    /**
     * remove all event
     */
    public function removeAll(){
        $this->listeners = array();
    }

    /**
     * get listener
     */
    public function getListener(){
        return $this->listeners;
    }
}