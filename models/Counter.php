<?php
require_once '\..\php-activerecord\ActiveRecord.php';
/**
 *
 * @property int $emails_sent
 */
class Counter extends ActiveRecord\Model {

    static function incEmailsCount(){
        $counters = Counter::find('first');

        if($counters){
            $counters->emails_sent = $counters->emails_sent + 1;
        } else {
            $counters = new Counter();
        }
        $counters->save();
    }

    static function getEmailsCount(){
        $counters = Counter::find('first');
        if(!$counters){
            $counters = new Counter();
            $counters->save();
        }
        return $counters->emails_sent;
    }
}