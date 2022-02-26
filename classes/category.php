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
class Category
{    
    public $id_category;
    public $id_parent;
    public $level_depth;
    public $nleft;
    public $nright;
    public $position;
    public $is_root_category;
    public $name;
   
    public $table = "ps_category";
    
    public static $definition = array(
        'table' => 'category',
        'primary' => '$id_category',
    );
    
    public function __construct($name = null)
    {
        $this->database = new db();
    }
    
    public function getAllcategories()
    {
        $query = 'SELECT c.*, cn.*
                  FROM '.$this->table.' c
                  LEFT JOIN '.$this->table.'_name cn ON (c.id_category = cn.id_category)';
        
        $categories =  $this->database->query($query)->fetchAll();
        
        return $categories;
    }   
    
    public function getCategoriesByDepth($level = 2, $id_parent = false)
    {
        $query = 'SELECT c.*, cn.* ,
                    (SELECT COUNT(id_category) as count
                     FROM ps_category
                     WHERE id_parent=c.id_category) as children
                  FROM '.$this->table.' c
                  LEFT JOIN '.$this->table.'_lang cn ON (c.id_category = cn.id_category)
                  WHERE c.level_depth = '.(int)$level;
        
        if($id_parent){
            $query .= ' AND c.id_parent = '.$id_parent;
        }
        
        $categories =  $this->database->query($query)->fetchAll();
        
        return $categories;
    }
    
    public function countChildrenCategories($id_parent)
    {
        $query = 'SELECT id_category
                  FROM '.$this->table.'                 
                  WHERE id_parent = '.(int)$id_parent;     
        
        return $this->database->query($query)->rowCount();
    }
    
    public function getCategoryByName($name, $id_parent = false)
    {
        $query = 'SELECT c.id_category
                  FROM ps_category c
                  LEFT JOIN ps_category_lang cl ON (c.id_category = cl.id_category)  
                  WHERE cl.name = "'.$name.'"';
        
        if($id_parent){
            $query .= ' AND c.id_parent = '.$id_parent;
        }
        
       // print_r($query);
        return $this->database->query($query)->fetch()['id_category'];        
    }
    
    public static function getCategoryResourceAsso($id, $type = 'id_category'){
        if($type == "id_category"){
            $select = 'id_resource';
        }elseif($type == 'id_resource'){
            $select = 'id_category';
        }
        $query = 'SELECT '.$select.' FROM category_resource WHERE '.$type.'='.$id;
        
        $Db = new Db();
        return $Db->query($query)->fetch()[$select];;
    }
}

?>