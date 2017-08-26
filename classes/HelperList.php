<?php

class HelperList
{
    protected $list = array();
    private $default_actions;
    public $listTotal;
    public $smarty;
    public $url;
    public $title_list;
    public $identifier;
    public $position_identifier;
    protected $fields_list;
    public $actions = array('edit', 'delete');
    public $list_skip_actions = array();
    public $bulk_actions = false;
    public $primary = 'id';
    public function __construct()
    {
        global $smarty;
        $this->smarty = $smarty;
         $this->default_actions = array(
            'view'=>array(
                'title' => Lang::l('Afficher'),
                'url'=>'',
                'icon'=>'fa fa-eye',
                'params' => 'view'
            ),
            'edit'=>array(
                'title' => Lang::l('Modifier'),
                'url'=>'',
                'icon'=>'fa fa-pencil',
                'params' => 'edit',
            ),
            
            'delete'=>array(
                'title' => Lang::l('Suprimer'),
                'url'=>'',
                'icon'=>'fa fa-trash',
                'params' => 'delete',
                'confirm' => "Voulez vous supprimer cette entrée"
            )
        );
    }
    /**
     * Return an html list given the data to fill it up
     *
     * @param array $list entries to display (rows)
     * @param array $fields_display fields (cols)
     * @return string html
     */
    public function generateList($list, $fields_display)
    {
        $this->list = $list;
        $this->fields_list = $fields_display;
        return $this->generate();
    }

    public function generate()
    {
        global $smarty;
        
        if($this->actions)
        {
            foreach ($this->actions as $key => $value){
                if (is_array($value))
                {
                    if(!isset($value['url']))
                        $value['url'] = $this->url;
                     if(!isset($value['title']) && isset($this->default_actions[$key]))
                        $value['title'] = $this->default_actions[$key]['title'];
                     if(!isset($value['icon']) && isset($this->default_actions[$key]))
                        $value['icon'] = $this->default_actions[$key]['icon'];
                     if(!isset($value['params']) && isset($this->default_actions[$key]))
                        $value['params'] = $this->default_actions[$key]['params'];
                     if(!isset($value['confirm']) && isset($this->default_actions[$key]))
                        $value['confirm'] = @$this->default_actions[$key]['confirm'];
                }
                else
                {
                    $this->actions[$value] = $this->default_actions[$value];
                    $this->actions[$value]['url'] = $this->url;
                    unset($this->actions[$key]);
                }
            }
        }
         $smarty->assign(array(
            'fields_display' => $this->fields_list,
            'list' => $this->list,
            'actions' => $this->actions,
            'bulk_actions' => $this->bulk_actions,
            'has_bulk_actions' => true,
             'primary' => $this->primary,
             'title' => $this->title_list,
             'url' => $this->url,
        ));
//        var_dump($this->actions);
//        die();
        return $smarty->fetch('helpers/lists/list.tpl');
    }
    
}
?>
