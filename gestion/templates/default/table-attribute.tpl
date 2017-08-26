<table class="table table-bordered table-striped nomargin">
    {if isset($attrib)}
    <thead>
        <tr>
            <th class="form-group text-align-center">Champs</th>
            <th class="form-group text-align-center">Label</th>
            <th class="form-group text-align-center">Prefix</th>
            <th class="form-group text-align-center">Suffix</th>
            <th class="form-group text-align-center">Type</th>
            <th class="form-group text-align-center">Afficher(form)</th>
            <th class="form-group text-align-center">Afficher(liste)</th>
            <th class="form-group text-align-center">Critére de Recherche</th>
            <th class="form-group text-align-center">Champ Requi</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$attrib key=key item=attribute}
            <tr id="">
                 <td>
                     <div class="form-group text-align-center">
                         <div class="col-sm-12">
                            {$attribute.COLUMN_NAME}
                            <input type="hidden" name="key[{$attribute.COLUMN_NAME}]" value="{$attribute.COLUMN_NAME}" class="form-control">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group text-align-center">
                         <div class="col-sm-12">
                            <input type="text" name="label[{$attribute.COLUMN_NAME}]" class="form-control">
                        </div>
                    </div>
                </td>  
                <td>
                    <div class="form-group text-align-center">
                        <div class="col-sm-12">
                            <input type="text" name="prefix[{$attribute.COLUMN_NAME}]" class="form-control">
                        </div>
                    </div>
                </td>   
                <td>
                    <div class="form-group text-align-center">
                        <div class="col-sm-12">
                            <input type="text" name="suffix[{$attribute.COLUMN_NAME}]" class="form-control">
                        </div>
                    </div>
                </td>
                <td>
                    {if $attribute.COLUMN_KEY == 'MUL' OR $attribute.COLUMN_KEY == 'UNI' OR $attribute.EXTRA == 'auto_increment'}
                        {if $attribute.COLUMN_KEY == 'UNI' OR $attribute.COLUMN_KEY == 'MUL'}
                            <div class="form-group text-align-center">
                                <div class="col-sm-12">
                                    <select id="attrib-type" name="type[{$attribute.COLUMN_NAME}]" style="color:black;" class="form-control">
                                        <option value="radio">Radio</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="select">Combobox</option>
                                    </select>
                                </div>
                            </div>
                        {elseif $attribute.EXTRA == 'auto_increment'}
                            <div class="form-group text-align-center">
                                <div class="col-sm-12">
                                    <input type="hidden" name="disabled[{$attribute.COLUMN_NAME}]" value="1" class="form-control">
                                    <select id="attrib-type" disabled name="type[{$attribute.COLUMN_NAME}]" style="color:black;" class="form-control">
                                        <option value="">&nbsp;</option>
                                        <option value="radio">Radio</option>
                                        <option value="checkbox">Checkbox</option>
                                    </select>
                                </div>
                            </div>
                        {/if}
                        {if array_key_exists($attribute.COLUMN_NAME, $extraFields)}
                            {assign var=colone_name value=$attribute.COLUMN_NAME}
                            <fieldset>
                                <legend class="">Ref table:&nbsp;{$extraFields.$colone_name.ref_table}</legend>
                                <div class="form-group text-align-center">
                                    <div class="col-sm-12">
                                        <input type="hidden" name="table[{$attribute.COLUMN_NAME}]" value="{$extraFields.$colone_name.ref_table}" class="form-control">
                                        <label for="fk_name">Nom</label>
                                        <select id="fk_name"  name="fk_name[{$attribute.COLUMN_NAME}]" style="color:black;" class="form-control">
                                            <option value="">&nbsp;</option>
                                            {foreach from=$extraFields.$colone_name.ref_fields item=extraField}
                                                <option value="{$extraField.COLUMN_NAME}">{$extraField.COLUMN_NAME}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group text-align-center">
                                    <div class="col-sm-12">
                                            <label for="fk_value">Valeur</label>
                                            <select id="fk_value"  name="fk_value[{$attribute.COLUMN_NAME}]" style="color:black;" class="form-control">
                                                <option value="">&nbsp;</option>
                                               {foreach from=$extraFields.$colone_name.ref_fields item=extraField}
                                                    <option value="{$extraField.COLUMN_NAME}">{$extraField.COLUMN_NAME}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                </div> 
                            </fieldset>
                        {/if}
                    {else}
                        <div class="form-group text-align-center">
                            <div class="col-sm-12">
                                <select id="attrib-type" name="type[{$attribute.COLUMN_NAME}]" style="color:black;" class="form-control">
                                    <option value="text">Text</option>
                                    <option value="radio">Radio</option>
                                    <option value="select">Combobox</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="text_enrichi">Text Enrichi</option>
                                    <option value="colorpicker">Colorpicker</option>
                                    <option value="datepicker">datepicker</option>
                                    <option value="file">file</option>
                                    <option value="active">Active</option>
                                    <option value="date">Date</option>
                                </select>
                            </div>
                        </div>
                    {/if}
                </td>
                <td>
                    <div class="form-group">
                        <div class="col-sm-12" style="margin: 12px 0 0 56px;">
                            <input type="checkbox" class="ckbox ckbox text-align-center" checked name="aficher_form[{$attribute.COLUMN_NAME}]" >
                        </div>
                  </div>
                </td>
                <td>
                    <div class="form-group">
                        <div class="col-sm-12" style="margin: 12px 0 0 56px;">
                            <input type="checkbox" class="ckbox ckbox text-align-center" checked name="aficher_liste[{$attribute.COLUMN_NAME}]" >
                        </div>
                  </div>
                </td>
                <td>
                    <div class="form-group">
                        <div class="col-md-12" style="margin: 12px 0 0 56px;">
                            <input type="checkbox" class="ckbox ckbox-danger text-align-center" checked name="recherche[{$attribute.COLUMN_NAME}]" >
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <div class="col-md-12" style="margin: 12px 0 0 56px;">
                            <input type="checkbox" class="ckbox ckbox text-align-center" checked name="requied[{$attribute.COLUMN_NAME}]" >
                        </div>
                    </div>
                </td>
                
            </tr>
        {/foreach}
    </tbody>
    {/if}
</table>