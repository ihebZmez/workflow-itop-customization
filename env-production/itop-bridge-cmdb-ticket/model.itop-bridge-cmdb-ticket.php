<?php
//
// File generated by ... on the 2023-07-21T15:58:25+0200
// Please do not edit manually
//

/**
 * Classes and menus for itop-bridge-cmdb-ticket (version 3.0.2)
 *
 * @author      iTop compiler
 * @license     http://opensource.org/licenses/AGPL-3.0
 */



class lnkFunctionalCIToTicket extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel',
			'key_type' => 'autoincrement',
			'is_link' => true,
			'name_attcode' => array('ticket_id', 'functionalci_id'),
			'image_attcode' => '',
			'state_attcode' => '',
			'reconc_keys' => array('ticket_id', 'functionalci_id'),
			'db_table' => 'lnkfunctionalcitoticket',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, null),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeExternalKey("ticket_id", array("targetclass"=>'Ticket', "allowed_values"=>null, "sql"=>'ticket_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("ticket_ref", array("allowed_values"=>null, "extkey_attcode"=>'ticket_id', "target_attcode"=>'ref', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("ticket_title", array("allowed_values"=>null, "extkey_attcode"=>'ticket_id', "target_attcode"=>'title', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("functionalci_id", array("targetclass"=>'FunctionalCI', "allowed_values"=>null, "sql"=>'functionalci_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("functionalci_name", array("allowed_values"=>null, "extkey_attcode"=>'functionalci_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("impact", array("allowed_values"=>null, "sql"=>'impact', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEnum("impact_code", array("allowed_values"=>new ValueSetEnum("manual,computed,not_impacted"), "display_style"=>'list', "sql"=>'impact_code', "default_value"=>'manual', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'ticket_id',
  1 => 'functionalci_id',
  2 => 'impact_code',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'ticket_id',
  1 => 'functionalci_id',
  2 => 'impact_code',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'ticket_id',
  1 => 'functionalci_id',
  2 => 'impact_code',
));
;
	}


}


class lnkFunctionalCIToProviderContract extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel',
			'key_type' => 'autoincrement',
			'is_link' => true,
			'name_attcode' => array('providercontract_id', 'functionalci_id'),
			'image_attcode' => '',
			'state_attcode' => '',
			'reconc_keys' => array('providercontract_id', 'functionalci_id'),
			'db_table' => 'lnkfunctionalcitoprovidercontract',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, null),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeExternalKey("providercontract_id", array("targetclass"=>'ProviderContract', "allowed_values"=>null, "sql"=>'providercontract_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("providercontract_name", array("allowed_values"=>null, "extkey_attcode"=>'providercontract_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("functionalci_id", array("targetclass"=>'FunctionalCI', "allowed_values"=>null, "sql"=>'functionalci_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("functionalci_name", array("allowed_values"=>null, "extkey_attcode"=>'functionalci_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'providercontract_id',
  1 => 'functionalci_id',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'providercontract_id',
  1 => 'functionalci_id',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'providercontract_id',
  1 => 'functionalci_id',
));
;
	}


}


class lnkFunctionalCIToService extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel',
			'key_type' => 'autoincrement',
			'is_link' => true,
			'name_attcode' => array('service_id', 'functionalci_id'),
			'image_attcode' => '',
			'state_attcode' => '',
			'reconc_keys' => array('service_id', 'functionalci_id'),
			'db_table' => 'lnkfunctionalcitoservice',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, null),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeExternalKey("service_id", array("targetclass"=>'Service', "allowed_values"=>null, "sql"=>'service_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("service_name", array("allowed_values"=>null, "extkey_attcode"=>'service_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("functionalci_id", array("targetclass"=>'FunctionalCI', "allowed_values"=>null, "sql"=>'functionalci_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("functionalci_name", array("allowed_values"=>null, "extkey_attcode"=>'functionalci_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'service_id',
  1 => 'functionalci_id',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'service_id',
  1 => 'functionalci_id',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'service_id',
  1 => 'functionalci_id',
));
;
	}


}