<ol class="breadcrumb breadcrumb-quirk">
    {foreach from=$ariane item=ari}
        <li class="{if $ari.lien eq ''}active disabled{/if}">
            {if $ari.lien != ''}<a href="{$ari.lien}">{/if}
                {if $ari.icon != ''}
                    <i class="fa fa-{$ari.icon}" aria-hidden="true"></i>
                {/if}
                {$ari.titre}
             {if $ari.lien != ''}</a>{/if}
        </li>
    {/foreach}
</ol>


