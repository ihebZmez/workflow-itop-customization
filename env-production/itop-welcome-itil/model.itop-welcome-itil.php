<?php
//
// File generated by ... on the 2023-07-21T15:58:23+0200
// Please do not edit manually
//

/**
 * Classes and menus for itop-welcome-itil (version 3.0.2)
 *
 * @author      iTop compiler
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

//
// Menus
//
class MenuCreation_itop_welcome_itil extends ModuleHandlerAPI
{
	public static function OnMenuCreation()
	{
		global $__comp_menus__; // ensure that the global variable is indeed global !
		$__comp_menus__['WelcomeMenu'] = new MenuGroup('WelcomeMenu', 10, 'fas fa-home' , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['WelcomeMenuPage'] = new DashboardMenuNode('WelcomeMenuPage', dirname(__FILE__).'/welcomemenupage_dashboard.xml', $__comp_menus__['WelcomeMenu']->GetIndex(), 10 , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
	}
} // class MenuCreation_itop_welcome_itil
