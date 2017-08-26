<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$jsObj->addFichiers('gestion/assets/js/crudgenerate.js');

if(Tools::getIsset('tname')){
    
    $attrib = CrudGenerator::getDBTableAtrribute(Tools::getValue('tname'));
    $extraFields = array();
    
    if(isset($attrib))
    {
        foreach ($attrib as $key => $value)
        {
            $fieldInfo = CrudGenerator::getTableAttributesContraintes(Tools::getValue('tname'), $value['COLUMN_NAME']);
            if(is_array($fieldInfo) && count($fieldInfo))
            {
                $extraFields[$value['COLUMN_NAME']]['ref_table']  = $fieldInfo[0]['REFERENCED_TABLE_NAME'];
                $extraFields[$value['COLUMN_NAME']]['ref_column'] = $fieldInfo[0]['REFERENCED_COLUMN_NAME'] ;
                $extraFields[$value['COLUMN_NAME']]['ref_fields'] = CrudGenerator::getDBTableAtrribute($fieldInfo[0]['REFERENCED_TABLE_NAME']);
            }

        }
    }
    $smarty->assign(array(
        'attrib' => $attrib,
        'extraFields' => $extraFields,
    ));
    
    echo $smarty->fetch('./default/table-attribute.tpl');
    die();
}
$smarty->assign('entities', CrudGenerator::getDBTable());


if(Tools::getIsset('submitTablecrud'))
{
    $table_name = Tools::getValue('table_name');
    $file = ucfirst($table_name);
    $id = CrudGenerator::getTablePrimaryKey($table_name);
    if(!file_exists(ROOT.'classes/'.$file.'.php'))
    {
        $classe_html .= "<?php\n";
        $classe_html .= "class ".$file." extends Entite
                        {
                            public function __construct(){\n";
                            $classe_html .= "$"."this->dbtable = '".$table_name."';\n";
    $classe_html .= "$"."this->primary_key = '".$id[0]['COLUMN_NAME']."';\n";
                            $classe_html .= "$"."this->base = MySQL::getInstance();
                            } 
                        }";
        file_put_contents (ROOT.'classes/'.$file.'.php', $classe_html);
    }
    if( Tools::getIsset('page_edition'))
    {
        $create_tpl = file_put_contents('../gestion/templates/default/'.Tools::getValue('page_edition').'.tpl', "{"."$"."formgenerate}");
        $create_ctrl = file_put_contents('../gestion/controllers/ctrl/'.Tools::getValue('page_edition').'.php', CrudGenerator::writeCtrlForm());
    }
    if( Tools::getIsset('page_des_liste'))
    {
        $create_tpl = file_put_contents('../gestion/templates/default/'.Tools::getValue('page_des_liste').'.tpl', "{"."$"."listgenerate}");
        $create_ctrl = file_put_contents('../gestion/controllers/ctrl/'.Tools::getValue('page_des_liste').'.php', CrudGenerator::writeCtrlList());
    }
}

?>
