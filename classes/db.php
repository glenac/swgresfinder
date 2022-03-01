<?php

/**===================================
 * ===================================
 * ==                               ==
 * ==      SWG Resource Finder      ==
 * ==                               ==
 * =================================== 
 * 
 * @author: Glenac
 * @contact: contact@swgresfinder.com
 * 
 * This program is free software: you can redistribute it and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 */

class Db Extends PDO
{    
    public function __construct()
    {
        $dsn = "mysql:host=front-ha-mysql-01.shpv.fr:3306;dbname=xzyrsuml_resources";
        $user = "xzyrsuml_resources";
        $passwd = "b9+hps7G#Mcc";
        
        parent::__construct($dsn, $user, $passwd);
    }
}

?>