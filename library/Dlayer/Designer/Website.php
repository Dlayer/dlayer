<?php
/**
* Base web site designer class, brings together all the data required to 
* generate the html for the site map and un assigned pages
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Website.php 1614 2014-02-24 23:35:13Z Dean.Blackborough $
*/
class Dlayer_Designer_Website 
{
    private $site_id;

    private $page_id = NULL;

    /**
    * Initialise the object, run setup methods and set initial properties
    *
    * @param integer $site_id
    * @param integer|NULL $page_id Id of the selected page
    * @return void
    */
    public function __construct($site_id, $page_id=NULL)
    {
        $this->site_id = $site_id;
        $this->page_id = $page_id;
    }
    
    /**
    * Return the array of un assigned pages
    * 
    * @return array
    */
    public function unassignedPages() 
    {
		return array(
    	array('id'=>1, 'name'=>'Project 4', 'title'=>'Our fourth project',
    	'description'=>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum...', 
    	'children'=>3, 'parent_id'=>1), 
		array('id'=>1, 'name'=>'Project 5', 'title'=>'Our fifth project',
    	'description'=>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum...', 
    	'children'=>0, 'parent_id'=>1));
    }
    
    /**
    * Return the array of pages for the selected level, this will be the 
    * selected page and its siblings or the base level pages if a page id is 
    * not currently selected
    * 
    * @return array
    */
    public function selectedPages() 
    {
    	return array(
    	array('id'=>1, 'name'=>'Blog', 'title'=>'Our development blog',
    	'description'=>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum...', 
    	'children'=>1, 'parent_id'=>1), 
		array('id'=>2, 'name'=>'News page', 'title'=>'Site news', 
		'description'=>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum...', 
		'children'=>6, 'parent_id'=>1), 
		array('id'=>3, 'name'=>'Products overview', 'title'=>'Our products', 
		'description'=>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum...', 
		'children'=>7, 'parent_id'=>1), 
		array('id'=>3, 'name'=>'Contact', 'title'=>'Contact us', 
		'description'=>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum...', 
		'children'=>7, 'parent_id'=>1), 
		array('id'=>4, 'name'=>'About', 'title'=>'About our company', 
		'description'=>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum...', 
		'children'=>4, 'parent_id'=>1));
    }
    
    /**
    * Return the array of parent pages, these will be the parent of the selected 
    * page and all its siblings, if there are no parents an empty array is 
    * returned
    * 
    * @return array
    */
    public function parentPages() 
    {
		return array(
    	array('id'=>1, 'name'=>'Home', 'title'=>'Our web site',
    	'description'=>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum...', 
    	'children'=>6, 'parent_id'=>0));
    }
    
    /**
    * fetch the array of child pages, this will be all the children of the 
    * selected page. If a page has not been selected an empty array will be 
    * returned
    * 
    * @return array
    */
    public function childPages() 
    {
		return array(
    	array('id'=>1, 'name'=>'Project 1', 'title'=>'Our first project',
    	'description'=>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum...', 
    	'children'=>3, 'parent_id'=>1), 
		array('id'=>1, 'name'=>'Project 2', 'title'=>'Our second project',
    	'description'=>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum...', 
    	'children'=>0, 'parent_id'=>1),
		array('id'=>1, 'name'=>'Project 3', 'title'=>'Our third project',
    	'description'=>'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum...', 
    	'children'=>0, 'parent_id'=>1));
    }
}