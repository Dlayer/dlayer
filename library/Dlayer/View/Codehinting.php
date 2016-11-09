<?php

/**
 * PHPed can't code hint for view helpers, they are dynamically invoked, in
 * the viewscript and layout scripts we phpDoc hint $this to this class
 * and then create methods for each of the vuie helpers, these methods will
 * return the view helper class, the result being code completion
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_Codehinting extends Zend_View_Helper_Abstract
{
	/**
	 * Returns site's base url, or file with base url prepended
	 *
	 * $file is appended to the base url for simplicity
	 *
	 * @param  string|null $file
	 * @return string
	 */
	public function baseUrl($file = NULL)
	{
	}

	/**
	 * Set or retrieve doctype
	 *
	 * @param  string $doctype
	 * @return Zend_View_Helper_Doctype
	 */
	public function doctype($doctype = NULL)
	{
	}

	/**
	 * Encode data as JSON, disable layouts, and set response header
	 *
	 * If $keepLayouts is true, does not disable layouts.
	 *
	 * @param  mixed $data
	 * @param  bool $keepLayouts
	 * NOTE:   if boolean, establish $keepLayouts to true|false
	 *         if array, admit params for Zend_Json::encode as enableJsonExprFinder=>true|false
	 *         this array can contains a 'keepLayout'=>true|false
	 *         that will not be passed to Zend_Json::encode method but will be used here
	 * @return string|void
	 */
	public function json($data, $keepLayouts = FALSE)
	{
	}

	/**
	 * Escape var to protect from XSS
	 *
	 * @param string $string String to escape
	 * @return string
	 */
	public function escape($string)
	{
	}

	/**
	 * This is the base content view helper, it is called by the content row
	 * view helper and generates all the html the content items that have been
	 * added to the requested row, once all the html has been generated the
	 * string is passed back to the content row view helper.
	 *
	 * The html for individual content items is handled by child view
	 * helpers, there is one for each content type, this helper passes the
	 * requests on and then concatenates the output
	 *
	 * @return Dlayer_View_Content
	 */
	public function content()
	{
	}

	/**
	 * Generates the html and javascript for the color picker, called on ribbon
	 * tabs that have color inputs that need to the replaced by calls to the
	 * color picker
	 *
	 * The color picker and javscript methods should be returned individually
	 * in different parts of the script, javascript at the end of the script
	 * after all html, color picker before any contols
	 *
	 * Example usage, <?php echo $this->colorPicker()->javascript(); ?>
	 * and <?php echo $this->colorPicker()->picker(TRUE, FALSE, TRUE); ?>
	 *
	 * @return Dlayer_View_ColorPicker
	 */
	public function colorPicker()
	{
	}

	/**
	 * Generates a simple bootstrap navbar
	 *
	 * @param string $brand Brand name/img, appears to let of navbar
	 * @param string $brand_url URL to use for branch text, icon
	 * @param array $navbar_items Array containing the navbar items, each item
	 *     should be an array with the folowing keys, uri, title, name and and
	 *     optionally children. A driop down will created for all the items in the
	 *     children array
	 * @param string $active_uri The Uri of the active item
	 * @return Dlayer_View_Bootstrap3Navbar
	 */
	public function bootstrap3Navbar($brand, $brand_url, array $navbar_items,
		$active_url = '')
	{
	}

	/**
	 * Generates a simple bootstrap navbar
	 *
	 * @param string $brand Brand name/img, appears to let of navbar
	 * @param string $brand_url URL to use for branch text, icon
	 * @param array $navbar_items Array containing the navbar items, each item
	 *    should be an array with the folowing keys, uri, title, name and and
	 *    optionally children. A driop down will created for all the items in the
	 *    children array
	 * @param string $active_uri The Uri of the active item
	 * @param string|NULL $preview_uri Include preview link
	 * @param boolean $signed_in User is signed in show sign out link
	 * @return Dlayer_View_Bootstrap3NavbarDlayer
	 */
	public function bootstrap3NavbarDlayer($brand, $brand_url, array $navbar_items,
		$active_uri = '', $preview_uri = NULL, $signed_in = TRUE)
	{
	}

	/**
	 * Set the url and well setting for the further reading view helper
	 *
	 * @param string $url Optional URL to use for second button, just the
	 *    fragment after the domain, http://specification.dlayer.com/
	 * @param boolean $well Should the content be placed inside a bootstrap
	 *    well, useful to separate the further section from other content
	 * @return Dlayer_View_Navigation
	 */
	public function furtherReading($url = NULL, $well = FALSE)
	{
	}

	/**
	 * Pass in anything required to set up the object
	 *
	 * @param array $rows The rows that make up the content page
	 * @param array $columns The columns that make up the content page
	 * @param array $content Contains the raw data to generate the content items and assign them to their row
	 * @param TRUE|NULL $page_selected Is the content page selected in designer?
	 * @param integer|NULL $column_id Id of the selected column, if any
	 * @param integer|NULL $row_id Id of the selected row if any
	 * @param integer|NULL $content_id Id of the selected content item if any
	 * @return Dlayer_View_ContentPage
	 */
	public function contentPage(array $rows, array $columns, array $content, $page_selected = NULL, $column_id = NULL, $row_id = NULL, $content_id = NULL)
	{
	}

	/**
	 * Row view helper, this is called by the content page view helper, called to generated any rows attached to the
	 * base container div and then called by each column, rows can only be added to columns and the base container div.
	 * It is also responsible for calling the content view helper as content con only sit in rows
	 *
	 * @return Dlayer_View_Row
	 */
	public function row()
	{
	}

	/**
	 * Column view helper, this is called by the row view helper, it generates the html for all the columns, it will
	 * call the row view helper for each column as columns can only be applied to rows
	 *
	 * @return Dlayer_View_Column
	 */
	public function column()
	{
	}

	/**
	 * Text content item view helper, a text block is simple a string of text enclosed within p tags
	 *
	 * @param array $data Content item data array
	 * @param boolean $selectable
	 * @param boolean $selected
	 * @return Dlayer_View_Text
	 */
	public function text(array $data, $selectable = FALSE, $selected = FALSE)
	{
	}

	/**
	 * Heading content item view helper, a heading item is a string with an optional sub heading in a smaller, lighter
	 * font off to the right
	 *
	 * @param array $data Content item data array
	 * @param boolean $selectable
	 * @param boolean $selected
	 * @return Dlayer_View_Heading
	 */
	public function heading(array $data, $selectable = FALSE, $selected = FALSE)
	{
	}

	/**
	 * Image content item view helper, image may include a link to expand and a caption
	 *
	 * @param array $data Content item data array
	 * @param boolean $selectable
	 * @param boolean $selected
	 * @return Dlayer_View_Image
	 */
	public function image(array $data, $selectable = FALSE, $selected = FALSE)
	{
	}

	/**
	 * Jumbotron content item view helper, a jumbotron is used to highlight something on a page, it features a title,
	 * sub title and optional button
	 *
	 * @param array $data Content item data array
	 * @param boolean $selectable
	 * @param boolean $selected
	 * @return Dlayer_View_Jumbotron
	 */
	public function jumbotron(array $data, $selectable = FALSE, $selected = FALSE)
	{
	}

	/**
	 * Form content item view helper
	 *
	 * @param array $data Content item data array
	 * @param boolean $selectable
	 * @param boolean $selected
	 * @return Dlayer_View_ImportedForm
	 */
	public function importedForm(array $data, $selectable = FALSE, $selected = FALSE)
	{
	}

	/**
	 * Preview version of the content page view helper
	 *
	 * @param array $rows The rows that make up the content page
	 * @param array $columns The columns that make up the content page
	 * @param array $content Contains the raw data to generate the content items and assign them to their row
	 * @return Dlayer_View_ContentPagePreview
	 */
	public function contentPagePreview(array $rows, array $columns, array $content)
	{
	}

	/**
	 * Preview version of the row view helper
	 *
	 * @return Dlayer_View_RowPreview
	 */
	public function rowPreview()
	{
	}

    /**
     * View helper constructor, pass in anything that may be needed to create the object
     *
     * @return Dlayer_View_StylingContentItem
     */
    public function stylingContentItem()
    {
    }

	/**
	 * Preview version of the column view helper
	 *
	 * @return Dlayer_View_ColumnPreview
	 */
	public function columnPreview()
	{
	}

	/**
	 * Preview version of the content view helper
	 *
	 * @return Dlayer_View_ContentPreview
	 */
	public function contentPreview()
	{
	}

	/**
	 * Preview version of the heading content item view helper
	 *
	 * @param array $data Content item data array
	 * @return Dlayer_View_HeadingPreview
	 */
	public function headingPreview(array $data)
	{
	}

	/**
	 * Preview version of the text content item view helper
	 *
	 * @param array $data Content item data array
	 * @return Dlayer_View_TextPreview
	 */
	public function textPreview(array $data)
	{
	}

	/**
	 * Preview version of the jumbotron content item view helper
	 *
	 * @param array $data Content item data array
	 * @return Dlayer_View_JumbotronPreview
	 */
	public function jumbotronPreview(array $data)
	{
	}

	/**
	 * Preview version of the image content item view helper
	 *
	 * @param array $data Content item data array
	 * @return Dlayer_View_ImagePreview
	 */
	public function imagePreview(array $data)
	{
	}

	/**
	 * Preview version of the import form content item view helper
	 *
	 * @param array $data Content item data array
	 * @return Dlayer_View_ImportedFormPreview
	 */
	public function importedFormPreview(array $data)
	{
	}
}
