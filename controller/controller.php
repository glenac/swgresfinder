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

include_once '../classes/db.php';
include_once '../classes/resource.php';
include_once '../classes/category.php';

define('__Secure_Key__', "QZGG7K0Adw");

$option = $_GET['action'];

switch($option){
    case "update" :
        updateResources();
        break;
    case "getGroup" :
        getGroup();
        break;    
   case "getPlanet" :
       getPlanet();
       break;
   case "getCategories" :
       getCategories();
       break;
   case "countChildrenCategories" :
       countChildrenCategories();
       break;
   case "formatData" :
       formatData();
       break;
   case "getResources" :
       getResources();
       break;
   case "getResourcesCount" :
       getResourcesCount();
       break;
    
}

function updateResources()
{
    //$secure_key = "QZGG7K0Adw";
    
    if($_GET['secure_key'] == __Secure_Key__){
        $resources = new Resource();
        $resources->updateResources();
    }else{
        die('invalid secure key. RIP');
    }
}

function getGroup()
{
    $resources = new Resource();

    $currentGroups = $resources->getAllGroups();
    $group = $_GET['group'];    

    if(in_array($group, $currentGroups)){
        echo json_encode( $resources->getGroup($group));       
    }else{
        die("Group not found.");
    }
   
}

function getPlanet()
{
    $resource = new Resource();
    echo json_encode($resource->getPlanets($_GET['resource']));
}

function getCategories()
{    
    $categoryClass = new Category();
    echo json_encode($categoryClass->getCategoriesByDepth($_GET['level'],$_GET['id_parent'] ));
}

function getResources()
{    
    $resource = new Resource();
    echo json_encode($resource->getResources($_GET['id_category']));
}

function getResourcesCount()
{    
    $resource = new Resource();
    echo json_encode($resource->getResourcesCount($_GET['id_category']), true);
}

function countChildrenCategories()
{    
    $categoryClass = new Category();
    echo json_encode($categoryClass->countChildrenCategories($_GET['id_parent']));
}

function formatData()
{    
    $resourceClass = new Resource();
    $resourceClass->categoryResourceAssoc();
}

?>