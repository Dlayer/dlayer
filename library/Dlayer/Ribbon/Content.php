<?php

/**
 * Base class for content manager ribbons
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
abstract class Dlayer_Ribbon_Content
{
	protected $tool;
    protected $preview;

    /**
     * @var bool Has the call to the content data already been made and data set
     */
    protected $content_fetched = false;

    /**
     * @var boolean Has the element input data already been requested
     */
    protected $element_data_fetched = false;

    /**
     * @var boolean Has the preview data been fetched
     */
    protected $preview_data_fetched = false;

    /**
     * @var boolean Has the instances data been fetched
     */
    protected $instances_of_fetched = false;

    /**
     * @var array The data for the content item/structure item
     */
    protected $content_data = array();

    /**
     * @var array Element data array
     */
    protected $element_data = array();

    /**
     * @var array Preview data
     */
    protected $preview_data = array();

    /**
     * @var integer
     */
    protected $instances_of = 0;

	/**
	 * Fetch the view data for the current tool tab, typically the returned array will have at least two indexes,
	 * one for the form and another with the data required by the preview functions
	 *
	 * @param array $tool Tool and environment data
	 * @return array
	 */
	abstract public function viewData(array $tool);

	/**
	 * Fetch the data array for the content item, if in edit mode mode populate the values otherwise every value is
	 * set to FALSE, the tool form can simply check to see if the value is FALSe or not and then set the existing value
	 *
	 * @return array
	 */
	abstract protected function contentData();

	/**
	 * Fetch the number of instances for the content items data
	 *
	 * @return integer
	 */
	abstract protected function instancesOfData();
}
