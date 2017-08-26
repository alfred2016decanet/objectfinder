


<form id="{if isset($fields.form.form.id_form)}{$fields.form.form.id_form|escape:'html':'UTF-8'}{else}{if $table == null}configuration_form{else}{$table}_form{/if}{if isset($smarty.capture.table_count) && $smarty.capture.table_count}_{$smarty.capture.table_count|intval}{/if}{/if}" class="defaultForm form-horizontal{if isset($name_controller) && $name_controller} {$name_controller}{/if}"{if isset($current) && $current} action="{$current|escape:'html':'UTF-8'}{if isset($token) && $token}&amp;token={$token|escape:'html':'UTF-8'}{/if}"{/if} method="post" enctype="multipart/form-data"{if isset($style)} style="{$style}"{/if} novalidate>
    {if $form_id}
        <input type="hidden" name="{$identifier}" id="{$identifier}{if isset($smarty.capture.identifier_count) && $smarty.capture.identifier_count}_{$smarty.capture.identifier_count|intval}{/if}" value="{$form_id}" />
    {/if}
    {if !empty($submit_action)}
        <input type="hidden" name="{$submit_action}" value="1" />
    {/if}
    {foreach $fields as $f => $fieldset}
        {capture name='fieldset_name'}{counter name='fieldset_name'}{/capture}
        <div class="panel" id="fieldset_{$f}">
        {foreach $fieldset.form as $key => $field}
                {if $key == 'legend'}
                    <div class="panel-heading">
                    {if isset($field.image) && isset($field.title)}<img src="{$field.image}" alt="{$field.title|escape:'html':'UTF-8'}" />{/if}
                    <h4 class="panel-title">{if isset($field.icon)}<i class="{$field.icon}"></i>{else}<i class="glyphicon glyphicon-edit" aria-hidden="true"></i> {/if}
                            {$field.title}
                    </h4>
                    {if isset($field.description)}
                        <p>{$field.description}</p>
                    {/if}
                </div>
            {elseif $key == 'input'}

                <div class="panel-body">
                    {foreach $field as $input}
                        <div class="form-group{if isset($input.form_group_class)} {$input.form_group_class}{/if}{if $input.type == 'hidden'} hide{/if}"{if $input.name == 'id_state'} id="contains_states"{if !$contains_states} style="display:none;"{/if}{/if}{if isset($tabs) && isset($input.tab)} data-tab-id="{$input.tab}"{/if}>
                            {if $input.type == 'hidden'}
                                <input type="hidden" name="{$input.name}" id="{$input.name}" value="{$fields_value[$input.name]|escape:'html':'UTF-8'}" />
                            {else}
                                {if isset($input.label)}
                                    <label class="col-sm-3 control-label{if isset($input.required) && $input.required && $input.type != 'radio'} required{/if}">
                                    {$input.label}{if isset($input.required)}<sup>*</sup>{/if}
                                </label>
                            {/if}
                            <div class="{if ($input.type == 'textarea') && isset($input.class)}col-sm-8{else}col-sm-4{/if}">
                                {if isset($input.prefix)or isset($input.suffix)}
                                    <div class="input-group">
                                    {/if}
                                    {if isset($input.prefix)}
                                        <span class="input-group-addon">
                                            {$input.prefix}
                                        </span>
                                    {/if}
                                    {if $input.type == 'text'}     
                                        {assign var='value_text' value=$fields_value[$input.name]}

                                        <input type="text"
                                               id="{$input.name}"
                                               name="form_{$input.name}"
                                               class="{if isset($input.class)} {$input.class} {else} form-control{/if}"
                                               value="{if isset($input.string_format) && $input.string_format}{$value_text|string_format:$input.string_format|escape:'html':'UTF-8'}{else}{$value_text|escape:'html':'UTF-8'}{/if}"										
                                        {if isset($input.maxchar) && $input.maxchar} data-maxchar="{$input.maxchar|intval}"{/if}
                                    {if isset($input.maxlength) && $input.maxlength} maxlength="{$input.maxlength|intval}"{/if}
                                {if isset($input.readonly) && $input.readonly} readonly="readonly"{/if}
                            {if isset($input.disabled) && $input.disabled} disabled="disabled"{/if}
                        {if isset($input.autocomplete) && !$input.autocomplete} autocomplete="off"{/if}
                    {if isset($input.required) && $input.required} required="required" {/if}
                {if isset($input.placeholder) && $input.placeholder} placeholder="{$input.placeholder}"{/if} />

        {elseif $input.type == 'select'}
            {if isset($input.options.query) && !$input.options.query && isset($input.empty_message)}
                {$input.empty_message}
                {$input.required = false}
                {$input.desc = null}
            {else}
                <div class="col-sm-8">
                    <select name="{$input.name|escape:'html':'utf-8'}"
                            class="{if isset($input.class)}{$input.class|escape:'html':'utf-8'}{/if} form-control"
                            id="{if isset($input.id)}{$input.id|escape:'html':'utf-8'}{else}{$input.name|escape:'html':'utf-8'}{/if}"
                    {if isset($input.multiple) && $input.multiple} multiple="multiple"{/if}
                {if isset($input.size)} size="{$input.size|escape:'html':'utf-8'}"{/if}
            {if isset($input.onchange)} onchange="{$input.onchange|escape:'html':'utf-8'}"{/if}
        {if isset($input.disabled) && $input.disabled} disabled="disabled"{/if} style="width: 100%" class="select2" data-placeholder="Choose One" required>
        {if isset($input.options.default)}
            <option value="{$input.options.default.value|escape:'html':'utf-8'}">{$input.options.default.label|escape:'html':'utf-8'}</option>
        {/if}
        {if isset($input.options.optiongroup)}
            {foreach $input.options.optiongroup.query AS $optiongroup}
                <optgroup label="{$optiongroup[$input.options.optiongroup.label]}">
                    {foreach $optiongroup[$input.options.options.query] as $option}
                        <option value="{$option[$input.options.options.id]}"
                                {if isset($input.multiple)}
                                    {foreach $fields_value[$input.name] as $field_value}
                                    {if $field_value == $option[$input.options.options.id]}selected="selected"{/if}
                                {/foreach}
                        {else}
                        {if $fields_value[$input.name] == $option[$input.options.options.id]}selected="selected"{/if}
                    {/if}
                    >{$option[$input.options.options.name]}</option>
            {/foreach}
        </optgroup>
    {/foreach}
    {else}
        {foreach $input.options.query AS $option}
            {if is_object($option)}
                <option value="{$option->$input.options.id}"
                        {if isset($input.multiple)}
                            {foreach $fields_value[$input.name] as $field_value}
                                {if $field_value == $option->$input.options.id}
                                    selected="selected"
                                {/if}
                            {/foreach}
                        {else}
                            {if $fields_value[$input.name] == $option->$input.options.id}
                                selected="selected"
                            {/if}
                        {/if}
                        >{$option->$input.options.name}</option>
            {elseif $option == "-"}
                <option value="">-</option>
            {else}
                <option value="{$option[$input.options.id]}"
                        {if isset($input.multiple)}
                            {foreach $fields_value[$input.name] as $field_value}
                                {if $field_value == $option[$input.options.id]}
                                    selected="selected"
                                {/if}
                            {/foreach}
                        {else}
                            {if $fields_value[$input.name] == $option[$input.options.id]}
                                selected="selected"
                            {/if}
                        {/if}
                        >{$option[$input.options.name]}</option>

            {/if}
        {/foreach}
    {/if}
    </select>
    <label class="error" for="{$input.name|escape:'html':'utf-8'}"></label>
    </div>
    {/if}
    {elseif $input.type == 'radio'}
        <div class="col-sm-9">
            {foreach $input.values.query as $value}
                <label class="rdiobox">
                    <input type="radio"	name="{$input.name}" id="{$value[$input.values.id]}" value="{$value[$input.values.id]|escape:'html':'UTF-8'}"{if $fields_value[$input.name] == $value[$input.values.id]} checked="checked"{/if}{if isset($input.disabled) && $input.disabled} disabled="disabled"{/if}/>
                    <span>{$value[$input.values.name]}</span> 
                </label>
             {*{if isset($value.p) && $value.p}<p class="help-block">{$value.p}</p>{/if}*}
            {/foreach}
        </div>

    {elseif $input.type == 'textarea'}
        {assign var=use_textarea_autosize value=true}
        <div class="">																														
            <textarea{if isset($input.readonly) && $input.readonly} readonly="readonly"{/if} name="{$input.name}" id="{if isset($input.id)}{$input.id}{else}{$input.name}{/if}" {if isset($input.cols)}cols="{$input.cols}"{/if} {if isset($input.rows)}rows="{$input.rows}"{/if} class="form-control {if isset($input.autoload_rte) && $input.autoload_rte}rte autoload_rte{else}textarea-autosize{/if}{if isset($input.class)} {$input.class}{/if}"{if isset($input.maxlength) && $input.maxlength} maxlength="{$input.maxlength|intval}"{/if}{if isset($input.maxchar) && $input.maxchar} data-maxchar="{$input.maxchar|intval}"{/if}>{$fields_value[$input.name]|escape:'html':'UTF-8'}</textarea>
        </div>
    {elseif $input.type == 'checkbox'}
        {if isset($input.expand)}
            <a class="btn btn-default show_checkbox{if strtolower($input.expand.default) == 'hide'} hidden{/if}" href="#">
                <i class="icon-{$input.expand.show.icon}"></i>
                {$input.expand.show.text}
                {if isset($input.expand.print_total) && $input.expand.print_total > 0}
                    <span class="badge">{$input.expand.print_total}</span>
                {/if}
            </a>
            <a class="btn btn-default hide_checkbox{if strtolower($input.expand.default) == 'show'} hidden{/if}" href="#">
                <i class="icon-{$input.expand.hide.icon}"></i>
                {$input.expand.hide.text}
                {if isset($input.expand.print_total) && $input.expand.print_total > 0}
                    <span class="badge">{$input.expand.print_total}</span>
                {/if}
            </a>
        {/if}
        {foreach $input.values.query as $value}
            {assign var=id_checkbox value=$input.name|cat:'_'|cat:$value.id}
            <div class="col-sm-9 checkbox{if isset($input.expand) && strtolower($input.expand.default) == 'show'} hidden{/if}">
                {strip}
                    <label for="{$id_checkbox}" class="ckbox">
                        <input type="checkbox" name="{$id_checkbox}" id="{$id_checkbox}" class="{if isset($input.class)}{$input.class}{/if}"{if isset($value.val)} value="{$value.val|escape:'html':'UTF-8'}"{/if}{if isset($fields_value[$id_checkbox]) && $fields_value[$id_checkbox]} checked="checked"{/if} />
                        <span>{$value[$input.values.name]}</span>
                    </label>
                {/strip}
            </div>
        {/foreach}

    {elseif $input.type == 'password'}
        <div class="input-group fixed-width-lg">
            <span class="input-group-addon">
                <i class="icon-key"></i>
            </span>
            <input type="password"
                   id="{if isset($input.id)}{$input.id}{else}{$input.name}{/if}"
                   name="{$input.name}"
                   class="{if isset($input.class)}{$input.class}{else}form-control{/if}"
                   value=""
            {if isset($input.autocomplete) && !$input.autocomplete}autocomplete="off"{/if}
        {if isset($input.required) && $input.required} required="required" {/if} />
    </div>

    {elseif $input.type == 'timepicker'}
        <div class="input-group mb15">
            <span class="input-group-addon">
                <i class="glyphicon glyphicon-time"></i>
            </span>
            <div class="timepicker">
                <input class="form-control {if isset($input.class)}{$input.class}{/if}" name="{$input.name}" type="text">
            </div>
        </div>
    {elseif $input.type == 'datepicker'}
        <div class="input-group">
            <input class="{if isset($input.class)}{$input.class}{else}form-control{/if} datepicker" name="{$input.name}" type="text" placeholder="mm/dd/yyyy">
            <span class="input-group-addon">
                <i class="glyphicon glyphicon-calendar"></i>
            </span>
        </div>
    {elseif $input.type == 'colorpicker'}
        <div class="col-xs-12 col-sm-6 col-md-3">
            <input class="{if isset($input.class)}{$input.class}{else}form-control{/if} colorpicker" type="text" placeholder="#FFFFFF">
        </div>
    {elseif $input.type == 'toggle'}
        <div class="toggle-wrapper">
            <div class="toggle toggle-light"></div>
        </div>

    {elseif $input.type == 'file'}
        {$input.file}
        <div class="form-group">
            <div class="col-lg-2">
                <div class="row">
                    <div class="input-group">
                        <input type="file"
                               data-hex="true"
                               {if isset($input.class)} class="{$input.class}"
                               {/if}
                               name="{$input.name}"
                               value="{$fields_value[$input.name]|escape:'html':'UTF-8'}" />
                    </div>
                </div>
            </div>
        </div>
    {/if}
    {if isset($input.suffix)}    
        <span class="input-group-addon">
            {$input.suffix}
        </span>
    {/if}
    {if isset($input.prefix)or isset($input.suffix)}
    </div>
    {/if}
    {if isset($input.desc) && !empty($input.desc)}
        <p class="help-block">
            {if is_array($input.desc)}
                {foreach $input.desc as $p}
                    {if is_array($p)}
                        <span id="{$p.id}">{$p.text}</span><br />
                    {else}
                        {$p}<br />
                    {/if}
                {/foreach}
            {else}
                {$input.desc}
            {/if}
        </p>
    {/if}
    </div>
    {/if}
    </div>
    {/foreach}
    </div>
    {capture name='form_submit_btn'}{counter name='form_submit_btn'}{/capture}
    <div class="panel-footer">
        <div class="row">
            <div class="col-sm-9 col-sm-offset-3">
                {if isset($fieldset['form']['submit']) || isset($fieldset['form']['buttons'])}

                    {if isset($fieldset['form']['submit']) && !empty($fieldset['form']['submit'])}
                        <button type="submit" value="1"	id="{if isset($fieldset['form']['submit']['id'])}{$fieldset['form']['submit']['id']}{else}{$table}_form_submit_btn{/if}{if $smarty.capture.form_submit_btn > 1}_{($smarty.capture.form_submit_btn - 1)|intval}{/if}" name="{if isset($fieldset['form']['submit']['name'])}{$fieldset['form']['submit']['name']}{else}{$submit_action}{/if}{if isset($fieldset['form']['submit']['stay']) && $fieldset['form']['submit']['stay']}AndStay{/if}" class="{if isset($fieldset['form']['submit']['class'])}{$fieldset['form']['submit']['class']}{else}btn btn-success btn-quirk btn-wide mr5{/if}">
                            <i class="{if isset($fieldset['form']['submit']['icon'])}{$fieldset['form']['submit']['icon']}{else}process-icon-save{/if}"></i> {$fieldset['form']['submit']['title']}
                        </button>
                    {/if}
                    {if isset($show_cancel_button) && $show_cancel_button}
                        <a href="{$back_url|escape:'html':'UTF-8'}" class="btn btn-default" onclick="window.history.back();">
                            <i class="process-icon-cancel"></i> {l s='Cancel'}
                        </a>
                    {/if}
                    {if isset($fieldset['form']['reset'])}
                        <button
                            type="reset"
                            id="{if isset($fieldset['form']['reset']['id'])}{$fieldset['form']['reset']['id']}{else}{$table}_form_reset_btn{/if}"
                            class="{if isset($fieldset['form']['reset']['class'])}{$fieldset['form']['reset']['class']}{else}btn btn-default{/if}"
                            >
                        {if isset($fieldset['form']['reset']['icon'])}<i class="{$fieldset['form']['reset']['icon']}"></i> {/if} {$fieldset['form']['reset']['title']}
                    </button>
                {/if}
                {if isset($fieldset['form']['buttons'])}
                    {foreach from=$fieldset['form']['buttons'] item=btn key=k}
                        {if isset($btn.href) && trim($btn.href) != ''}
                            <a href="{$btn.href}" {if isset($btn['id'])}id="{$btn['id']}"{/if} class="btn btn-default{if isset($btn['class'])} {$btn['class']}{/if}" {if isset($btn.js) && $btn.js} onclick="{$btn.js}"{/if}>{if isset($btn['icon'])}<i class="{$btn['icon']}" ></i> {/if}{$btn.title}</a>
                        {else}
                            <button type="{if isset($btn['type'])}{$btn['type']}{else}button{/if}" {if isset($btn['id'])}id="{$btn['id']}"{/if} class="btn btn-default{if isset($btn['class'])} {$btn['class']}{/if}" name="{if isset($btn['name'])}{$btn['name']}{else}submitOptions{$table}{/if}"{if isset($btn.js) && $btn.js} onclick="{$btn.js}"{/if}>{if isset($btn['icon'])}<i class="{$btn['icon']}" ></i> {/if}{$btn.title}</button>
                        {/if}
                    {/foreach}
                {/if}
            {/if}
        </div>
    </div>

    </div>
    </div><!-- /.form-wrapper -->
    {elseif $key == 'desc'}
        <div class="alert alert-info col-lg-offset-3">
            {if is_array($field)}
                {foreach $field as $k => $p}
                    {if is_array($p)}
                        <span{if isset($p.id)} id="{$p.id}"{/if}>{$p.text}</span><br />
                    {else}
                        {$p}
                    {if isset($field[$k+1])}<br />{/if}
                {/if}
            {/foreach}
        {else}
            {$field}
        {/if}
    </div>
    {/if}
    {/foreach}
{/foreach}
</form>
