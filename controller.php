<?php
/**
 * @package	Music
 * @subpackage	Song
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @copyright	Copyright (C) 2009 Daniel Scott (http://danieljamesscott.org). All rights reserved.
 * @license	GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

/**
 * Song Component Controller
 *
 * @static
 * @package	Music
 * @subpackage	Song
 * @since 1.5
 */
class MusicController extends JController
{
	/**
	 * Display the view
	 */
	function display()
	{
		$document =& JFactory::getDocument();

		// Get view from URL default is 'album'
		$viewName	= JRequest::getVar('view', 'album', 'default', 'cmd');
		// Type?
		$viewType	= $document->getType();

		// Set the default view name from the Request
		$view = &$this->getView($viewName, $viewType);

		// Push a model into the view
		$model	= &$this->getModel( $viewName );
		if (!JError::isError( $model )) {
			$view->setModel( $model, true );
		}

		$view->setLayout(JRequest::getCmd( 'layout', 'default' ), JRequest::getCmd( 'layout', 'default' ));

		// Display the view
		$view->assign('error', $this->getError());
		$view->display();
	}
}
