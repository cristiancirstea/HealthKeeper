<?php

include_once './API.php';
// require_once './library/DBClass.php';
require_once './library/phputil/db_connect.php';
require_once './Security.php';

/**
 * Check string for Firebird.
 * 
 * <em>For now only commas</em>
 * 
 * @param String $str 
 * 
 * @return String 
 */
function FBCheckString($str) {
    $result=str_replace("'", "''", $str);

    return $result;
}

function ArrayKey($key, $array, $defValue) {
    if (array_key_exists($key, $array)) {
        return $array[$key];
    } else {
        return $defValue;
    }
}

function MyFormatFloat($aFloat, $decimals = 2, $dec_point = '.', $thousands_sep = ',') {
    return number_format($aFloat, $decimals, $dec_point, $thousands_sep);
}

function MyFormatDate($aDateString, $format='d.m.Y') /* 'H:i' - pt ora*/ {
    $aDate=new DateTime('' . $aDateString);
    return $aDate->format($format);
}

class MyAPI extends API {
    protected $DEBUG = true;
    protected $User;
    protected $_goodUser;
    protected $_userID;
    protected $_adminRights;
    protected $noKeyMethods = array('login', 'logout', 'test_connection');

    public function __construct($request, $origin) {
    parent::__construct($request);
    $this->_goodUser = false;
    $this->_userID = 0;
    $this->_adminRights = false;

    if (strtoupper($this->method) == "PUT" || strtoupper($this->method) == "DELETE") {
        if (!$this->request) {
            $this->request = array();
        }
        //var_export($this->request);
        //PUT params are considered in JSON format!!! 
        $putParams = json_decode($this->file,1);
        //$this->request=array_merge( $this->request,$putParams);
        unset($putParams);
    }

    if (!$this->DEBUG) {
    }
  }
    
  /**
   * Endpoints: /@method_name (".../service/@method_name[/@argument1/@argument2...][?param_request=val_param_request...]")
   */

    /**
     * Funcția înregistrează un utilizator nou pe baza unui email și a unei
     * parole. În cazul în care mailul este deja înregistrat, refuză.
     */
    protected function registerNewUser($email, $firstName, $lastName, $password) {
        // Verifica daca mailul a fost inregistrat
        $cred = ORM::for_table('Credentials')->where('email', $email)
                                             ->find_one();

        // Daca nu a fost, il inregistreaza pentru un utilizator nou
        if(!$cred) {
            $user = ORM::for_table('Users')->create();
            $user->firstName = $firstName;
            $user->lastName = $lastName;
            $user->save();

            // al carui id unic il preia
            $user = ORM::for_table('Users')->order_by_desc('user_id')
                                           ->where('firstName', $firstName)
                                           ->where('lastName', $lastName)
                                           ->find_one();

            // si-l asociaza mailului                               
            $cred = ORM::for_table('Credentials')->create();
            $cred->email = $email;
            $cred->user_id = $user->user_id;
            $cred->password = md5($password . 'HealthR0bots');
            $cred->save();

            return 'success';
        } else {
            return 'already';
        }
    }

    protected function isGPFree($email, $date) {
        $gp = ORM::for_table('GPSchedule')->raw_query('select * from GPSchedule where date = CURDATE() and email = "' . $email . '"')
                                          ->find_one();
        $i = 1;
        $free = array();
        if($gp) {
            $free[] = array('text' => 'De la 8 la 9', 'liber' => $gp->f8t9);
            $free[] = array('text' => 'De la 9 la 10', 'liber' => $gp->f9t10);
            $free[] = array('text' => 'De la 10 la 11', 'liber' => $gp->f10t11);
            $free[] = array('text' => 'De la 11 la 12', 'liber' => $gp->f11t12);
            $free[] = array('text' => 'De la 12 la 13', 'liber' => $gp->f12t13);
            $free[] = array('text' => 'De la 13 la 14', 'liber' => $gp->f13t14);
            $free[] = array('text' => 'De la 14 la 15', 'liber' => $gp->f14t15);
            $free[] = array('text' => 'De la 15 la 16', 'liber' => $gp->f15t16);
            $free[] = array('text' => 'De la 16 la 17', 'liber' => $gp->f16t17);
            $free[] = array('text' => 'De la 17 la 18', 'liber' => $gp->f17t18);
        }

        return $free;
    }

    protected function scheduleMyGP($myEmail, $GPEmail, $when) {
        $gp = ORM::for_table('GPSchedule')->raw_query('select * from GPSchedule where date = CURDATE() and email = "' . $GPEmail . '"');
        $cd = ORM::for_table('Credentials')->where('email', $myEmail);
        $user = ORM::for_table('UsersSchedule')->where('user_id', $cd->user_id)
                                               ->find_one();

        switch ($when) {
            case 1:
                $gp->f8t9 = 0;
                $user->f8t9 = 0;
                break;

            case 2:
                $gp->f9t10 = 0;
                $user->f9t10 = 0;
                break;

            case 3:
                $gp->f10t11 = 0;
                $user->f10t11 = 0;
                break;

            case 4:
                $gp->f11t12 = 0;
                $user->f11t12 = 0;
                break;

            case 5:
                $gp->f12t13 = 0;
                $user->f12t13 = 0;
                break;

            case 6:
                $gp->f13t14 = 0;
                $user->f13t14 = 0;
                break;

            case 7:
                $gp->f14t15 = 0;
                $user->f14t15 = 0;
                break;
            
            case 8:
                $gp->f15t16 = 0;
                $user->f15t16 = 0;
                break;

            case 9:
                $gp->f16t17 = 0;
                $user->f16t17 = 0;
                break;

            case 10:
                $gp->f17t18 = 0;
                $user->f17t18 = 0;
                break;

            default:
            return 'unsuccessfull';
                break;

            return 'successful';
        }
    }
}
?>
