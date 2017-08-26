<?php
$cssObj->addFichiers(array(
        $_CONFIG['admin']['lib'].'select2/select2.css',
        $_CONFIG['admin']['lib'].'jquery-toggles/toggles-full.css',
        $_CONFIG['admin']['lib'].'timepicker/jquery.timepicker.css',
        $_CONFIG['admin']['lib'].'bootstrapcolorpicker/css/bootstrap-colorpicker.css',
        $_CONFIG['admin']['lib'].'bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.css',
        $_CONFIG['admin']['lib'].'summernote/summernote.css',
    ));
$jsObj->addFichiers(array(
		$_CONFIG['admin']['lib'].'jquery-toggles/toggles.js',
		$_CONFIG['admin']['lib'].'select2/select2.js',
        $_CONFIG['admin']['lib'].'bootstrapcolorpicker/js/bootstrap-colorpicker.js',
        $_CONFIG['admin']['lib'].'timepicker/jquery.timepicker.js',
        $_CONFIG['admin']['lib'].'wysihtml5x/wysihtml5x.js',
        $_CONFIG['admin']['lib'].'wysihtml5x/wysihtml5x-toolbar.js',
        $_CONFIG['admin']['lib'].'summernote/summernote.js',
        $_CONFIG['admin']['lib'].'bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.all.js'
	));
$langObj = new Langues();
$langues = $langObj->Recherche();   
$formObj = new HelperForm();
$listObj = new HelperList();

//var_dump($langues);
//die();
 $fields_display = array(
        'id_lang' => array(
            'title' => 'Id',
            'width' => 140,
            'type' => 'text',
        ),
        'name' => array(
            'title' => 'Name',
            'width' => 140,
            'type' => 'text',
        ),
        'iso_code' => array(
            'title' => 'iso code',
            'width' => 140,
            'type' => 'text',
        ),
        'language_code' => array(
            'title' => 'code de la langue',
            'width' => 140,
            'type' => 'text',
        ),
        'drapeau' => array(
            'title' => 'Image de la langue',
            'width' => 140,
            'image' => 's',
        ),
        'active' => array(
            'title' => 'Activer',
            'width' => 140,
            'active' => TRUE,
        ),
        'date_format_lite' => array(
            'title' => 'format de date',
            'width' => 140,
            'date' => 'TRUE',
        ),
        'date_format_full' => array(
            'title' => 'format de date(complet)',
            'width' => 140,
            'date' => 'TRUE',
        )
    );

$fields_form = array();
$fields_form[] = array(
    'form' =>array(
        
        'legend' => array(       
          'title' => 'Edit carrier',
          'description' => 'Example of a simple form elements'
        ),
        'input' => array(       
          array(  
            'label' => 'Nom',
            'type' => 'text',
            'name' => 'shipping_method',
            'required' => true,
           ),
          array(  
            'label' => 'Prénom',
            'type' => 'text',
            'name' => 'prenom',
            'required' => true,
           ),
         array(  
            'label' => 'Description',
            'type' => 'textarea',
            'name' => 'description',            
           ),
         array( 
            'label' => 'Votre photo',
            'type' => 'file',
            'name' => 'photo',
           ),
        array( 
            'label' => 'checkbox',
            'type' => 'checkbox',
            'name' => 'cbx',
            'values' => array(
                'query' => array(
                    array('id' => 1, 'namez' => 'cbx1'),
                    array('id' => 2, 'namez' => 'cbx2')
                    
                ),
                'name' => 'namez',
            )
           ),
            array(
                'label' => 'radio',
                'type' => 'radio',
                'name' => 'radio',
                'values' =>  array(
                    'query' => array(
                        array('id' => 1, 'label' => 'radio 3', 'value' => '1' ),
                        array('id' => 2, 'label' => 'radio 2', 'value' => '2')
                        ),
                     'id' => 'id',
                     'name' => 'label',
                )
            ),
            array(
                'label' => 'Select',
                'type' => 'select',
                'name' => 'selects',
                'options' =>  array(
                     'query' => array(
                         array('id' => 1, 'label' => 'select 3', 'value' => '1' ),
                         array('id' => 2, 'label' => 'select 2', 'value' => '2')
                     ),
                     'id' => 'id',
                     'name' => 'label',
                    
                )
            ),
            array(
                'label' => 'Select groupe',
                'type' => 'select',
                'name' => 'selects_groupe',
                'options' =>  array(
                     'optiongroup'=> array(
                         'query' => array(
                                array('label' => 'groupe option 1', 'values' => array(
                                     array('id' => 1, 'label' => 'option 1' ),
                                     array('id' => 2, 'label' => 'option 2')
                                ) ),
                                array('label' => 'groupe option 2', 'values' => array(
                                    array('id' => 3, 'label' => 'option 3' ),
                                    array('id' => 4, 'label' => 'option 4'),
                                    array('id' => 5, 'label' => 'option 5' ),
                                    array('id' => 6, 'label' => 'option 6')
                                ))
                        ),
                        'label' => 'label',
                        'name' => 'label',
                    ),
                    'options'=> array(
                        'query'=>'values',
                        'id' => 'id',
                        'name' => 'label',
                    )
                )
            ),
        ),
       
        'submit' => array(
          'title' => 'Enregistrer',          
        )
     ));
    
   $fields_form[] = array(
       'form' =>array(
        
            'legend' => array(       
              'title' => 'Edit carrier',
              'description' => 'Example of a advanced form elements'
            ),
            'input' => array(       
              array(  
                'label' => 'Nom',
                'type' => 'text',
                'name' => 'shipping_method',
                'required' => true,
                'suffix' => 'FCFA'
               ),
              array(  
                'label' => 'Prénom',
                'type' => 'text',
                'name' => 'shipping_method',
                'required' => true,
                'prefix' => 'FCFA'
               ),
             array(  
                'label' => 'Description',
                'type' => 'textarea',
                'name' => 'description',
                'class' => 'summernote' 
               ),
            array(  
                'label' => 'Date de Naissance',
                'name' => 'Date_naissance',
                'type' => 'datepicker',
            ),
             array(  
                'label' => 'Couleur',
                'name' => 'color',
                'type' => 'colorpicker'
            ),
             array( 
                'label' => 'Votre photo',
                'type' => 'file',
                'name' => 'Votre photo',
               ),
            ),
            'submit' => array(
              'title' => 'Enregistrer',          
        )
     )
);
//var_dump($langues);die;
$form = $formObj->generateForm($fields_form);
$listObj->actions = array('view', 'edit','delete');
$listObj->primary = 'id_lang';
$listObj->title_list = array(
    'title' => 'List carrier',
    'description' => 'Example of a simple form elements',
    'icon' => 'fa fa-list'
    );
$listObj->url = 'test.html';
$listObj->bulk_actions = array(
    'active'=>array(
        'text'=>Lang::l('Activer'),
        'icon'=>'fa fa-check-square-o',
        'confirm'=> 'voulez confirmer votre action')
    );
$list = $listObj->generateList($langues, $fields_display);
$smarty->assign('form',$form);
$smarty->assign('list',$list);
?>
