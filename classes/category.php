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
   
    public $table = "category";
    
    public $planets = array(
        0 => "Corellian",
        1 => "Dantooine",
        2 => "Dathomirian",
        3 => "Endorian",
        4 => "Lokian",
        5 => "Nabooian",
        6 => "Rori",
        7 => "Talusian",
        8 => "Tatooinian",
        9 => "Yavinian",
    );
    
    public static $definition = array(
        'table' => 'category',
        'primary' => 'id_category',
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
                     FROM category
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
                  FROM category c
                  LEFT JOIN category_lang cl ON (c.id_category = cl.id_category)  
                  WHERE cl.name = "'.$name.'"';
        
        if($id_parent){
            $query .= ' AND c.id_parent = '.$id_parent;
        }
        
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
    
    public function setPlanetforCategories($id_parent)
    {
        die;
        $query = 'SELECT id_category, level_depth FROM category WHERE id_parent = '.$id_parent;
        
        $Db = new Db();
        $categories =  $Db->query($query)->fetchAll();
        
        print_r($id_parent.'<br>');
        
        foreach($categories as $key => $category)
        {
            $cats = $this->getCategoriesFromParent($category['id_category']);
           // print_r($cats);die;
            if(count($cats) > 0){
                $this->setPlanetforCategories($category['id_category']);
            }else{
               
                $position = 1;
                $depth = $category['level_depth']+1;
                $dateNow = new DateTime('Now');
                $dateNow = $dateNow->format('Y-m-d H:i');

                foreach($this->planets as $key => $planet)
                {                    
                    $sql = 'INSERT INTO category (id_parent, id_shop_default, level_depth, nleft, nright, active, date_add, date_upd, position, is_root_category)
                        VALUES('.$category['id_category'].', 1, '.$depth.', 0, 0 ,1, "'.$dateNow.'", "'.$dateNow.'", '.$position.', 0)';
                    $Db->query($sql);
                    
                    // var_dump($sql);die;
                    $last_id = $Db->lastInsertId();
                    $position++;
                    
                    $sql2 = 'INSERT INTO category_lang (id_category, id_shop, id_lang, name, description, link_rewrite, meta_title, meta_keywords, meta_description)
                        VALUES('.$last_id.', 1, 1, "'.$planet.'", "", "'.$planet.'", "","","")';                      
                   // var_dump($sql2);die;
                    $Db->query($sql2)->execute();     
                }       
            }
            
           // $this->setPlanetforCategories($category['id_category']);
        }
        
    }
    
    public function getCategoriesFromParent($id_parent)
    {
        $query = 'SELECT id_category, level_depth FROM category WHERE id_parent = '.$id_parent;
        $Db = new Db();
        return $Db->query($query)->fetchAll();
    }
}

?>