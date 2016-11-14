<?php
/**
 * @author JoomlaShine.com Team
 * @copyright JoomlaShine.com
 * @link joomlashine.com
 * @package JSN ImageShow
 * @version $Id: jsn_is_upgradethemedb.php 12371 2012-04-27 10:16:35Z giangnd $
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die( 'Restricted access' );
include_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_imageshow'.DS.'classes'.DS.'jsn_is_dbutils.php');
//include_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_imageshow'.DS.'classes'.DS.'jsn_js_backup.php');

class JSNISUpgradeThemeDB
{
	var $_fileName 		  		= 'db_schema_upgrade.xml';
	var $_mainfest		  		= null;
	var $_oldPlugin		  		= null;
	var $_previousVersion 		= null;
	var $_currentVersion  		= null;
	var $_versionIndexes  		= array();
	var $_currentTables   		= array();
	var $_objJSNISDBUtils 		= null;
	var $_items			  		= array();
	var $_itemChangedValues	 	= array();
	var $_folder				= '';
	var $_group					= '';

	function __construct($manifest, $objOldPlugin)
	{
		$this->setManifest($manifest);
		$this->setObjOldPlugin($objOldPlugin);
		$this->setObjJSNISDBUtils();
		$this->setPreviousVersion();
		$this->setCurrentVersion();
		$this->setGroup();
		$this->setFolder();
		$this->parserXMLContent();
	}

	function setObjJSNISDBUtils()
	{
		$this->_objJSNISDBUtils = new JSNISDBUtils();
	}

	function setManifest($manifest)
	{
		$this->_mainfest = $manifest;
	}

	function setObjOldPlugin($object)
	{
		$this->_oldPlugin = $object;
	}

	function setGroup()
	{
		$attributes = $this->_mainfest->attributes();
		$this->_group	= $attributes['group'];
	}

	function setFolder()
	{
		$name   		= trim($this->_mainfest->name);
		$name			= strtolower($name);
		$name			= str_replace(' ', '', $name);
		$this->_folder 	= $name;
	}

	function setPreviousVersion()
	{
		$this->_previousVersion	= $this->_oldPlugin->version;
	}

	function setCurrentVersion()
	{
		$version     			= $this->_mainfest->version;
		$this->_currentVersion	= (string) $version;
	}

	function getIndexes($key)
	{
		return $this->_versionIndexes[$key];
	}

	function setVersionIndex($key, $value)
	{
		$this->_versionIndexes[$key] = $value;
	}

	function getEndVersionIndex()
	{
		return end($this->_versionIndexes);
	}

	function getStartVersionIndex()
	{
		$previousVersion = $this->_previousVersion;
		if (isset($this->_versionIndexes[$previousVersion]))
		{
			return $this->_versionIndexes[$previousVersion];
		}
		else
		{
			$previousVersion = (float) str_replace('.', '', $previousVersion);
			foreach ($this->_versionIndexes as $key => $value)
			{
				$tmpPreviousVersion = (float) str_replace('.', '', $key);
				if ($tmpPreviousVersion > $previousVersion)
				{
					return $value;
				}
			}
		}
	}

	function setCurrentTable($key, $value)
	{
		$this->_currentTables[$key] = $value;
	}

	function extractArray($data, $begin, $end)
	{
		$newData = array();
		if (count($data))
		{
			if (!is_null($begin))
			{
				for($i = $begin; $i <= $end; $i++)
				{
					$newData [] = $data[$i];
				}
			}
			else
			{
				$newData [] = $data[$end];
			}
		}
		return $newData;
	}

	function extractVersionRange()
	{
		$items 		   = $this->_items;
		$startIndex    = $this->getStartVersionIndex();
		$endIndex      = $this->getEndVersionIndex();
		$items 		   = $this->extractArray($items, $startIndex, $endIndex);
		return $items;
	}

	function parserXMLContent()
	{
		$versionsArray			= array();
		$filePath 				= JPATH_ROOT.DS.'plugins'.DS.$this->_group.DS.$this->_folder.DS.'helper'.DS.$this->_fileName;
		$xml 				 	= JFactory::getXML($filePath);

		if(!$xml)
		{
			return false;
		}

		$document	= $xml;

		if(isset($document->version))
		{
			$versions = $document->version;
			if (count($versions))
			{
				for($i = 0, $count = count($versions); $i < $count; $i++)
				{
					$tablesArray		= array();
					$version    		= $versions[$i];
					$versionAttributes  = $version->attributes();
					$objVersion			= new stdClass();
					$objVersion->number = (string) $versionAttributes->number;
					$this->setVersionIndex((string) $versionAttributes->number, $i);

					if(isset($version->tables))
					{
						$tables 	 = $version->tables;
						$tableParent = $tables[0]->table;

						if(count($tableParent))
						{
							for ($j = 0, $count1 = count($tableParent); $j < $count1; $j++)
							{
								$fieldsArray 		= array();
								$table 				= $tableParent[$j];
								$tableAttributes 	= $table->attributes();

								$objTable 			= new stdClass();
								$objTable->id	    = (isset($tableAttributes->id)?(string) $tableAttributes->id:'');
								$objTable->status   = (isset($tableAttributes->status)?(string) $tableAttributes->status:'');
								$objTable->name	    = (isset($tableAttributes->name)?(string) $tableAttributes->name:'');

								$fields				= $table->field;
								if(count($fields))
								{
									for ($z = 0, $count2 = count($fields); $z < $count2; $z++)
									{
										$field						= $fields[$z];
										$fieldAttributes 			= $field->attributes();

										$objField					= new stdClass();
										$objField->id				= (string) $fieldAttributes->id;
										$objField->status			= (string) $fieldAttributes->status;
										$objField->name				= (isset($fieldAttributes->name)?(string) $fieldAttributes->name:'');
										$objField->type				= (isset($fieldAttributes->type)?(string) $fieldAttributes->type:'');
										$objField->primary_key		= (isset($fieldAttribute->primary_key)?(string) $fieldAttributes->primary_key:'');
										$objField->default_value	= (isset($fieldAttributes->default_value)?(string) $fieldAttributes->default_value:'');
										$objField->not_null			= (isset($fieldAttributes->not_null)?(string) $fieldAttributes->not_null:'yes');
										$fieldsArray []				= $objField;
										$datas						= $field->data;

										if (count($datas))
										{
											for ($x = 0, $count3 = count($datas); $x < $count3; $x++)
											{
												$data 						= $datas[$x];
												$dataAttributes 			= $data->attributes();
												$objData					= new stdClass();
												$objData->oldvalue			= (string) $dataAttributes->oldvalue;
												$objData->newvalue			= (string) $dataAttributes->newvalue;
												$this->_itemChangedValues[(string) $fieldAttributes->id][]	= $objData;
											}
										}
									}
								}
								$objTable->fields	= $fieldsArray;
								$tablesArray []		= $objTable;
							}

						}

					}
					$objVersion->tables 	= $tablesArray;
					$versionsArray []		= $objVersion;
				}
			}
		}
		$this->_items = $versionsArray;

	}

	function getTableStatus($status)
	{
		$tableResult   = array();
		$fieldIDs	   = array();
		$items         = $this->_items;

		for ($i = 0, $count = count($items); $i < $count; $i++)
		{
			$data     	   = $items[$i];
			$tables        = $data->tables;
			if (count($tables))
			{
				for ($j = 0, $count1 = count($tables); $j < $count1; $j++)
				{
					$table    	= $tables[$j];
					$tableName  = $table->name;
					$result		= array();
					if (JString::strtolower($table->status) == JString::strtolower($status))
					{
						$fields      = $table->fields;
						if (count($fields) && JString::strtolower($table->status) == 'added')
						{
							for ($z = 0, $count2 = count($fields); $z < $count2; $z++)
							{
								$obj 		  	  	= new stdClass();
								$field   	  	  	= $fields[$z];
								$obj->id      	  	= $field->id;
								$obj->status  	  	= $field->status;
								$obj->name    	  	= $field->name;
								$obj->type    	  	= $field->type;
								$obj->primary_key 	= (isset($field->primary_key)?$field->primary_key:'');
								$obj->default_value	= (isset($field->default_value)?$field->default_value:'');
								$obj->not_null	  	= (isset($field->not_null)?$field->not_null:'yes');
								$result []    	  	= $obj;
							}
							$tableResult [$tableName] = $result;
						}
						else
						{
							$tableResult [] = $tableName;
						}

					}
				}
			}
		}

		return $tableResult;
	}

	function searchField($tableID, $fieldID)
	{
		$result	= array();
		$items  = $this->_items;

		for ($i = 0, $count = count($items); $i < $count; $i++)
		{
			$data     = $items[$i];
			$tables   = $data->tables;
			$version  = $data->number;

			if (count($tables))
			{
				for ($j = 0, $count1 = count($tables); $j < $count1; $j++)
				{
					$table = $tables[$j];
					if ($table->id == $tableID)
					{
						$fields = $table->fields;
						if (count($fields))
						{
							for ($z = 0, $count2 = count($fields); $z < $count2; $z++)
							{
								$obj = new stdClass();
								$field = $fields[$z];

								if($field->id == $fieldID && JString::strtolower($field->status) != 'removed')
								{
									$obj->index   		= $i;
									$obj->id      		= $field->id;
									$obj->version 		= $version;
									$obj->status  		= $field->status;
									$obj->name    		= $field->name;
									$obj->type    		= $field->type;
									$obj->not_null		= $field->not_null;
									$obj->default_value	= (isset($field->default_value)?$field->default_value:'');
									$result []    = $obj;
									break;
								}
							}
						}
						break;
					}
				}
			}
		}
		return $result;
	}

	function getFieldChanged($items)
	{
		$tableResult   = array();
		$fieldIDs	   = array();
		for ($i = 0, $count = count($items); $i < $count; $i++)
		{
			$data     	   = $items[$i];
			$version       = $data->number;
			$tables        = $data->tables;
			if (count($tables))
			{
				for ($j = 0, $count1 = count($tables); $j < $count1; $j++)
				{

					$table         = $tables[$j];
					$tableName     = $table->name;
					$tableID       = $table->id;
					$tableStatus   = $table->status;

					if (JString::strtolower($tableStatus) == 'changed')
					{
						$fields      = $table->fields;

						if (count($fields))
						{
							for ($z = 0, $count2 = count($fields); $z < $count2; $z++)
							{
								$field   	 = $fields[$z];
								$fieldID 	 = $field->id;
								$fieldStatus = JString::strtolower($field->status);

								if ($fieldStatus == 'changed' && !in_array($fieldID, $fieldIDs))
								{
									$tableResult [$tableName][] = $this->searchField($tableID, $fieldID);
									$fieldIDs []    			= $fieldID;
								}
							}
						}
					}
				}
				$fieldIDs = array_unique($fieldIDs);
			}
		}

		return $tableResult;
	}

	function getFieldAdded($items)
	{

		$tableResult   = array();
		for ($i = 0, $count = count($items); $i < $count; $i++)
		{
			$data     	   = $items[$i];
			$version       = $data->number;
			$tables        = $data->tables;
			if (count($tables))
			{
				for ($j = 0, $count1 = count($tables); $j < $count1; $j++)
				{
					$table         = $tables[$j];
					$tableName     = $table->name;
					$tableID       = $table->id;
					$tableStatus   = $table->status;

					if (JString::strtolower($tableStatus) == 'changed')
					{
						$fields      = $table->fields;

						if (count($fields))
						{
							for ($z = 0, $count2 = count($fields); $z < $count2; $z++)
							{

								$field   	 = $fields[$z];
								$fieldID 	 = $field->id;
								$fieldStatus = $field->status;
								$obj 		 = new stdClass();
								if (JString::strtolower($fieldStatus) == 'added')
								{

									$obj->index   				= $i;
									$obj->id     				= $field->id;
									$obj->version 				= $version;
									$obj->status  				= $field->status;
									$obj->name    				= $field->name;
									$obj->type    				= $field->type;
									$obj->default_value			= (isset($field->default_value)?$field->default_value:'');
									$obj->not_null				= (isset($field->not_null)?$field->not_null:'');
									$tableResult [$tableName][] = $obj;
								}
							}
						}
					}
				}
			}
		}

		return $tableResult;
	}

	function getFieldRemoved($items)
	{
		$tableResult   = array();
		for ($i = 0, $count = count($items); $i < $count; $i++)
		{
			$data     	   = $items[$i];
			$version       = $data->number;
			$tables        = $data->tables;
			if (count($tables))
			{
				for ($j = 0, $count1 = count($tables); $j < $count1; $j++)
				{
					$table         = $tables[$j];
					$tableName     = $table->name;
					$tableID       = $table->id;
					$tableStatus   = $table->status;

					if (JString::strtolower($tableStatus) == 'changed')
					{
						$fields      = $table->fields;

						if (count($fields))
						{
							for ($z = 0, $count2 = count($fields); $z < $count2; $z++)
							{

								$field   	 = $fields[$z];
								$fieldID 	 = $field->id;
								$fieldStatus = $field->status;
								$obj 		 = new stdClass();
								if (JString::strtolower($fieldStatus) == 'removed')
								{
									$obj->index   				= $i;
									$obj->id      				= $field->id;
									$obj->version = $version;
									$obj->status  = $field->status;
									$obj->name    = $field->name;
									$tableResult [$tableName][] = $obj;
								}
							}
						}
					}
				}
			}
		}

		return $tableResult;
	}

	function processData()
	{
		$queries			= array();
		$previouseVersion   = (float) str_replace('.', '', $this->_previousVersion);
		$currentVersion   	= (float) str_replace('.', '', $this->_currentVersion);
		if($previouseVersion == $currentVersion) return $queries;
		$items   			= $this->extractVersionRange();
		$preDataAdd    		= $this->getFieldAdded($items);
		$preDataChange 		= $this->getFieldChanged($items);
		$preDataRemove 		= $this->getFieldRemoved($items);

		$dataChange			= $this->processDataChanged($preDataChange);

		$queriesChange 					= $this->buildQueriesChange($dataChange);
		$queriesFieldDataChange 		= $this->buildQueriesFieldDataChange($dataChange);

		$tableRemoved   	= $this->getTableStatus('removed');
		$queriesTableRemove	= $this->buildQueriesTableRemove($tableRemoved);

		$tableAdded   	    = $this->getTableStatus('added');
		$queriesTableAdd	= $this->buildQueriesTableAdd($tableAdded, $dataChange, $tableRemoved);

		if(count($queriesTableAdd))
		{
			if(isset($queriesTableAdd['create']) && count($queriesTableAdd['create']))
			{
				$queries = array_merge($queries, $queriesTableAdd['create']);
			}
		}
		$dataAdd 			= $this->processDataAdded($preDataAdd);
		$queriesAdd 		= $this->buildQueriesAdd($dataAdd);

		if(count($queriesAdd))
		{
			//$queries = array_merge($queries, $queriesAdd);
			$this->executeQueries($queriesAdd);
		}

		if(count($queriesChange))
		{
			//$queries = array_merge($queries, $queriesChange);
			$this->executeQueries($queriesChange);
		}

		if(count($queriesFieldDataChange))
		{
			$queries = array_merge($queries, $queriesFieldDataChange);
		}

		$dataRemove			= $this->processDataRemoved($preDataRemove);
		$queriesRemove 		= $this->buildQueriesRemove($dataRemove);

		if(count($queriesRemove))
		{
			$queries = array_merge($queries, $queriesRemove);
		}

		if(count($queriesTableAdd))
		{
			if(isset($queriesTableAdd['insert']) && count($queriesTableAdd['insert']))
			{
				$queries = array_merge($queries, $queriesTableAdd['insert']);
			}

			if(isset($queriesTableAdd['alter']) && count($queriesTableAdd['alter']))
			{
				$queries = array_merge($queries, $queriesTableAdd['alter']);
			}
		}

		if(count($queriesTableRemove))
		{
			$queries = array_merge($queries, $queriesTableRemove);
		}

		return $queries;
	}

	function executeUpgradeDB()
	{
		$db		= JFactory::getDBO();
		$data 	= $this->processData();

		if (count($data))
		{
			foreach ($data as $value)
			{
				if ($value != '')
				{
					$db->setQuery($value);
					$db->query();
				}
			}
		}
		return true;
	}

	function buildQueriesTableAdd($data, $dataChange, $tableRemoved)
	{
		$queries = array();

		if(count($data))
		{
			foreach ($data as $key => $value)
			{
				$flagSearchTable  = false;

				if(in_array($key, $tableRemoved) || $this->_objJSNISDBUtils->isExistTable($key)) continue;

				$tableName   	  = $key;
				$sourceDropField  = '';
				$sourceField 	  = '';
				$destinationField = '';
				$sourceTableName  = '';
				$queryDrop        = '';
				$queryInsert      = '';
				$query 		 	  = 'CREATE TABLE `'.$tableName.'` (';

				for($i = 0, $count = count($value); $i < $count; $i++)
				{
					$item   = $value[$i];
					if($item->not_null == 'yes')
					{
						$notNull = 'NULL';
					}
					else
					{
						$notNull = 'NOT NULL';
					}

					if(JString::strtolower($item->primary_key) == 'yes')
					{
						$query 		.= '`'.$item->name.'` '.$item->type.' '.$notNull.' auto_increment,';
						$primaryKey  = $item->name;
						if(JString::strtolower($item->status) == 'changed')
						{
							$destinationField 	.= '`'.$item->name.'`, ';
						}
					}
					else
					{
						if($item->default_value != '' && JString::strtolower($item->default_value) == 'null')
						{

							$defaultValue = ' '.$notNull.' default '.$item->default_value;
						}
						else
						{
							$defaultValue = ' '.$notNull.' default '.'\''.$item->default_value.'\'';
						}

						$query 				.= '`'.$item->name.'` '.$item->type.$defaultValue.',';
						if(JString::strtolower($item->status) == 'changed')
						{
							$destinationField 	.= '`'.$item->name.'`, ';
						}
					}

					if(JString::strtolower($item->status) == 'changed')
					{
						$resultSearch 		= $this->searchFieldChanged($dataChange, $item->id);
						$resultSearchAll 	= $this->searchAllFields($item->id, $tableName);
						if($resultSearch != false)
						{
							$sourceField 		.= '`'.$resultSearch.'`, ';
							$sourceDropField 	.= 'DROP `'.$resultSearch.'`, ';
						}
						elseif ($resultSearchAll != false)
						{
							$sourceField 		.= '`'.$resultSearchAll.'`, ';
							$sourceDropField 	.= 'DROP `'.$resultSearchAll.'`, ';

						}
					}

					if($flagSearchTable == false && JString::strtolower($item->status) == 'changed')
					{
						$sourceTableName = $this->searchTableByFieldID($item->id, $tableName);
						$flagSearchTable = true;
					}
				}

				if($sourceTableName != '')
				{
					$queryDrop 	      = 'ALTER TABLE `'.$sourceTableName.'` '.substr($sourceDropField, 0, -2);
				}

				$query 			 .= ' PRIMARY KEY (`'.$primaryKey.'`)';
				$query 			 .= ') DEFAULT CHARSET=utf8';
				if($sourceTableName != '')
				{
					$queryInsert 	  = 'INSERT `'.$tableName.'` (';
					$queryInsert 	 .= substr($destinationField, 0, -2);
					$queryInsert 	 .= ') ';
					$queryInsert 	 .= 'SELECT '.substr($sourceField, 0, -2).' FROM `'.$sourceTableName.'`';
				}
				$queries ['create'] [] = $query;
				$queries ['insert'] [] = $queryInsert;
				$queries ['alter'] []  = $queryDrop;
			}
		}
		return $queries;
	}

	function buildQueriesTableRemove($data)
	{
		$queries = array();
		if(count($data))
		{
			foreach ($data as $value)
			{
				if($this->_objJSNISDBUtils->isExistTable($value))
				{
					$queries [] = 'DROP TABLE `'.$value.'`';
				}
			}
		}

		return $queries;
	}

	function processDataChanged($data)
	{
		$tableResult = array();
		if(count($data))
		{
			foreach ($data as $key => $tables)
			{
				$tableName = $key;
				if($this->_objJSNISDBUtils->isExistTable($tableName))
				{
					if(count($tables))
					{
						foreach ($tables as $fields)
						{
							$tmpArray = array();
							if(count($fields))
							{
								for ($i = 0, $count = count($fields); $i < $count; $i++)
								{
									$field = $fields[$i];
									if($field->version == $this->_previousVersion)
									{
										$originalFieldName = $field->name;
										break;
									}
									elseif ($this->_objJSNISDBUtils->isExistTableColumn($tableName, $field->name))
									{
										$originalFieldName = $field->name;
										break;
									}
	
								}
	
								$lastElement = end($fields);
								$tmpArray [$originalFieldName] = array('type' => $lastElement->type, 'change' => $lastElement->name, 'id' => $lastElement->id, 'not_null' => $lastElement->not_null, 'default_value' => @$lastElement->default_value);
								$tableResult [$tableName][]   	   = $tmpArray;
							}
						}
					}
				}
			}
		}

		return $tableResult;
	}

	function processDataAdded($data)
	{
		$tableResult = array();
		if(count($data))
		{
			foreach ($data as $key => $fields)
			{
				$tmpArray 	= array();
				$tableName 	= $key;
				if(count($fields))
				{
					for ($i = 0, $count = count($fields); $i < $count; $i++)
					{
						$field 						= $fields[$i];
						$tmpArray [$field->name] 	= array('type' => $field->type, 'default' => $field->default_value, 'id' => $field->id, 'not_null' => $field->not_null);
					}
					$tableResult [$tableName] = $tmpArray;
				}
			}
		}
		return $tableResult;
	}

	function processDataRemoved($data)
	{
		//$previousVersion = (float) $this->_previousVersion;
		//$currentVersion  = (float) '3.0.0';
		//$inclusiveFields = array();
		$tableResult 	 = array();
		if(count($data))
		{
			foreach ($data as $key => $fields)
			{
				$tmpArray 		= array();
				$tableName 		= $key;
				if(count($fields))
				{
					for ($i = 0, $count = count($fields); $i < $count; $i++)
					{
						$field	= $fields[$i];
						/*if (($previousVersion < $currentVersion) && $tableName == '#__imageshow_showcase')
						 {
							$inclusiveFields [] = $field->name;
							}*/
						$tmpArray [$field->name] 	= array('id' => $field->id);
					}

					$tableResult [$tableName] = $tmpArray;
				}

				/*if(($previousVersion < $currentVersion) && count($inclusiveFields) && $tableName == '#__imageshow_showcase')
				 {
					$objISBackup = JSNISBackup::getInstance();
					$arrayTable  = array('showcase'=>'#__imageshow_showcase');
					$objISBackup->writeXMLDataFile('jsn_is_showcase_backup.xml', $arrayTable, $inclusiveFields);
					}*/
			}
		}

		return $tableResult;
	}

	function buildQueriesAdd($data)
	{
		$queries = array();

		if (count($data))
		{
			foreach ($data as $key => $fields)
			{
				$table = $key;

				foreach ($fields as $subKey => $field)
				{
					if($field['not_null'] == 'yes')
					{
						$notNull = 'NULL';
					}
					else
					{
						$notNull = 'NOT NULL';
					}

					if (!$this->_objJSNISDBUtils->isExistTableColumn($table, $subKey))
					{
						$query = 'ALTER TABLE `'.$table.'` ADD `'.$subKey.'` '.$field['type'].' '.$notNull.' DEFAULT';
						if($field['default'] != '' && JString::strtolower($field['default']) == 'null')
						{
							$queries []	= $query.' '.$field['default'];
						}
						else
						{
							$queries []	= $query.' \''.$field['default'].'\'';
						}
					}
				}
			}
		}
		return $queries;
	}

	function buildQueriesRemove($data)
	{
		$queries = array();

		if (count($data))
		{
			foreach ($data as $key => $fields)
			{
				$table = $key;

				foreach ($fields as $subKey => $field)
				{
					if ($this->_objJSNISDBUtils->isExistTableColumn($table, $subKey))
					{
						$queries []	= 'ALTER TABLE `'.$table.'` DROP `'.$subKey.'`';
					}
				}
			}
		}

		return $queries;
	}

	function buildQueriesFieldDataChange($data, $checkColumn = false)
	{
		$queries = array();
		if(count($data))
		{
			foreach ($data as $k1 => $fields)
			{
				$table = $k1;

				foreach ($fields as $k1 => $field)
				{
					foreach ($field as $k2 => $value)
					{
						if ($checkColumn && !$this->_objJSNISDBUtils->isExistTableColumn($table, $value['change'])) continue;
						$items = $this->_itemChangedValues[$value['id']];
						if (count($items))
						{
							foreach ($items as $item)
							{
								$queries []	= 'UPDATE `'.$table.'` SET `'.$value['change'].'` = "'.$item->newvalue.'" WHERE `'.$value['change'].'` = "'.$item->oldvalue.'"';
							}
						}
					}
				}
			}
		}
		return $queries;
	}

	function buildQueriesChange($data)
	{
		$queries = array();
		if(count($data))
		{
			foreach ($data as $k1 => $fields)
			{
				$table = $k1;

				foreach ($fields as $k1 => $field)
				{
					foreach ($field as $k2 => $value)
					{
						if($value['not_null'] == 'yes')
						{
							$notNull = 'NULL';
						}
						else
						{
							$notNull = 'NOT NULL';
						}
						if(isset($value['default_value']) && $value['default_value']!= '')
						{
							$defaultValue = ' DEFAULT "'.$value['default_value'].'"';
						}
						else
						{
							$defaultValue = '';
						}
						if ($this->_objJSNISDBUtils->isExistTableColumn($table, $k2))
						{
							$queries []	= 'ALTER TABLE `'.$table.'` CHANGE `'.$k2.'` `'.$value['change'].'` '.$value['type'].' '.$notNull.$defaultValue;
						}
					}
				}
			}
		}
		return $queries;
	}

	function searchFieldChanged($data, $fieldID)
	{
		if(count($data))
		{
			foreach ($data as $k1 => $items)
			{
				$table = $k1;

				foreach ($items as $k1 => $item)
				{
					foreach ($item as $k2 => $value)
					{
						if($value['id'] == $fieldID)
						{
							return $value['change'];
						}
					}
				}
			}
		}
		return false;
	}

	function searchAllFields($fieldID, $tableName = '')
	{
		$items  = $this->_items;
		for ($i = 0, $count = count($items); $i < $count; $i++)
		{
			$data     = $items[$i];
			$tables   = $data->tables;

			if (count($tables))
			{
				for ($j = 0, $count1 = count($tables); $j < $count1; $j++)
				{
					$table  = $tables[$j];
					$fields = $table->fields;
					$name  	= $table->name;
					if (count($fields))
					{
						for ($z = 0, $count2 = count($fields); $z < $count2; $z++)
						{
							$obj = new stdClass();
							$field = $fields[$z];

							if($field->id == $fieldID && $name != $tableName)
							{
								return $field->name;
							}
						}
					}
				}
			}
		}
		return false;
	}

	function searchTableByFieldID($fieldID, $tableName)
	{
		$items     = $this->_items;
		$name 	   = '';
		for ($i = 0, $count = count($items); $i < $count; $i++)
		{
			$data     = $items[$i];
			$tables   = $data->tables;

			if (count($tables))
			{
				for ($j = 0, $count1 = count($tables); $j < $count1; $j++)
				{
					$table      = $tables[$j];
					$fields     = $table->fields;
					$name  		= $table->name;

					if (count($fields))
					{
						for ($z = 0, $count2 = count($fields); $z < $count2; $z++)
						{
							$field = $fields[$z];

							if($field->id == $fieldID && $name != $tableName)
							{
								return $name;
							}
						}
					}
				}
			}
		}

		return $name;
	}

	function executeQueries($data)
	{
		$db		= JFactory::getDBO();
		if (count($data))
		{
			foreach ($data as $value)
			{
				if ($value != '')
				{
					$db->setQuery($value);
					$db->query();
				}
			}
		}
		return true;
	}
}
?>