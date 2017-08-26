<?php

class HelperForm
{
    public $id;
    protected $fields_form = array();
    public $fields_value = array();
    public $submit_action;
    public $show_cancel_button = false;
    public $identifier;
    public $name_controller = '';
    public $table = 'configuration';
    public $title = null;
    public $smarty;

    public function __construct()
    {
        global $smarty;
        $this->smarty = $smarty;
    }
    public function generateForm($fields_form)
    {
        $this->fields_form = $fields_form;
        return $this->generate();
    }
    public function generate()
    {
        global $smarty;
        if (is_null($this->submit_action)) {
            $this->submit_action = 'submitAdd'.$this->table;
        }
        $color = true;
        $date = true;
        $tinymce = true;
        $textarea_autosize = true;
        $file = true;
        foreach ($this->fields_form as $fieldset_key => &$fieldset) {
            if (isset($fieldset['form']['tabs'])) {
                $tabs[] = $fieldset['form']['tabs'];
            }

            if (isset($fieldset['form']['input'])) {
                foreach ($fieldset['form']['input'] as $key => &$params) {
                    // If the condition is not met, the field will not be displayed
                    if (isset($params['condition']) && !$params['condition']) {
                        unset($this->fields_form[$fieldset_key]['form']['input'][$key]);
                    }
                    switch ($params['type']) {
                        case 'select':
                            $field_name = (string)$params['name'];
                            // If multiple select check that 'name' field is suffixed with '[]'
                            if (isset($params['multiple']) && $params['multiple'] && stripos($field_name, '[]') === false) {
                                $params['name'] .= '[]';
                            }
                            break;
                        case 'text':
                            break;
                   }
                }
            }
        }
        
        $smarty->assign(array(
            'title' => $this->title,
            'toolbar_btn' => $this->toolbar_btn,
            'show_toolbar' => $this->show_toolbar,
            'toolbar_scroll' => $this->toolbar_scroll,
            'submit_action' => $this->submit_action,
            'firstCall' => $this->first_call,
            'current' => $this->currentIndex,
            'token' => $this->token,
            'table' => $this->table,
            'identifier' => $this->identifier,
            'name_controller' => $this->name_controller,
            'form_id' => $this->id,
            'tabs' => (isset($tabs)) ? $tabs : null,
            'fields' => $this->fields_form,
            'fields_value' => $this->fields_value,
            'required_fields' => $this->getFieldsRequired(),
            'show_cancel_button' => $this->show_cancel_button,
        ));
//        var_dump($this->fields_form);
//        die();
        return $smarty->fetch('helpers/forms/form.tpl');
    }

    public function getFieldsRequired()
    {
        foreach ($this->fields_form as $fieldset) {
            if (isset($fieldset['form']['input'])) {
                foreach ($fieldset['form']['input'] as $input) {
                    if (!empty($input['required']) && $input['type'] != 'radio') {
                        return true;
                    }
                }
            }
        }
        return false;
    }
 
}