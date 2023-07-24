<?php
//
// File generated by ... on the 2023-07-21T15:58:23+0200
// Please do not edit manually
//

/**
 * Classes and menus for itop-structure (version 3.0.2)
 *
 * @author      iTop compiler
 * @license     http://opensource.org/licenses/AGPL-3.0
 */


/**
 * Persistent classes for a CMDB
 *
 * @copyright   Copyright (C) 2010-2021 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */
class Organization extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable,structure',
			'key_type' => 'autoincrement',
			'name_attcode' => array('name'),
			'image_attcode' => '',
			'state_attcode' => 'status',
			'reconc_keys' => array('name', 'code'),
			'db_table' => 'organization',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, 'itop-structure/../../images/icons/icons8-organization.svg'),
			'obsolescence_expression' => 'status = \'inactive\'',);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeString("name", array("allowed_values"=>null, "sql"=>'name', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("code", array("allowed_values"=>null, "sql"=>'code', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEnum("status", array("allowed_values"=>new ValueSetEnum("active,inactive"), "styled_values"=>['active' =>  new ormStyle('ibo-dm-enum--Organization-status-active', 'ibo-dm-enum-alt--Organization-status-active', 'var(--ibo-dm-enum--Organization-status-active--main-color)', 'var(--ibo-dm-enum--Organization-status-active--complementary-color)', null, null),'inactive' =>  new ormStyle('ibo-dm-enum--Organization-status-inactive', 'ibo-dm-enum-alt--Organization-status-inactive', 'var(--ibo-dm-enum--Organization-status-inactive--main-color)', 'var(--ibo-dm-enum--Organization-status-inactive--complementary-color)', null, null)], "display_style"=>'list', "sql"=>'status', "default_value"=>'active', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeHierarchicalKey("parent_id", array("allowed_values"=>null, "sql"=>'parent_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("parent_name", array("allowed_values"=>null, "extkey_attcode"=>'parent_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeDashboard("overview", array("is_user_editable"=>true, "definition_file"=>'itop-structure/organization__overview_dashboard.xml', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("deliverymodel_id", array("targetclass"=>'DeliveryModel', "allowed_values"=>null, "sql"=>'deliverymodel_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("deliverymodel_name", array("allowed_values"=>null, "extkey_attcode"=>'deliverymodel_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));

		// States but no lifecycle declared in XML (status attribute: status)
		//
		MetaModel::Init_DefineState(
			"",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array()
			)
		);
		MetaModel::Init_DefineState(
			"",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array()
			)
		);


		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
  1 => 'code',
  2 => 'status',
  3 => 'parent_id',
  4 => 'overview',
  5 => 'deliverymodel_id',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
  1 => 'code',
  2 => 'status',
  3 => 'parent_id',
));
		MetaModel::Init_SetZListItems('default_search', array (
  0 => 'name',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'code',
  1 => 'status',
  2 => 'parent_id',
));
;
	}


}


class Location extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable,structure',
			'key_type' => 'autoincrement',
			'name_attcode' => array('name'),
			'image_attcode' => '',
			'state_attcode' => 'status',
			'reconc_keys' => array('name', 'org_id', 'org_name'),
			'db_table' => 'location',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, 'itop-structure/../../images/icons/icons8-map-marker.svg'),
			'obsolescence_expression' => 'status = \'inactive\'',);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeString("name", array("allowed_values"=>null, "sql"=>'name', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEnum("status", array("allowed_values"=>new ValueSetEnum("active,inactive"), "styled_values"=>['active' =>  new ormStyle('ibo-dm-enum--Location-status-active', 'ibo-dm-enum-alt--Location-status-active', 'var(--ibo-dm-enum--Location-status-active--main-color)', 'var(--ibo-dm-enum--Location-status-active--complementary-color)', null, null),'inactive' =>  new ormStyle('ibo-dm-enum--Location-status-inactive', 'ibo-dm-enum-alt--Location-status-inactive', 'var(--ibo-dm-enum--Location-status-inactive--main-color)', 'var(--ibo-dm-enum--Location-status-inactive--complementary-color)', null, null)], "display_style"=>'list', "sql"=>'status', "default_value"=>'active', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("org_id", array("targetclass"=>'Organization', "allowed_values"=>null, "sql"=>'org_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("org_name", array("allowed_values"=>null, "extkey_attcode"=>'org_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeText("address", array("allowed_values"=>null, "sql"=>'address', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("postal_code", array("allowed_values"=>null, "sql"=>'postal_code', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("city", array("allowed_values"=>null, "sql"=>'city', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("country", array("allowed_values"=>null, "sql"=>'country', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSet("person_list", array("linked_class"=>'Person', "ext_key_to_me"=>'location_id', "count_min"=>0, "count_max"=>0, "edit_mode"=>LINKSET_EDITMODE_ADDONLY, "allowed_values"=>null, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSet("physicaldevice_list", array("linked_class"=>'PhysicalDevice', "ext_key_to_me"=>'location_id', "count_min"=>0, "count_max"=>0, "edit_mode"=>LINKSET_EDITMODE_ADDONLY, "allowed_values"=>null, "depends_on"=>array(), "always_load_in_tables"=>false)));

		// States but no lifecycle declared in XML (status attribute: status)
		//
		MetaModel::Init_DefineState(
			"",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array()
			)
		);
		MetaModel::Init_DefineState(
			"",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array()
			)
		);


		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
  1 => 'status',
  2 => 'org_id',
  3 => 'address',
  4 => 'postal_code',
  5 => 'city',
  6 => 'country',
  7 => 'person_list',
  8 => 'physicaldevice_list',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
  1 => 'status',
  2 => 'org_id',
  3 => 'address',
  4 => 'postal_code',
  5 => 'city',
  6 => 'country',
));
		MetaModel::Init_SetZListItems('default_search', array (
  0 => 'name',
  1 => 'country',
  2 => 'org_id',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'status',
  1 => 'org_id',
  2 => 'city',
  3 => 'country',
));
;
	}


}


abstract class Contact extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable,structure',
			'key_type' => 'autoincrement',
			'name_attcode' => array('name'),
			'image_attcode' => '',
			'state_attcode' => 'status',
			'reconc_keys' => array('name', 'org_id', 'org_name', 'email', 'finalclass'),
			'db_table' => 'contact',
			'db_key_field' => 'id',
			'db_finalclass_field' => 'finalclass',
			'style' =>  new ormStyle('ibo-dm-class--Contact', 'ibo-dm-class-alt--Contact', 'var(--ibo-dm-class--Contact--main-color)', 'var(--ibo-dm-class--Contact--complementary-color)', null, 'itop-structure/../../images/icons/icons8-customer.svg'),
			'obsolescence_expression' => 'status=\'inactive\'',);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeString("name", array("allowed_values"=>null, "sql"=>'name', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEnum("status", array("allowed_values"=>new ValueSetEnum("active,inactive"), "styled_values"=>['active' =>  new ormStyle('ibo-dm-enum--Contact-status-active', 'ibo-dm-enum-alt--Contact-status-active', 'var(--ibo-dm-enum--Contact-status-active--main-color)', 'var(--ibo-dm-enum--Contact-status-active--complementary-color)', null, null),'inactive' =>  new ormStyle('ibo-dm-enum--Contact-status-inactive', 'ibo-dm-enum-alt--Contact-status-inactive', 'var(--ibo-dm-enum--Contact-status-inactive--main-color)', 'var(--ibo-dm-enum--Contact-status-inactive--complementary-color)', null, null)], "display_style"=>'list', "sql"=>'status', "default_value"=>'active', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("org_id", array("targetclass"=>'Organization', "allowed_values"=>null, "sql"=>'org_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("org_name", array("allowed_values"=>null, "extkey_attcode"=>'org_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEmailAddress("email", array("allowed_values"=>null, "sql"=>'email', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributePhoneNumber("phone", array("allowed_values"=>null, "sql"=>'phone', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEnum("notify", array("allowed_values"=>new ValueSetEnum("yes,no"), "display_style"=>'radio_horizontal', "sql"=>'notify', "default_value"=>'yes', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("function", array("allowed_values"=>null, "sql"=>'function', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSetIndirect("cis_list", array("linked_class"=>'lnkContactToFunctionalCI', "ext_key_to_me"=>'contact_id', "ext_key_to_remote"=>'functionalci_id', "allowed_values"=>null, "count_min"=>0, "count_max"=>0, "duplicates"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));

		// States but no lifecycle declared in XML (status attribute: status)
		//
		MetaModel::Init_DefineState(
			"",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array()
			)
		);
		MetaModel::Init_DefineState(
			"",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array()
			)
		);


		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
  1 => 'status',
  2 => 'org_id',
  3 => 'email',
  4 => 'phone',
  5 => 'notify',
  6 => 'function',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
  1 => 'status',
  2 => 'org_id',
  3 => 'email',
  4 => 'phone',
  5 => 'notify',
  6 => 'function',
));
		MetaModel::Init_SetZListItems('default_search', array (
  0 => 'friendlyname',
  1 => 'email',
  2 => 'org_id',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'status',
  1 => 'org_id',
  2 => 'email',
  3 => 'phone',
  4 => 'function',
));
;
	}


}


class Person extends Contact
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable,structure',
			'key_type' => 'autoincrement',
			'name_attcode' => array('first_name', 'name'),
			'image_attcode' => 'picture',
			'state_attcode' => '',
			'reconc_keys' => array('name', 'first_name', 'org_id', 'org_name', 'email', 'employee_number'),
			'db_table' => 'person',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, 'itop-structure/../../images/icons/icons8-person-female.svg'),
			'uniqueness_rules' => array (
  'employee_number' => 
  array (
    'attributes' => 
    array (
      0 => 'org_id',
      1 => 'employee_number',
    ),
    'filter' => 'employee_number != \'\'',
    'disabled' => false,
    'is_blocking' => true,
  ),
  'name' => 
  array (
    'attributes' => 
    array (
      0 => 'org_id',
      1 => 'name',
      2 => 'first_name',
    ),
    'filter' => NULL,
    'disabled' => false,
    'is_blocking' => false,
  ),
),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeImage("picture", array("is_null_allowed"=>true, "depends_on"=>array(), "display_max_width"=>96, "display_max_height"=>96, "storage_max_width"=>128, "storage_max_height"=>128, "default_image"=>utils::GetAbsoluteUrlModulesRoot().'itop-structure/images/silhouette.png', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("first_name", array("allowed_values"=>null, "sql"=>'first_name', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("employee_number", array("allowed_values"=>null, "sql"=>'employee_number', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributePhoneNumber("mobile_phone", array("allowed_values"=>null, "sql"=>'mobile_phone', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("location_id", array("targetclass"=>'Location', "allowed_values"=>new ValueSetObjects("SELECT l FROM Location AS l JOIN Organization AS root ON l.org_id=root.id JOIN Organization AS child ON child.parent_id BELOW root.id WHERE child.id= :this->org_id"), "sql"=>'location_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array('org_id'), "allow_target_creation"=>false, "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("location_name", array("allowed_values"=>null, "extkey_attcode"=>'location_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("manager_id", array("targetclass"=>'Person', "allowed_values"=>new ValueSetObjects("SELECT Person"), "sql"=>'manager_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("manager_name", array("allowed_values"=>null, "extkey_attcode"=>'manager_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSetIndirect("team_list", array("linked_class"=>'lnkPersonToTeam', "ext_key_to_me"=>'person_id', "ext_key_to_remote"=>'team_id', "allowed_values"=>null, "count_min"=>0, "count_max"=>0, "duplicates"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSet("tickets_list", array("linked_class"=>'Ticket', "ext_key_to_me"=>'caller_id', "count_min"=>0, "count_max"=>0, "edit_mode"=>LINKSET_EDITMODE_ADDONLY, "allowed_values"=>null, "depends_on"=>array(), "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'team_list',
  1 => 'tickets_list',
  2 => 'cis_list',
  'col:col1' => 
  array (
    'fieldset:Person:info' => 
    array (
      0 => 'name',
      1 => 'first_name',
      2 => 'org_id',
      3 => 'status',
      4 => 'location_id',
      5 => 'function',
      6 => 'manager_id',
      7 => 'employee_number',
    ),
  ),
  'col:col2' => 
  array (
    'fieldset:Person:personal_info' => 
    array (
      0 => 'picture',
    ),
    'fieldset:Person:notifiy' => 
    array (
      0 => 'email',
      1 => 'notify',
      2 => 'phone',
      3 => 'mobile_phone',
    ),
  ),
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
  1 => 'first_name',
  2 => 'org_id',
  3 => 'status',
  4 => 'location_id',
  5 => 'email',
  6 => 'phone',
  7 => 'employee_number',
  8 => 'manager_id',
  9 => 'mobile_phone',
  10 => 'notify',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'name',
  1 => 'org_id',
  2 => 'status',
  3 => 'location_id',
  4 => 'email',
  5 => 'phone',
));
;
	}



  	public function CheckToDelete(&$oDeletionPlan)
  	{
  		if (MetaModel::GetConfig()->Get('demo_mode'))
		{
			if ($this->HasUserAccount())
			{
				// Do not let users change user accounts in demo mode
				$oDeletionPlan->AddToDelete($this, null);
				$oDeletionPlan->SetDeletionIssues($this, array('deletion not allowed in demo mode.'), true);
				$oDeletionPlan->ComputeResults();
				return false;
			}
		}
		return parent::CheckToDelete($oDeletionPlan);
  	}



  	public function DBDeleteSingleObject()
	{
		if (MetaModel::GetConfig()->Get('demo_mode'))
		{
			if ($this->HasUserAccount())
			{
				// Do not let users change user accounts in demo mode
				return;
			}
		}
		parent::DBDeleteSingleObject();
	}



	public function GetAttributeFlags($sAttCode, &$aReasons = array(), $sTargetState = '')
	{
		if ( ($sAttCode == 'org_id') && (!$this->IsNew()) )
		{
			if (MetaModel::GetConfig()->Get('demo_mode'))
			{
				if ($this->HasUserAccount())
				{
					// Do not let users change user accounts in demo mode
					return OPT_ATT_READONLY;
				}
			}
		}
		return parent::GetAttributeFlags($sAttCode, $aReasons, $sTargetState);
	}



  	public function HasUserAccount()
  	{
		static $bHasUserAccount = null;
		if (is_null($bHasUserAccount))
		{
			$oUserSet = new DBObjectSet(DBSearch::FromOQL('SELECT User WHERE contactid = :person', array('person' => $this->GetKey())));
			$bHasUserAccount = ($oUserSet->Count() > 0);
		}
		return $bHasUserAccount;
  	}


}


class Team extends Contact
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable',
			'key_type' => 'autoincrement',
			'name_attcode' => array('name'),
			'image_attcode' => '',
			'state_attcode' => '',
			'reconc_keys' => array('name', 'org_id', 'org_name', 'email'),
			'db_table' => 'team',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, 'itop-structure/../../images/icons/icons8-team.svg'),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeLinkedSetIndirect("persons_list", array("linked_class"=>'lnkPersonToTeam', "ext_key_to_me"=>'team_id', "ext_key_to_remote"=>'person_id', "allowed_values"=>null, "count_min"=>0, "count_max"=>0, "duplicates"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSet("tickets_list", array("linked_class"=>'Ticket', "ext_key_to_me"=>'team_id', "count_min"=>0, "count_max"=>0, "edit_mode"=>LINKSET_EDITMODE_NONE, "allowed_values"=>null, "depends_on"=>array(), "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
  1 => 'status',
  2 => 'org_id',
  3 => 'email',
  4 => 'phone',
  5 => 'notify',
  6 => 'function',
  7 => 'persons_list',
  8 => 'tickets_list',
  9 => 'cis_list',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
  1 => 'status',
  2 => 'org_id',
  3 => 'email',
  4 => 'phone',
  5 => 'notify',
  6 => 'function',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'status',
  1 => 'org_id',
  2 => 'email',
  3 => 'phone',
));
;
	}


}


class lnkPersonToTeam extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel',
			'key_type' => 'autoincrement',
			'is_link' => true,
			'name_attcode' => array('team_id', 'person_id'),
			'image_attcode' => '',
			'state_attcode' => '',
			'reconc_keys' => array('team_id', 'person_id'),
			'db_table' => 'lnkpersontoteam',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, null),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeExternalKey("team_id", array("targetclass"=>'Team', "allowed_values"=>null, "sql"=>'team_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("team_name", array("allowed_values"=>null, "extkey_attcode"=>'team_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("person_id", array("targetclass"=>'Person', "allowed_values"=>null, "sql"=>'person_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("person_name", array("allowed_values"=>null, "extkey_attcode"=>'person_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("role_id", array("targetclass"=>'ContactType', "allowed_values"=>null, "sql"=>'role_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("role_name", array("allowed_values"=>null, "extkey_attcode"=>'role_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'team_id',
  1 => 'person_id',
  2 => 'role_id',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'team_id',
  1 => 'person_id',
  2 => 'role_id',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'team_id',
  1 => 'person_id',
  2 => 'role_id',
));
;
	}


}


abstract class Typology extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable',
			'key_type' => 'autoincrement',
			'name_attcode' => array('name'),
			'image_attcode' => '',
			'state_attcode' => '',
			'reconc_keys' => array('name', 'finalclass'),
			'db_table' => 'typology',
			'db_key_field' => 'id',
			'db_finalclass_field' => 'finalclass',
			'style' =>  new ormStyle(null, null, null, null, null, null),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeString("name", array("allowed_values"=>null, "sql"=>'name', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
));
		MetaModel::Init_SetZListItems('default_search', array (
  0 => 'name',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'finalclass',
));
;
	}


}


class DocumentType extends Typology
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable',
			'key_type' => 'autoincrement',
			'name_attcode' => array('name'),
			'image_attcode' => '',
			'state_attcode' => '',
			'reconc_keys' => array('name'),
			'db_table' => 'documenttype',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, null),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();



		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'name',
));
;
	}


}


class ContactType extends Typology
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable',
			'key_type' => 'autoincrement',
			'name_attcode' => array('name'),
			'image_attcode' => '',
			'state_attcode' => '',
			'reconc_keys' => array('name'),
			'db_table' => 'contacttype',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, null),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();



		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'name',
));
;
	}


}


abstract class Document extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable',
			'key_type' => 'autoincrement',
			'name_attcode' => '',
			'image_attcode' => '',
			'state_attcode' => 'status',
			'reconc_keys' => array('name', 'org_id', 'org_name', 'finalclass'),
			'db_table' => 'document',
			'db_key_field' => 'id',
			'db_finalclass_field' => 'finalclass',
			'style' =>  new ormStyle(null, null, null, null, null, 'itop-structure/../../images/icons/icons8-documents.svg'),
			'obsolescence_expression' => 'status = \'obsolete\'',);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeString("name", array("allowed_values"=>null, "sql"=>'name', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("org_id", array("targetclass"=>'Organization', "allowed_values"=>null, "sql"=>'org_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("org_name", array("allowed_values"=>null, "extkey_attcode"=>'org_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("documenttype_id", array("targetclass"=>'DocumentType', "allowed_values"=>null, "sql"=>'documenttype_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("documenttype_name", array("allowed_values"=>null, "extkey_attcode"=>'documenttype_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("version", array("allowed_values"=>null, "sql"=>'version', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeText("description", array("allowed_values"=>null, "sql"=>'description', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEnum("status", array("allowed_values"=>new ValueSetEnum("draft,published,obsolete"), "display_style"=>'list', "sql"=>'status', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSetIndirect("contracts_list", array("linked_class"=>'lnkContractToDocument', "ext_key_to_me"=>'document_id', "ext_key_to_remote"=>'contract_id', "allowed_values"=>null, "count_min"=>0, "count_max"=>0, "duplicates"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSetIndirect("services_list", array("linked_class"=>'lnkDocumentToService', "ext_key_to_me"=>'document_id', "ext_key_to_remote"=>'service_id', "allowed_values"=>null, "count_min"=>0, "count_max"=>0, "duplicates"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSetIndirect("cis_list", array("linked_class"=>'lnkDocumentToFunctionalCI', "ext_key_to_me"=>'document_id', "ext_key_to_remote"=>'functionalci_id', "allowed_values"=>null, "count_min"=>0, "count_max"=>0, "duplicates"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));

		// States but no lifecycle declared in XML (status attribute: status)
		//
		MetaModel::Init_DefineState(
			"",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array()
			)
		);
		MetaModel::Init_DefineState(
			"",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array()
			)
		);
		MetaModel::Init_DefineState(
			"",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array()
			)
		);


		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
  1 => 'org_id',
  2 => 'status',
  3 => 'version',
  4 => 'documenttype_id',
  5 => 'description',
  6 => 'cis_list',
  7 => 'contracts_list',
  8 => 'services_list',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
  1 => 'org_id',
  2 => 'status',
  3 => 'documenttype_id',
  4 => 'description',
));
		MetaModel::Init_SetZListItems('default_search', array (
  0 => 'name',
  1 => 'description',
  2 => 'org_id',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'org_id',
  1 => 'status',
  2 => 'documenttype_id',
  3 => 'description',
));
;
	}


}


class DocumentFile extends Document
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable',
			'key_type' => 'autoincrement',
			'name_attcode' => array('name'),
			'image_attcode' => '',
			'state_attcode' => '',
			'reconc_keys' => array('name', 'org_id', 'org_name'),
			'db_table' => 'documentfile',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, 'itop-structure/../../images/icons/icons8-file.svg'),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeBlob("file", array("is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
  1 => 'org_id',
  2 => 'status',
  3 => 'version',
  4 => 'documenttype_id',
  5 => 'description',
  6 => 'file',
  7 => 'cis_list',
  8 => 'contracts_list',
  9 => 'services_list',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
  1 => 'org_id',
  2 => 'status',
  3 => 'documenttype_id',
  4 => 'description',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'org_id',
  1 => 'status',
  2 => 'documenttype_id',
  3 => 'file',
));
;
	}


	/**
	 * Overload the display of the properties to add a tab (the first one)
	 * with the preview of the document
	 */
	
public function DisplayBareProperties(WebPage $oPage, $bEditMode = false, $sPrefix = '', $aExtraParams = array())
	{
		$aFieldsMap = parent::DisplayBareProperties($oPage, $bEditMode, $sPrefix, $aExtraParams);
		if (!$bEditMode)
		{
			$oPage->add('<fieldset>');
			$oPage->add('<legend>'.Dict::S('Class:Document:PreviewTab').'</legend>');
			$oPage->add($this->DisplayDocumentInline($oPage, 'file'));
			$oPage->add('</fieldset>');
		}
		return $aFieldsMap;
	}

}


class DocumentNote extends Document
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable',
			'key_type' => 'autoincrement',
			'name_attcode' => array('name'),
			'image_attcode' => '',
			'state_attcode' => '',
			'reconc_keys' => array('name', 'org_id', 'org_name'),
			'db_table' => 'documentnote',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, 'itop-structure/../../images/icons/icons8-note.svg'),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeHTML("text", array("allowed_values"=>null, "sql"=>'text', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
  1 => 'org_id',
  2 => 'status',
  3 => 'version',
  4 => 'documenttype_id',
  5 => 'description',
  6 => 'text',
  7 => 'cis_list',
  8 => 'contracts_list',
  9 => 'services_list',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
  1 => 'org_id',
  2 => 'status',
  3 => 'documenttype_id',
  4 => 'description',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'org_id',
  1 => 'status',
  2 => 'documenttype_id',
  3 => 'description',
));
;
	}


}


class DocumentWeb extends Document
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable',
			'key_type' => 'autoincrement',
			'name_attcode' => array('name'),
			'image_attcode' => '',
			'state_attcode' => '',
			'reconc_keys' => array('name', 'org_id', 'org_name'),
			'db_table' => 'documentweb',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'style' =>  new ormStyle(null, null, null, null, null, 'itop-structure/../../images/icons/icons8-cloud-file.svg'),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeURL("url", array("target"=>'_blank', "allowed_values"=>null, "sql"=>'url', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
  1 => 'org_id',
  2 => 'status',
  3 => 'version',
  4 => 'description',
  5 => 'url',
  6 => 'cis_list',
  7 => 'contracts_list',
  8 => 'services_list',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
  1 => 'org_id',
  2 => 'status',
  3 => 'description',
  4 => 'url',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'org_id',
  1 => 'status',
  2 => 'description',
  3 => 'url',
));
;
	}


}
//
// Menus
//
class MenuCreation_itop_structure extends ModuleHandlerAPI
{
	public static function OnMenuCreation()
	{
		global $__comp_menus__; // ensure that the global variable is indeed global !
		$__comp_menus__['DataAdministration'] = new MenuGroup('DataAdministration', 70, 'fas fa-folder' , 'Organization', UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['CSVImport'] = new WebPageMenuNode('CSVImport', utils::GetAbsoluteUrlAppRoot()."pages/csvimport.php", $__comp_menus__['DataAdministration']->GetIndex(), 10 , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['Audit'] = new WebPageMenuNode('Audit', utils::GetAbsoluteUrlAppRoot()."pages/audit.php", $__comp_menus__['DataAdministration']->GetIndex(), 33 , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['Catalogs'] = new TemplateMenuNode('Catalogs', '', $__comp_menus__['DataAdministration']->GetIndex(), 50 , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['Organization'] = new OQLMenuNode('Organization', "SELECT Organization", $__comp_menus__['Catalogs']->GetIndex(), 10, true , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null, true);
		$__comp_menus__['ConfigManagement'] = new MenuGroup('ConfigManagement', 20, 'fas fa-database' , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['Contact'] = new DashboardMenuNode('Contact', dirname(__FILE__).'/contact_dashboard.xml', $__comp_menus__['ConfigManagement']->GetIndex(), 2 , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['NewContact'] = new NewObjectMenuNode('NewContact', 'Contact', $__comp_menus__['Contact']->GetIndex(), 3 , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['SearchContacts'] = new SearchMenuNode('SearchContacts', 'Contact', $__comp_menus__['Contact']->GetIndex(), 4, null , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['Location'] = new OQLMenuNode('Location', "SELECT Location", $__comp_menus__['ConfigManagement']->GetIndex(), 3, true , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null, true);
		$__comp_menus__['Document'] = new OQLMenuNode('Document', "SELECT Document", $__comp_menus__['ConfigManagement']->GetIndex(), 6, true , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null, true);
		$__comp_menus__['Typology'] = new DashboardMenuNode('Typology', dirname(__FILE__).'/typology_dashboard.xml', $__comp_menus__['Catalogs']->GetIndex(), 80 , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['TagAdminMenu'] = new WebPageMenuNode('TagAdminMenu', utils::GetAbsoluteUrlAppRoot()."pages/tagadmin.php", $__comp_menus__['Catalogs']->GetIndex(), 100 , 'TagSetFieldData', UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
	}
} // class MenuCreation_itop_structure
