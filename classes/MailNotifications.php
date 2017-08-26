<?php
    class MailNotifications extends Entite{
        public function __construct(){
            $this->base = MySQL::getInstance();
            $this->dbtable = 'encart_pub_history';
        }
        public static function get($key, $wheres = null)
        {
           $base = MySQL::getInstance();
           $objEntite = new MailNotifications();
           $sql = 'SELECT * FROM `mail_notifications` WHERE `type_notification` = "'.$key.'" '.
           ($wheres ? ' AND '.$wheres : '');     
           return $base->query_array($sql);
        }
        public static function updateValue($key, $values, $html = false)
        {
             $objEntite = new MailNotifications();
            if (!is_array($values))
                $values = array($values);
            foreach ($values as $value)
            {
                $stored_value = self::get($key, "`value`='$value'" );
                
                // si cette entrée existe déjà, on meet à jour la ligne
                if(is_array($stored_value) && count($stored_value)){
                    $objEntite->Update(array('date_update' => date('Y-m-d H:i:s'), 'nb_notification'=>($stored_value['nb_notification'] + 1)), 'mail_notifications');
                }else{
                    $d = date('Y-m-d H:i:s');
                    $objEntite->InsertData(array('type_notification' => $key, 'value' => $value, 'date_add' => $d, 'date_update' => $d, 'nb_notification'=>($stored_value['nb_notification'] + 1)), 'mail_notifications');
                }
            }
        }
	
    }
?>
