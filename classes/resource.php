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

class Resource
{    
    public $id_resource;
    public $name;
    public $galaxy_name;
    public $enter_date;
    public $type_id;
    public $type_name;
    public $group_id;
    public $CR;
    public $CD;
    public $DR;
    public $FL;
    public $HR;
    public $MA;
    public $PE;
    public $OQ;
    public $SR;
    public $UT;
    public $ER;
    public $unavailable_date;
    public $planets;
    
    public $import_file = "https://galaxyharvester.net/exports/current118.csv";
    
    public $table = "resources";
    
    public static $definition = array(
        'table' => 'resources',
        'primary' => 'name',
    );
    
    public function __construct($name = null)
    {
        $this->database = new Db();
    }
    
   
    
    /**
     * 
     * @return array $group
     */
    public function getAllGroups()
    {        
        $group = array();
        
        $query = "SELECT DISTINCT group_id FROM ".$this->table;
        $data = $this->database->query($query)->fetchAll();
        
        if($data && count($data))
        {            
            
            $data = array_reverse($data);
            foreach($data as $key => $val)
            {
                $group[] = $val['group_id'];
            }
        }
        
        sort($group, SORT_NATURAL | SORT_FLAG_CASE);
        
        return  $group;
    }
    
    /**
     * 
     * @param string $name
     * @param int $id_parent
     * @return string
     */
    private function getCategoryByName($name, $id_parent)
    {
        $categoryClass = new Category();
        return $categoryClass->getCategoryByName($name, $id_parent);
    }
    
    /**
     * 
     * @param int $id_category
     * @param int $children
     * @param string $recursive
     */
    protected function getCategoryChildren($id_category, &$children, $recursive = false)
    {
        $query = 'SELECT id_category FROM category WHERE id_parent = '.$id_category;
        $id_children = $this->database->query($query)->fetchAll();
        
        if(count($id_children) > 0 )
        {
            foreach($id_children as $k => $child)
            {
                $children = array_merge($children, array($child['id_category']));
                
                if($recursive === true)
                    $this->getCategoryChildren($child['id_category'], $children, $recursive);
            }
            
        }
    }
    
    /**
     * 
     * @param int $group
     * @param int $active
     * @return array
     */
    public function getGroup($group, $active = 1)
    {        
        $db = new db();
        $query = 'SELECT name, type_name, CR, CD, DR, FL, HR, MA, PE, OQ, SR, UT, ER, enter_date
                  FROM '.$this->table.'
                  WHERE group_id = "'.$group.'"
                  AND active = '.$active;
            
        $resources =  $db->query($query)->fetchAll();
        if(is_array($resources) && count($resources))
        {
            $this->prepareDataForTable($resources);
        }
        
        return $resources;  
    }
    
    /**
     *
     * @param string $resource
     * @return array
     */
    public function getPlanets($resource)
    {
        $this->database = new db();
        $planets = array();
        
        $query = 'SELECT planets FROM '.$this->table.' WHERE name ="'.$resource.'"';
        $data = $this->database->query($query)->fetchAll();
        
        if($data && is_array($data) && count($data))
            $planets = explode('|', $data[0]['planets']);
            
            return $planets;
    }
    
    /**
     * 
     * @param unknown $id_category
     * @param number $active
     * @return array
     */
    public function getResources($id_category, $active = 1)
    {
        $id_resource = Category::getCategoryResourceAsso($id_category);
        
        $query = '  SELECT name, type_name, CR, CD, DR, FL, HR, MA, PE, OQ, SR, UT, ER, enter_date
                    FROM '.$this->table.'
                    WHERE type_id = (SELECT type_id
                                     FROM category_resource
                                     WHERE id_category = '.(int)$id_category.')
                    AND active = '.$active;
        
        // print_r($query);die;
        $resources = $this->database->query($query)->fetchAll();
        
        if(is_array($resources) && count($resources))
        {
            $this->prepareDataForTable($resources);
        }
        
        return $resources;
    }
    
    /**
     * 
     * @param int $id_category
     * @param bool $recursive
     * @param int $active
     * @return number
     */
    public function getResourcesCount($id_category, $recursive = true, $active = 1)
    {
        $id_children = array();
        $this->getCategoryChildren($id_category, $id_children, true);
        
        array_unique($id_children);
        
        if($recursive === true && count($id_children) > 1 ){
            $query = 'SELECT id_resource
                      FROM '.$this->table.'
                      WHERE type_id IN(
                        SELECT type_id
                        FROM category_resource
                        WHERE id_category IN ('.implode(',', $id_children).'))
                      AND active = '.$active;
        }else{
            $query = 'SELECT id_resource
                      FROM '.$this->table.'
                      WHERE type_id = (
                        SELECT type_id
                        FROM category_resource
                        WHERE id_category = '.$id_category.')
                      AND active = '.$active;
        }
        
        return $this->database->query($query)->rowCount();
    }
    
