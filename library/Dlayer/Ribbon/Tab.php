<?php

/**
 * A ribbon displays for every tool, each ribbon has a number of tabs
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Ribbon_Tab
{
	private $model_ribbon_tab;

	/**
	 * Set up any properties required by the class
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->model_ribbon_tab = new Dlayer_Model_Ribbon_Tab();
	}

	/**
	 * Fetch the view script for the tool tab, the view script is typically
	 * a folder which matches the tool followed by a view script for the
	 * requested tab. If the tool isn't valid or currently enabled FALSE will be
	 * returned.
	 *
	 * @todo Fix this once all tools updated to being modular
	 * @param string $module
	 * @param string $tool Requested tool name
	 * @param string $tab Requested tool tab name
	 * @param boolean $modular Use new modular tools
	 * @return string|FALSE Either the view script or FALSE if tool not valid
	 *                      for some reason
	 */
	public function viewScript($module, $tool, $tab, $modular=FALSE)
	{
		if($modular === FALSE)
		{
			return $this->model_ribbon_tab->tabViewScriptPath($module, $tool, $tab);
		}
		else
		{
			return $this->model_ribbon_tab->tabViewScript($module, $tool, $tab);
		}
	}

	/**
	 * Fetch the multi use status of the tool tab. If the tool tab is a multi
	 * user tool after processing the user will be returned back to the
	 * designer with the tool and tab still selected
	 *
	 * @param string $module
	 * @param string $tool
	 * @param string $tab
	 * @return integer 1 for multi use, 0 otherwise
	 */
	public function multiUse($module, $tool, $tab)
	{
		return $this->model_ribbon_tab->multiUseToolTab($module, $tool, $tab);
	}

	/**
	 * Fetch the view data for the ribbon, each tool and tab will need different data, the handler class will
	 * invoke the relevant ribbon class
	 *
	 * @param string $module
	 * @param string $tool
	 * @param string $tab
	 * @param integer $multi_use Multi use setting, either 1 or 0
	 * @param boolean $edit_mode If the current tool in edit mode
	 * @return array
	 * @throws \Exception
	 */
	public function viewData($module, $tool, $tab, $multi_use, $edit_mode = FALSE)
	{
		$session_dlayer = new Dlayer_Session();

		switch($module)
		{
			case 'content':
				$content_handler = new Dlayer_Ribbon_Handler_Content();
				$session_content = new Dlayer_Session_Content();

				$data = $content_handler->viewData($session_dlayer->siteId(), $session_content->pageId(),
					$tool, $tab, $multi_use, $edit_mode, $session_content->rowId(), $session_content->columnId(),
					$session_content->contentId());
			break;

			case 'form':
				$form_ribbon = new Dlayer_Ribbon_Data_Form();
				$session_form = new Dlayer_Session_Form();

				$data = $form_ribbon->viewData($session_dlayer->siteId(),
					$session_form->formId(), $tool, $tab, $multi_use,
					$session_form->fieldId(), $edit_mode);
			break;

			case 'website':
				$data = NULL;
			break;

			case 'image':
				$image_ribbon = new Dlayer_Ribbon_Data_Image();
				$session_image = new Dlayer_Session_Image();

				$data = $image_ribbon->viewData($session_dlayer->siteId(),
					$tool, $tab, $multi_use, $session_image->imageId(),
					$session_image->imageId(Dlayer_Session_Image::VERSION),
					$session_image->imageId(Dlayer_Session_Image::CATEGORY),
					$session_image->imageId(Dlayer_Session_Image::SUB_CATEGORY),
					$edit_mode);
			break;

			default:
				throw new Exception('Module "' . $module . '"not set in ' .
					__CLASS__ . ' ' . __METHOD__);
			break;
		}

		return $data;
	}
}
