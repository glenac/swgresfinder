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
    
    public $table = "resources_dev";
    
    public static $definition = array(
        'table' => 'resources_dev',
        'primary' => 'name',
    );
    
    public function __construct($name = null)
    {
        $this->database = new Db();
    }
    
    public function getResourcesByPlanet()
    {
        $res =  $this->database->query("SELECT * FROM ".$this->table);
        $data = $res->fetchAll();        
    }
    
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
    
    public function getGroup($group)
    {        
        $db = new db();
        $query = 'SELECT name, type_name, CR, CD, DR, FL, HR, MA, PE, OQ, SR, UT, ER, enter_date
                  FROM '.$this->table.'
                  WHERE group_id = "'.$group.'"';
            
        $resources =  $db->query($query)->fetchAll();
        if(is_array($resources) && count($resources))
        {
            $this->prepareDataForTable($resources);
        }
        
        return $resources;
  
    }
    
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
                //   print_r($key2);die;
                if($value == 0 && !in_array($key2, $excluded_fields)){
                    $resources[$key][$key2] = "-";
                }
                
                /*  if($value >= 900){
                 $resources[$key][$key2] = '<span class="text-red">'.$value.'</span>';
                 }else{
                 $resources[$key][$key2] = '<span class="">'.$value.'</span>';
                 }*/
            }
            
            // print_r($re)
            // Resource 0 set to "-"
            //  if($data == 0)
            //     $resources[$key][$data]
        }
    }
    
    public function getGroup2($group)
    {        
        $db = new db();
        $query = 'SELECT name, type_name, CR, CD, DR, FL, HR, MA, PE, OQ, SR, UT, ER, enter_date
                  FROM '.$this->table.'
                  WHERE group_id = "'.$group.'"';
            
        return $db->query($query)->fetchAll($query);
        
    }
    
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
    
    public function updateResources()
    {
      
        $file = "https://galaxyharvester.net/exports/current118.csv";     
        $handle = fopen($file,"r");        
        $flag = true; 
        $resourcesFeed = array();
        
        $query = 'INSERT IGNORE INTO '.$this->table.' (name, galaxy_id, galaxy_name, enter_date, type_id, type_name, group_id, CR, CD, DR, FL, HR, MA, PE, OQ, SR, UT, ER, unavailable_date, planets) VALUES';
        
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            $resourcesFeed[] = $data[0]; 
            if($flag) { $flag = false; continue; }
            $query .= "('".$data[0]."', '".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."', '".$data[13]."','".$data[14]."','".$data[15]."','".$data[16]."','".$data[17]."','".$data[18]."', '".$data[19]."'),";     
        }
        
        $query = substr($query, 0, -1);
        $res =  $this->database->query($query);        
     
        $query = 'SELECT name FROM '.$this->table.' WHERE name NOT IN('."'" . implode("','", $resourcesFeed) . "'".')';
      
        $delete = $this->database->query($query)->fetchAll();
           
        if(is_array($delete) && count($delete))
        {
            foreach($delete as $del)
            {
                $this->deleteResource($del["name"]);
            }
        }
        
        echo "Resources updated successfuly.";
    }
    
    public function deleteResource($resource)
    {
        $this->database->query('DELETE FROM '.$this->table.' WHERE name = "'.$resource.'"');
    }
    
    public function getResources($id_category)
    {
        $id_resource = Category::getCategoryResourceAsso($id_category);
        
        $query = '  SELECT name, type_name, CR, CD, DR, FL, HR, MA, PE, OQ, SR, UT, ER, enter_date
                    FROM '.$this->table.'
                    WHERE type_id = (SELECT type_id
                                     FROM category_resource
                                     WHERE id_category = '.(int)$id_category.')';
        
       // print_r($query);die;
        $resources = $this->database->query($query)->fetchAll();
        
        if(is_array($resources) && count($resources))
        {
            $this->prepareDataForTable($resources);
        }
        
        return $resources;
    }
    
    public function categoryResourceAssoc()
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
            
            if(is_int($id) && $id > 0 && $id !== null)
            {
                var_dump($id);
                var_dump($res['id_resource']);
                var_dump($res['type_id']);
                $query = 'INSERT IGNORE INTO category_resource (id_category, id_resource, type_id)
                          VALUES('.$id.', '.$res['id_resource'].', "'.$res['type_id'].'")';
                $this->database->query($query)->execute();
            }
           // var_dump($id);die;
        }
    }
    
    private function getCategoryByName($name, $id_parent)
    {
        $categoryClass = new Category();
        return $categoryClass->getCategoryByName($name, $id_parent);
    }
    
    public  function getResourcesCount($id_category, $recursive = true)
    {
        $id_children = array();
        $this->getCategoryChildren($id_category, $id_children, true);
        
        array_unique($id_children);      
        
        if($recursive === true && count($id_children) > 1 ){
            $query = 'SELECT id_resource FROM '.$this->table.' WHERE type_id IN(
                        SELECT type_id FROM category_resource WHERE id_category IN ('.implode(',', $id_children).'))';
        }else{
            $query = 'SELECT id_resource FROM '.$this->table.' WHERE type_id = (
                SELECT type_id FROM category_resource WHERE id_category = '.$id_category.')';
        }
        
      // print_r($query);die;
        //print_r( $this->database->query($query)->rowCount());die;
        return $this->database->query($query)->rowCount();       
    }
    
    protected function getCategoryChildren($id_category, &$children, $recursive = false)
    {        
        $query = 'SELECT id_category FROM ps_category WHERE id_parent = '.$id_category;
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
    
   
}

?>