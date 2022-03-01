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
        $dsn = "mysql:host=DB_HOST;dbname=DB_NAME";
        $user = "DB_USER";
        $passwd = "DB_PASSWORD";
        
        parent::__construct($dsn, $user, $passwd);
    }
}

?>