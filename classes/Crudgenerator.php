<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Crudgenerator
 *
 * @author gdt
 */

class CrudGenerator  {
    //put your code here
    protected $db;

    public function __construct()
    {
        $this->db = MySQL::getInstance();
    }
    
    public static function getDBTableAtrribute($table_name)
    {
        $bd = MySQL::getInstance();
		return $bd->query_array('SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME="'.$table_name.'"');
    }

    public static function getDBTable()
    {
        $bd = MySQL::getInstance();
		return $bd->query_array('SHOW TABLES');
    }
    
    public static function getTableAttributesContraintes($table, $field)
    {
        global $_CONFIG;
        $bd = MySQL::getInstance();
        $sql = "SELECT * 
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME='".$table."' 
                    AND TABLE_SCHEMA = '".$_CONFIG['db']['base']."'
                    AND COLUMN_NAME = '".$field."'
                    AND REFERENCED_TABLE_NAME IS NOT NULL";
        return $bd->query_array($sql);
    }
    
    public static function writeCtrlForm()
    {
        $html = "<?php\n";
        $html .= "$"."cssObj->addFichiers(array(
            $"."_CONFIG['admin']['lib'].'select2/select2.css',
            $"."_CONFIG['admin']['lib'].'jquery-toggles/toggles-full.css',
            $"."_CONFIG['admin']['lib'].'timepicker/jquery.timepicker.css',
            $"."_CONFIG['admin']['lib'].'bootstrapcolorpicker/css/bootstrap-colorpicker.css',
            $"."_CONFIG['admin']['lib'].'bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.css',
            $"."_CONFIG['admin']['lib'].'summernote/summernote.css',
        ));\n";
        $html .= "$"."jsObj->addFichiers(array(
                $"."_CONFIG['admin']['lib'].'jquery-toggles/toggles.js',
                $"."_CONFIG['admin']['lib'].'select2/select2.js',
                $"."_CONFIG['admin']['lib'].'bootstrapcolorpicker/js/bootstrap-colorpicker.js',
                $"."_CONFIG['admin']['lib'].'timepicker/jquery.timepicker.js',
                $"."_CONFIG['admin']['lib'].'wysihtml5x/wysihtml5x.js',
                $"."_CONFIG['admin']['lib'].'wysihtml5x/wysihtml5x-toolbar.js',
                $"."_CONFIG['admin']['lib'].'summernote/summernote.js',
                $"."_CONFIG['admin']['lib'].'bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.all.js'
            ));\n";
        $attribute_name = Tools::getValue('key');
        $html .= "$"."formObj = new HelperForm();\n";
        foreach ($attribute_name as $value)
        {
            if(Tools::getValue('table')[$value])
            {
                $tableObj = ucfirst(Tools::getValue('table')[$value]);
                if(!file_exists(ROOT.'classes/'.$tableObj.'.php'))
                {
                    $classe_html .= "<?php\n";
                    $classe_html .= "class ".$file." extends Entite
                                    {
                                        public function __construct(){\n";
                                        $classe_html .= "$"."this->dbtable = '".Tools::getValue('table_name')."';\n";
                $classe_html .= "$"."this->primary_key = '".$id[0]['COLUMN_NAME']."';\n";
                                        $classe_html .= "$"."this->base = MySQL::getInstance();
                                        } 
                                    }";
                    file_put_contents (ROOT.'classes/'.$tableObj.'.php', $classe_html);
                }
                $html .= "$"."fktableObj = new ".$tableObj."();\n";
            }
        }
        $html .= "$"."fields_form = array();\n";
        $html .=  "$"."fields_form []= array(
            'form' =>array(
                'legend' => array(       
                  'title' => '".Tools::getValue('Titre')."',
                  'description' => '".Tools::getValue('Description')."'
                ),
                'input' => array(\n";
        $table_name = Tools::getValue('table_name');
        $file = ucfirst($table_name);
        foreach ($attribute_name as $value)
        {
            if(Tools::getValue('aficher_form')[$value]== 'on' && Tools::getValue('type')[$value])
            {
                if(Tools::getValue('disabled')[$value] != '1')
                    $html .= "\t\t\t\t\t\tarray(\n ";
                if(isset(Tools::getValue('label')[$value]) && Tools::getValue('label')[$value] != '') 
                    $html .= "\t\t\t\t\t\t'label' => '".Tools::getValue('label')[$value]."',\n";
                elseif (Tools::getValue('disabled')[$value] != '1')
                    $html .= "\t\t\t\t\t\t'label' => '".$value."',\n";
                if(isset(Tools::getValue('type')[$value]) && Tools::getValue('type')[$value] != '')
                {
                    if(Tools::getValue('type')[$value] != 'text_enrichi')
                        $html .= "\t\t\t\t\t\t'type' => '".Tools::getValue('type')[$value]."',\n";
                }
                if( $value != '' && Tools::getValue('disabled')[$value] != '1')
                    $html .= "\t\t\t\t\t\t'name' => '".$value."',\n";
                if(isset(Tools::getValue('prefix')[$value]) && Tools::getValue('prefix')[$value] != '')
                    $html .= "\t\t\t\t\t\t'prefix' => '".Tools::getValue('prefix')[$value]."',\n";
                if(isset(Tools::getValue('suffix')[$value]) && Tools::getValue('suffix')[$value] != '')
                    $html .= "\t\t\t\t\t\t'suffix' => '".Tools::getValue('suffix')[$value]."',\n";
                if(Tools::getValue('type')[$value] == 'text_enrichi')
                {
                    $html .= "\t\t\t\t\t\t'type' => 'textarea',\n";
                    $html .= "\t\t\t\t\t\t'class' => 'summernote',\n";
                }
                if(Tools::getValue('type')[$value] == 'select')
                {
                    $html .= "\t\t\t\t\t\t'options' => array(\n";
                    $html .= "\t\t\t\t\t\t\t'query'=>"."$"."fktableObj->Recherche(),\n";
                    $html .= "\t\t\t\t\t\t\t'id' => '".Tools::getValue('fk_value')[$value]."',\n";
                    $html .= "\t\t\t\t\t\t\t'name' => '".Tools::getValue('fk_name')[$value]."'),\n";
                }
                if(Tools::getValue('type')[$value] == 'radio')
                {
                    $html .= "\t\t\t\t\t\t'values' => array(\n";
                    $html .= "\t\t\t\t\t\t\t'query'=>"."$"."fktableObj->Recherche(),\n";
                    $html .= "\t\t\t\t\t\t\t'id' => '".Tools::getValue('fk_value')[$value]."',\n";
                    $html .= "\t\t\t\t\t\t\t'name' => '".Tools::getValue('fk_name')[$value]."'),\n";
                }
                if(Tools::getValue('type')[$value] == 'checkbox')
                {
                    $html .= "\t\t\t\t\t\t'values' => array(\n";
                    $html .= "\t\t\t\t\t\t\t'query'=>"."$"."fktableObj->Recherche(),\n";
                    $html .= "\t\t\t\t\t\t\t'name' => '".Tools::getValue('fk_name')[$value]."'),\n";
                }
                if(Tools::getValue('requied')[$value] == 'on' && Tools::getValue('disabled')[$value] != '1')
                {
                    $requied = "true";
                    $html .= "\t\t\t\t\t\t'required' => ".$requied.",\n";
                }
                $html .="),\n" ;
            }
        }
        $html .= "\t\t\t\t\t),\n";
        $html .= "\t\t\t\t'submit' => array(\n";
        $html .= "\t\t\t\t\t'title' => 'Enregistrer',\n";          
        $html .= " \t\t\t\t\t)\n";
        $html .= "\t\t\t\t));\n";
        $html .= "$"."id = isset("."$"."_GET['id']) ? "."$"."_GET['id'] : 0;\n";
        $primary = CrudGenerator::getTablePrimaryKey($table_name);
        $html .= "$"."tableObj = new ".$file."();\n";

        $html .= "if (Tools::getIsset('submitAddconfiguration'))
        {\n";
         $html .= "$"."recdata = Tools::getPOST();\n";
        
            $html .= "if (!"."$"."id) {
               "."$"."tableObj->InsertData("."$"."recdata);
                Tools::setAlert('Enregistrement effectué avec succès');
            } else { 
                "."$"."tableObj->Update("."$"."recdata, array('".$primary[0]['COLUMN_NAME']."' => "."$"."id));
                Tools::setAlert('Mise à jour effectuée avec succès');
            }

            header('Location:".Tools::getValue('page_des_liste').".html');
            die();
        }\n";

        $html .= "if ("."$"."id > 0) {
            "."$"."tableObj->setId("."$"."id);
            "."$"."formObj->fields_value = "."$"."tableObj->Recherche();   
        }\n";
        $html .= "$"."formgenerate = $"."formObj->generateForm("."$"."fields_form);\n";
        $html .= "$"."smarty->assign('formgenerate',"."$"."formgenerate);";

        return $html;
    }
    
    public static function writeCtrlList()
    {
        $html = "<?php\n";
        $html .= "$"."listObj = new HelperList();\n";
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
        $html .= "$"."tableObj = new ".$file."();\n";
        $html .= "if(Tools::getIsset('delete')){"
            ."$"."tableObj->delete(array('".$id[0]['COLUMN_NAME']."' => Tools::getValue('id')));
        }";
        $html .= "$"."$table_name = $"."tableObj->Recherche();\n";
        if(Tools::getIsset('show_pagination'))
            $html .= "$"."p = ".Tools::getValue('show_pagination').";\n";
        $html .= "$"."tableObj->setLimit((("."$"."p-1) * ".Tools::getValue('show_pagination').").',".Tools::getValue('show_pagination')."');\n";
        $html .= "$"."Total = "."$"."tableObj->getTotal();\n";
        if(Tools::getValue('show_pagination') != '')
            $html .= "$"."nbpages = ceil("."$"."Total/".Tools::getValue('show_pagination').");\n";
        $table_attribute = CrudGenerator::getDBTableAtrribute($table_name);
        $html .= "$"."fields_display = array(\n";
        foreach ($table_attribute as $field)
        {
                $field_name = $field['COLUMN_NAME'];
            if (Tools::getValue('aficher_liste')[$field_name] == 'on')
            {
                if(Tools::getIsset('label') && Tools::getValue('label')[$field_name] != '')
                    $title = Tools::getValue('label')[$field_name];
                else
                    $title = $field_name;
                if(Tools::getValue('type')[$field_name] == 'text' || !Tools::getIsset('type')[$field_name])
                    $html .= "'".$field_name."' => array(
                           'title' => '".$title."',
                           'width' => 140,
                           'type' => 'text',
                       ),\n";
                if(Tools::getValue('type')[$field_name] == 'active')
                    $html .= "'".$field_name."' => array(
                           'title' => '".$title."',
                           'width' => 140,
                           'active' => true,
                       ),\n";
                if(Tools::getValue('type')[$field_name]== 'file')
                    $html .= "'".$field_name."' => array(
                           'title' => '".$title."',
                           'width' => 140,
                           'image' => 's',
                       ),\n";
                if(Tools::getValue('type')[$field_name] == 'date')
                    $html .= "'".$field_name."' => array(
                           'title' => '".$title."',
                           'width' => 140,
                           'date' => 'TRUE',
                       ),\n";
            }
        }
        $html .= ");\n";
        if(Tools::getValue('page_edition') != '')
            $html .= "$"."listObj->actions = array('edit'=>array(
                'title' => Lang::l('Modifier'),
                'url'=>'".Tools::getValue('page_edition').".html',
                'icon'=>'fa fa-pencil',
                'params' => 'edit',
            ),
            'delete');\n";
        else
            $html .= "$"."listObj->actions = array('delete');\n";
        $html .= "$"."listObj->primary = '".$id[0]['COLUMN_NAME']."';\n";
        $html .= "$"."listObj->url = '".Tools::getValue('page_des_liste').".html';\n";
        $html .= "$"."listObj->bulk_actions = true;\n";
        $html .= "$"."listObj->title_list = array(
            'title' => '".Tools::getValue('Titre')."',
            'description' => '".Tools::getValue('Description')."',
            'icon' => 'fa fa-list'
            );";
        $html .= "$"."listObj->bulk_actions = array(
            'Suprimer'=>array(
            'text'=>Lang::l('Suprimer'),
            'icon'=>'fa fa-trash',
            'confirm'=> 'voulez confirmer votre action')
        );\n";
        $html .= "$"."listgenerate = "."$"."listObj->generateList("."$".$table_name.","."$"."fields_display);\n";
        $html .= "$"."smarty->assign('listgenerate',"."$"."listgenerate);";
        return $html;
    }
    
    public static function getTablePrimaryKey($table)
    {
        global $_CONFIG;
        $bd = MySQL::getInstance();
        $sql = "SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME='".$table."' 
                    AND CONSTRAINT_NAME = 'PRIMARY'";
        return $bd->query_array($sql);
    }
}

?>
