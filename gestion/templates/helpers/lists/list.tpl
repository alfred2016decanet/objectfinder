
<form method="post" action="{$actions.view.url|escape:'html':'UTF-8'}" class="form-horizontal clearfix" id="form-{$list_id}">

    <div class="panel col-lg-12">
        <div class="panel">
            <ul class="panel-options">
                {if count($actions) > 1}
                    <li>
                        <a class="" href="{$actions.edit.url}" title="Ajouter">
                            <i class="fa fa-plus"></i>
                        </a>
                    </li>
                {/if}
            </ul>
            <div class="panel-heading">
                {if isset($title)}
                    <h4 class="panel-title">
                        {if isset($title.icon)}
                            <i class="{$title.icon}"></i>
                        {/if}
                        {if isset($title.title) AND $title.title !=''}
                            {$title.title}
                        {/if}
                    </h4>
                {/if}
                {if isset($title.description)}
                    <p>{$title.description}</p>
                {/if}
            </div>
            <div class="panel-body">
                <div class="table-responsive-row clearfix{if isset($use_overflow) && $use_overflow} overflow-y{/if}">
                        <table{if $table_id} id="table-{$table_id}"{/if} class="table{if $table_dnd} tableDnD{/if} {$table}" >
                            <thead>
                                <tr class="nodrag nodrop">
                                    {if $bulk_actions && $has_bulk_actions}
                                        <th class="center fixed-width-xs"></th>
                                        {/if}
                                        {foreach $fields_display AS $key => $params}
                                        <th class="row-selector text-center {if isset($params.class)}{$params.class}{/if}{if isset($params.align)} {$params.align}{/if}">
                                            <span class="title_box{if isset($order_by) && ($key == $order_by)} active{/if}">
                                                {if isset($params.hint)}
                                                    <span class="label-tooltip" data-toggle="tooltip"
                                                          title="
                                                          {if is_array($params.hint)}
                                                              {foreach $params.hint as $hint}
                                                                  {if is_array($hint)}
                                                                      {$hint.text}
                                                                  {else}
                                                                      {$hint}
                                                                  {/if}
                                                              {/foreach}
                                                          {else}
                                                              {$params.hint}
                                                          {/if}
                                                          ">
                                                        {$params.title}
                                                    </span>
                                                {else}
                                                    {$params.title}
                                                {/if}							
                                            </span>
                                        </th>
                                    {/foreach}
                                    {if $has_actions || $show_filters}
                                        <th class="row-selector text-center">{if !$simple_header}{/if}</th>
                                        {/if}
                                        {if isset($actions)}
                                        <th class="center fixed-width-xs row-selector text-center"></th>
                                        {/if}
                                </tr>
                                {if !$simple_header && $show_filters}
                                    <tr class="nodrag nodrop filter {if $row_hover}row_hover{/if}">
                                                {if $has_bulk_actions}
                                                    <th class="row-selector text-center">
                                                        --
                                                    </th>
                                                {/if}
                                                {* Filters (input, select, date or bool) *}
                                                {foreach $fields_display AS $key => $params}
                                                    <th {if isset($params.align)} class="row-selector text-center {$params.align}" {/if}>
                                                        {if isset($params.search) && !$params.search}
                                                            --
                                                        {else}
                                                            {if $params.type == 'bool'}
                                                                <select class="filter fixed-width-sm center" name="{$list_id}Filter_{$key}">
                                                                    <option value="">-</option>
                                                                    <option value="1" {if $params.value == 1} selected="selected" {/if}>{l s='Yes'}</option>
                                                                    <option value="0" {if $params.value == 0 && $params.value != ''} selected="selected" {/if}>{l s='No'}</option>
                                                                </select>
                                                            {elseif $params.type == 'date' || $params.type == 'datetime'}
                                                    <div class="date_range row">
                                                        <div class="input-group fixed-width-md center">
                                                            <input type="text" class="filter datepicker date-input form-control" id="local_{$params.id_date}_0" name="local_{$params.name_date}[0]"  placeholder="{l s='From'}" />
                                                            <input type="hidden" id="{$params.id_date}_0" name="{$params.name_date}[0]" value="{if isset($params.value.0)}{$params.value.0}{/if}">
                                                            <span class="input-group-addon">
                                                                <i class="icon-calendar"></i>
                                                            </span>
                                                        </div>
                                                        <div class="input-group fixed-width-md center">
                                                            <input type="text" class="filter datepicker date-input form-control" id="local_{$params.id_date}_1" name="local_{$params.name_date}[1]"  placeholder="{l s='To'}" />
                                                            <input type="hidden" id="{$params.id_date}_1" name="{$params.name_date}[1]" value="{if isset($params.value.1)}{$params.value.1}{/if}">
                                                            <span class="input-group-addon">
                                                                <i class="icon-calendar"></i>
                                                            </span>
                                                        </div>										
                                                    </div>
                                                {elseif $params.type == 'select'}
                                                    {if isset($params.filter_key)}
                                                        <select class="filter center" onchange="$('#submitFilterButton{$list_id}').focus();
                                                                                $('#submitFilterButton{$list_id}').click();" name="{$list_id}Filter_{$params.filter_key}" {if isset($params.width)} style="width:{$params.width}px"{/if}>
                                                            <option value="" {if $params.value == ''} selected="selected" {/if}>-</option>
                                                            {if isset($params.list) && is_array($params.list)}
                                                                {foreach $params.list AS $option_value => $option_display}
                                                                    <option value="{$option_value}" {if (string)$option_display === (string)$params.value ||  (string)$option_value === (string)$params.value} selected="selected"{/if}>{$option_display}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                    {/if}
                                                {else}
                                                    <input type="text" class="filter" name="{$list_id}Filter_{if isset($params.filter_key)}{$params.filter_key}{else}{$key}{/if}" value="{$params.value|escape:'html':'UTF-8'}" {if isset($params.width) && $params.width != 'auto'} style="width:{$params.width}px"{/if} />
                                                {/if}
                                            {/if}
                                            </th>
                                        {/foreach}

                                        {if $shop_link_type}
                                        <th class="row-selector text-center">--</th>
                                        {/if}
                                        {if $has_actions || $show_filters}
                                        <th class="row-selector text-center actions">
                                            {if $show_filters}
                                                <span class="pull-right">
                                                    {*Search must be before reset for default form submit*}
                                                    <button type="submit" id="submitFilterButton{$list_id}" name="submitFilter" class="btn btn-default" data-list-id="{$list_id}">
                                                        <i class="icon-search"></i> {l s='Search'}
                                                    </button>
                                                    {if $filters_has_value}
                                                        <button type="submit" name="submitReset{$list_id}" class="btn btn-warning">
                                                            <i class="icon-eraser"></i> {l s='Reset'}
                                                        </button>
                                                    {/if}
                                                </span>
                                            {/if}
                                        </th>
                                    {/if}
                                </tr>
                                {/if}
                            </thead>
                            <tbody>
                                {foreach $list AS $index => $tr}
                                    <tr{if $position_identifier} id="tr_{$position_group_identifier}_{$tr.$identifier}_{if isset($tr.position['position'])}{$tr.position['position']}{else}0{/if}"{/if} class="{if isset($tr.class)}{$tr.class}{/if} {if $tr@iteration is odd by 1}odd{/if}"{if isset($tr.color) && $color_on_bg} style="background-color: {$tr.color}"{/if}>
                                        {if $bulk_actions && $has_bulk_actions}
                                            <td class="row-selector text-center">
                                                {if isset($list_skip_actions.delete)}
                                                    {if !in_array($tr.$identifier, $list_skip_actions.delete)}
                                                        <input type="checkbox" name="{$list_id}Box[]" value="{$tr.$identifier}"{if isset($checked_boxes) && is_array($checked_boxes) && in_array({$tr.$identifier}, $checked_boxes)} checked="checked"{/if} class="noborder" />
                                                    {/if}
                                                {else}
                                                    <input type="checkbox" name="{$list_id}Box[]" value="{$tr.$identifier}"{if isset($checked_boxes) && is_array($checked_boxes) && in_array({$tr.$identifier}, $checked_boxes)} checked="checked"{/if} class="noborder" />
                                                {/if}
                                            </td>
                                        {/if}

                        {foreach $fields_display AS $key => $params}
                        <td
                            {if isset($params.position)}
                                id="td_{if !empty($position_group_identifier)}{$position_group_identifier}{else}0{/if}_{$tr.$identifier}{if $smarty.capture.tr_count > 1}_{($smarty.capture.tr_count - 1)|intval}{/if}"
                            {/if}
                            class="text-center">

                                            {if isset($params.prefix)}{$params.prefix}{/if}
                                            {if isset($params.badge_success) && $params.badge_success && isset($tr.badge_success) && $tr.badge_success == $params.badge_success}<span class="badge badge-success">{/if}
                                            {if isset($params.badge_warning) && $params.badge_warning && isset($tr.badge_warning) && $tr.badge_warning == $params.badge_warning}<span class="badge badge-warning">{/if}
                                            {if isset($params.badge_danger) && $params.badge_danger && isset($tr.badge_danger) && $tr.badge_danger == $params.badge_danger}<span class="badge badge-danger">{/if}
                                            {if isset($params.color) && isset($tr[$params.color])}
                                                <span class="label color_field" style="background-color:{$tr[$params.color]};color:{if Tools::getBrightness($tr[$params.color]) < 128}white{else}#383838{/if}">
                                            {/if}
                                            {if isset($tr.$key)}
                                                {if isset($params.active)}
                                                    <a id="validate_{$tr.$primary}" class="btn btn-{if $tr.$key}success{else}danger{/if}" onclick="genericToggleActivate('{$tr.$primary}', '{$url}');
                                                                    return false;">
                                                        <span class="glyphicon glyphicon-{if $tr.$key}ok{else}remove{/if}" aria-hidden="true"></span>
                                                    </a>
                                                {elseif isset($params.activeVisu)}
                                                    {if $tr.$key}
                                                        <i class="icon-check-ok"></i> {l s='Enabled'}
                                                    {else}
                                                        <i class="icon-remove"></i> {l s='Disabled'}
                                                    {/if}
                                                {elseif isset($params.position)}
                                                    {if !$filters_has_value && $order_by == 'position' && $order_way != 'DESC'}
                                                        <div class="dragGroup">
                                                            <div class="positions">
                                                                {$tr.$key.position + 1}
                                                            </div>
                                                        </div>
                                                    {else}
                                                        {$tr.$key.position + 1}
                                                    {/if}
                                                {elseif isset($params.image)}
                                                    <img src="{$tr.$key}" alt="{$tr.name}" title="{$tr.name}" />
                                                {elseif isset($params.icon)}
                                                    {if is_array($tr[$key])}
                                                        {if isset($tr[$key]['class'])}
                                                            <i class="{$tr[$key]['class']}"></i>
                                                        {else}
                                                            <img src="../img/admin/{$tr[$key]['src']}" alt="{$tr[$key]['alt']}" title="{$tr[$key]['alt']}" />
                                                        {/if}
                                                    {/if}
                                                {elseif isset($params.float)}
                                                    {$tr.$key}
                                                {elseif isset($params.type) && $params.type == 'decimal'}
                                                    {$tr.$key|string_format:"%.2f"}
                                                {elseif isset($params.type) && $params.type == 'percent'}
                                                    {$tr.$key} {l s='%'}
                                                    {* If type is 'editable', an input is created *}
                                                {elseif isset($params.type) && $params.type == 'editable' && isset($tr.id)}
                                                        <input type="text" name="{$key}_{$tr.id}" value="{$tr.$key|escape:'html':'UTF-8'}" class="{$key}" />
                                                {elseif isset($params.callback)}
                                                    {if isset($params.maxlength) && Tools::strlen($tr.$key) > $params.maxlength}
                                                        <span title="{$tr.$key}">{$tr.$key|truncate:$params.maxlength:'...'}</span>
                                                    {else}
                                                        {$tr.$key}
                                                    {/if}
                                                {elseif $key == 'color'}
                                                    {if !is_array($tr.$key)}
                                                        <div style="background-color: {$tr.$key};" class="attributes-color-container"></div>
                                                {else} {*TEXTURE*}
                                                    <img src="{$tr.$key.texture}" alt="{$tr.name}" class="attributes-color-container" />
                                                {/if}
                                            {elseif isset($params.maxlength) && Tools::strlen($tr.$key) > $params.maxlength}
                                                <span title="{$tr.$key|escape:'html':'UTF-8'}">{$tr.$key|truncate:$params.maxlength:'...'|escape:'html':'UTF-8'}</span>
                                            {else}
                                                {$tr.$key|escape:'html':'UTF-8'}
                                            {/if}
                                        {else}
                                        {/if}
                                        {if isset($params.suffix)}{$params.suffix}{/if}
                                        {if isset($params.color) && isset($tr.color)}
                                        </span>
                                    {/if}
                                {if isset($params.badge_danger) && $params.badge_danger && isset($tr.badge_danger) && $tr.badge_danger == $params.badge_danger}</span>{/if}
                        {if isset($params.badge_warning) && $params.badge_warning && isset($tr.badge_warning) && $tr.badge_warning == $params.badge_warning}</span>{/if}
                    {if isset($params.badge_success) && $params.badge_success && isset($tr.badge_success) && $tr.badge_success == $params.badge_success}</span>{/if}
                    </td>
                    {/foreach}

                    {*                    {if $has_actions}
                    <td class="text-right">
                    {assign var='compiled_actions' value=array()}
                    {foreach $actions AS $key => $action}
                    {if isset($action)}
                    {if $key == 0}
                    {assign var='action' value=$action}
                    {/if}
                    {if $action == 'delete' && $actions|@count > 2}
                    {$compiled_actions[] = 'divider'}
                    {/if}
                    {$compiled_actions[] = $tr.$action}
                    {/if}
                    {/foreach}
                    {if $compiled_actions|count > 0}
                    {if $compiled_actions|count > 1}<div class="btn-group-action">{/if}
                    <div class="btn-group pull-right">
                    {$compiled_actions[0]}
                    {if $compiled_actions|count > 1}
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-caret-down"></i>&nbsp;
                    </button>
                    <ul class="dropdown-menu">
                    {foreach $compiled_actions AS $key => $action}
                    {if $key != 0}
                    <li{if $action == 'divider' && $compiled_actions|count > 3} class="divider"{/if}>
                    {if $action != 'divider'}{$action}{/if}
                    </li>
                    {/if}
                    {/foreach}
                    </ul>
                    {/if}
                    </div>
                    {if $compiled_actions|count > 1}</div>{/if}
                    {/if}
                    </td>
                    {/if}*}
                    {if $actions}
                        <td class="text-right">
                            <div class="btn-group-action" >
                                <div class="btn-group clearfix">
                                    {foreach from=$actions  item=action}
                                        <a class="edit btn btn-default"  href="{$action.url}?id={$tr.$primary}&{$action.params}">
                                            <i class="{$action.icon}"></i>
                                            {$action.title}
                                        </a>
                                        {if count($actions) > 1}
                                        <button class="btn btn-default dropdown-toggle" aria-expanded="false" data-toggle="dropdown" type="button">
                                            <span class="caret"></span>&nbsp;
                                        </button>
                                        {/if}
                                        {break}
                                    {/foreach}
                                    {if count($actions) > 1}
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                        {assign var='continious' value=0}
                                        {foreach from=$actions  item=action}
                                            {if $continious}
                                                <li>
                                                    <a  href="{$action.url}?id={$tr.$primary}&{$action.params}">
                                                        <i class="{$action.icon}"></i>
                                                        {$action.title}
                                                    </a>
                                                </li>
                                            {/if}
                                            {assign var='continious' value=1}
                                        {/foreach}
                                    </ul>
                                    {/if}
                                </div>
                            </div>
                        </td>
                    {/if}
                    {/foreach}
                    </tr>
                    </tbody>
                    </table>
                </div> 
            </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-6">
                    {*{$bulk_actions|var_dump}*}
                    {if $bulk_actions && $has_bulk_actions}
                        <div class="btn-group bulk-actions dropup">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                {l s='Pour la selection'} <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#" onclick="javascript:checkDelBoxes($(this).closest('form').get(0), '{$list_id}Box[]', true);
                                                                return false;">
                                        <i class="icon-check-sign"></i>&nbsp;{l s='Select all'}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="javascript:checkDelBoxes($(this).closest('form').get(0), '{$list_id}Box[]', false);
                                                                return false;">
                                        <i class="icon-check-empty"></i>&nbsp;{l s='Unselect all'}
                                    </a>
                                </li>
                                <li class="divider"></li>
                                    {foreach $bulk_actions as $key => $params}
                                    <li{if $params.text == 'divider'} class="divider"{/if}>
                                        {if $params.text != 'divider'}
                                            <a href="#" onclick="{if isset($params.confirm)}if(confirm('{$params.confirm}')){/if}sendBulkAction($(this).closest('form').get(0), 'submitBulk{$key}');">
                                            {if isset($params.icon)}<i class="{$params.icon}"></i>{/if}&nbsp;{$params.text}
                                        </a>
                                    {/if}
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
            </div>
            {*<div class="panel-footer">
            <a id="desc-{$table}-{if isset($back_button.imgclass)}{$back_button.imgclass}{else}{$k}{/if}" class="btn btn-default{if isset($back_button.target) && $back_button.target} _blank{/if}"{if isset($back_button.href)} href="{$back_button.href|escape:'html':'UTF-8'}"{/if}{if isset($back_button.js) && $back_button.js} onclick="{$back_button.js}"{/if}>
            <i class="process-icon-back {if isset($back_button.class)}{$back_button.class}{/if}" ></i> <span {if isset($back_button.force_desc) AND $back_button.force_desc eq true} class="locked" {/if}>{$back_button.desc}</span>
            </a>
            </div>*}
            </div>
        </div>
    </div>
    </div>
</form>
