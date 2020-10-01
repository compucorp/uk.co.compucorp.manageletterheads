<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from /var/www/site2/profiles/compuclient/modules/contrib/civicrm/ext/uk.co.compucorp.manageletterheads/xml/schema/CRM/ManageLetterheads/Letterhead.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:01fe18406abe9f1187d7903648774fcc)
 */

/**
 * Database access object for the Letterhead entity.
 */
class CRM_ManageLetterheads_DAO_Letterhead extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_manageletterheads_letterhead';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique Letterhead ID
   *
   * @var int
   */
  public $id;

  /**
   * Letterhead Title
   *
   * @var string
   */
  public $title;

  /**
   * Letterhead Name
   *
   * @var string
   */
  public $name;

  /**
   * Letterhead Description
   *
   * @var string
   */
  public $description;

  /**
   * Letterhead Description
   *
   * @var longtext
   */
  public $content;

  /**
   * Controls display sort order.
   *
   * @var int
   */
  public $weight;

  /**
   * Whether the letterhead is disabled or not
   *
   * @var bool
   */
  public $is_active;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_manageletterheads_letterhead';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   */
  public static function getEntityTitle() {
    return ts('Letterheads');
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => CRM_ManageLetterheads_ExtensionUtil::ts('Unique Letterhead ID'),
          'required' => TRUE,
          'where' => 'civicrm_manageletterheads_letterhead.id',
          'table_name' => 'civicrm_manageletterheads_letterhead',
          'entity' => 'Letterhead',
          'bao' => 'CRM_ManageLetterheads_DAO_Letterhead',
          'localizable' => 0,
          'add' => NULL,
        ],
        'title' => [
          'name' => 'title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => CRM_ManageLetterheads_ExtensionUtil::ts('Title'),
          'description' => CRM_ManageLetterheads_ExtensionUtil::ts('Letterhead Title'),
          'required' => TRUE,
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_manageletterheads_letterhead.title',
          'table_name' => 'civicrm_manageletterheads_letterhead',
          'entity' => 'Letterhead',
          'bao' => 'CRM_ManageLetterheads_DAO_Letterhead',
          'localizable' => 0,
          'add' => NULL,
        ],
        'name' => [
          'name' => 'name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => CRM_ManageLetterheads_ExtensionUtil::ts('Name'),
          'description' => CRM_ManageLetterheads_ExtensionUtil::ts('Letterhead Name'),
          'required' => TRUE,
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_manageletterheads_letterhead.name',
          'table_name' => 'civicrm_manageletterheads_letterhead',
          'entity' => 'Letterhead',
          'bao' => 'CRM_ManageLetterheads_DAO_Letterhead',
          'localizable' => 0,
          'add' => NULL,
        ],
        'description' => [
          'name' => 'description',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => CRM_ManageLetterheads_ExtensionUtil::ts('Description'),
          'description' => CRM_ManageLetterheads_ExtensionUtil::ts('Letterhead Description'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_manageletterheads_letterhead.description',
          'table_name' => 'civicrm_manageletterheads_letterhead',
          'entity' => 'Letterhead',
          'bao' => 'CRM_ManageLetterheads_DAO_Letterhead',
          'localizable' => 0,
          'add' => NULL,
        ],
        'content' => [
          'name' => 'content',
          'type' => CRM_Utils_Type::T_LONGTEXT,
          'title' => CRM_ManageLetterheads_ExtensionUtil::ts('Content'),
          'description' => CRM_ManageLetterheads_ExtensionUtil::ts('Letterhead Description'),
          'required' => TRUE,
          'where' => 'civicrm_manageletterheads_letterhead.content',
          'table_name' => 'civicrm_manageletterheads_letterhead',
          'entity' => 'Letterhead',
          'bao' => 'CRM_ManageLetterheads_DAO_Letterhead',
          'localizable' => 0,
          'add' => NULL,
        ],
        'weight' => [
          'name' => 'weight',
          'type' => CRM_Utils_Type::T_INT,
          'title' => CRM_ManageLetterheads_ExtensionUtil::ts('Order'),
          'description' => CRM_ManageLetterheads_ExtensionUtil::ts('Controls display sort order.'),
          'required' => TRUE,
          'where' => 'civicrm_manageletterheads_letterhead.weight',
          'table_name' => 'civicrm_manageletterheads_letterhead',
          'entity' => 'Letterhead',
          'bao' => 'CRM_ManageLetterheads_DAO_Letterhead',
          'localizable' => 0,
          'add' => NULL,
        ],
        'is_active' => [
          'name' => 'is_active',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'description' => CRM_ManageLetterheads_ExtensionUtil::ts('Whether the letterhead is disabled or not'),
          'required' => TRUE,
          'where' => 'civicrm_manageletterheads_letterhead.is_active',
          'default' => '1',
          'table_name' => 'civicrm_manageletterheads_letterhead',
          'entity' => 'Letterhead',
          'bao' => 'CRM_ManageLetterheads_DAO_Letterhead',
          'localizable' => 0,
          'add' => NULL,
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'manageletterheads_letterhead', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'manageletterheads_letterhead', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}