    /**
     * 
     * @param array $resources
     */
    public function prepareDataForTable(&$resources)
    {
        foreach($resources as $key => $data)
        {
            // Spawn Age
            $date = new DateTime($data['enter_date']);
            $now = new DateTime('Now');
            $diff = $now->diff($date)->format('%d day(s)');
            $resources[$key]["enter_date"] = $diff;
            
            // Name with link
            $name = $data['name'];
            $name_link = '<a href="https://galaxyharvester.net/resource.py/118/'.$name.'" target="_blank" data-name="'.$name.'" class="res-link text-capitalize">'.$name.'</a>';
            $resources[$key]["name"] = $name_link;
            
            // Planet Link
            $planet = '<a href="javascript:void(0)" class="planet-button"  data-bs-toggle="modal"  data-bs-resource="'.$name.'" data-bs-target="#planetModal">
                        <i class="fas fa-globe"></i>
                       </a>';
            $resources[$key]["planet"] = $planet;
            
            $excluded_fields = array('name', 'type_name', 'enter_date', 'planet');
            foreach($data as $key2 => $value)
            {
                if($value == 0 && !in_array($key2, $excluded_fields)){
                    $resources[$key][$key2] = "-";
                }
            }
            
        }
    }
    
    public function updateResources()
    {        
        $handle = fopen($this->import_file,"r");
        $flag = true;
        $resourcesFeed = array();

        $query = 'INSERT IGNORE INTO '.$this->table.' (name, galaxy_id, galaxy_name, enter_date, type_id, type_name, group_id, CR, CD, DR, FL, HR, MA, PE, OQ, SR, UT, ER, unavailable_date, planets) VALUES';
        $query2 = 'INSERT IGNORE INTO resources_all (name, galaxy_id, galaxy_name, enter_date, type_id, type_name, group_id, CR, CD, DR, FL, HR, MA, PE, OQ, SR, UT, ER, unavailable_date, planets) VALUES';
        
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if($flag){
                $flag = false; continue;
            }
            
            $resourcesFeed[] = $data[0];
            $query .= "('".$data[0]."', '".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."', '".$data[13]."','".$data[14]."','".$data[15]."','".$data[16]."','".$data[17]."','".$data[18]."', '".$data[19]."'),";
            $query2 .= "('".$data[0]."', '".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."', '".$data[13]."','".$data[14]."','".$data[15]."','".$data[16]."','".$data[17]."','".$data[18]."', '".$data[19]."'),";
        }
        
        $query = substr($query, 0, -1);
        $query2 = substr($query2, 0, -1);
        
        $res =  $this->database->query($query)->execute();
        $res2 =  $this->database->query($query2)->execute(); // Table for backup with all resources
        
        $query = 'SELECT id_resource, name FROM '.$this->table.' WHERE name NOT IN('."'" . implode("','", $resourcesFeed) . "'".')';
        
        $disable = $this->database->query($query)->fetchAll();
        
        if(is_array($disable) && count($disable))
        {
            foreach($disable as $del)
            {
                //$this->addToUnavailable($del['id_resource']);
                $this->disableResource($del["name"]);
            }
        }
        
        $this->setCategoryResourceAssoc();
        
        echo "Resources updated successfuly.";
    }
    
    /**
     * Used to match resource type with category tree table.
     */
    public function setCategoryResourceAssoc()
    {
        $query = 'SELECT * FROM '.$this->table;
        $resources =  $this->database->query($query)->fetchAll();
       
        foreach($resources as $key => $res)
        {
            $type = explode('_', $res['type_id']);

            $id = false; 
            $count = count($type);
            
            for($i = 0; $i < $count; $i++)
            {
                $id = $this->getCategoryByName($type[$i], $id);
            }
            
            $id = (int) $id;
            if($id > 0 && $id !== null)
            {
                $query = 'INSERT IGNORE INTO category_resource (id_category, id_resource, type_id)
                          VALUES('.$id.', '.$res['id_resource'].', "'.$res['type_id'].'")';
                
                $this->database->query($query)->execute();
            }
        }
    }    
    
    
    
    
    
    
    public function disableResource($resource)
    {
        $this->database->query('UPDATE '.$this->table.' SET active = 0 WHERE name = "'.$resource.'"')->execute();
    }
    
    
    /**
     *
     * @param int $group
     * @param int $active
     * @return array
     * @deprecated
     */
    public function getGroup2($group, $active = 1)
    {
        $db = new db();
        $query = 'SELECT name, type_name, CR, CD, DR, FL, HR, MA, PE, OQ, SR, UT, ER, enter_date
                  FROM '.$this->table.'
                  WHERE group_id = "'.$group.'"
                  AND active = '.$active;
        
        return $db->query($query)->fetchAll($query);
    }
    
    /**
     * @deprecated
     */
    public function getResourcesByPlanet()
    {
        $res =  $this->database->query("SELECT * FROM ".$this->table);
        $data = $res->fetchAll();
    }
    
    /**
     *
     * @param unknown $id_resource
     * @deprecated
     */
    public function addToUnavailable($id_resource)
    {
        $this->database->query('INSERT INTO '.$this->table.' (id_resource) VALUES('.$id_resource.')')->execute();
    }
}

?>