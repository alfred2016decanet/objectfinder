{if sizeof($pagination)}
    {if $pagination.nberPage>1}
        <div id="image_loader_zone">
            <img src="/assets/img/fancybox_loading.gif" alt="" />
        </div>
        <div class="pagination wrapper">
            <ul{if $pagination.classe} class="{$pagination.classe}"{/if}>
                <li class="previous"><a href="{$paramurl}?paginate=true&{if $pagination.p}{$pagination.p}{else}p{/if}={if $pagination.current_page>1}{$pagination.current_page-1}{else}1{/if}{if $pagination.type}&type={$pagination.type}{/if}{if isset($urladdparam) && $urladdparam != ""}&{$urladdparam}{/if}" displayzone="{if $pagination.zone}{$pagination.zone}{else}content{/if}" title="{l s='page précédente'}" class="navi previous_page" name="{if $pagination.current_page>1}{$pagination.current_page-1}{else}1{/if}"></a></li>
            {if $pagination.displayn}
                {if $pagination.mode==1}
                    {for $i=1 to $pagination.nberPage}
                        <li {if $i eq $pagination.nberPage}class="last-li"{/if}>
                            <a href="{$paramurl}?paginate=true&amp;{if $pagination.p}{$pagination.p}{else}p{/if}={$i}{if $pagination.type}&type={$pagination.type}{/if}{if isset($urladdparam) && $urladdparam != ""}&{$urladdparam}{/if}" title="Page {$i}" class="item_p page_{$i}{if $pagination.current_page==($i)} current{/if}{if $i eq $pagination.nberPage} nberPage{/if}" name="" displayzone="{if $pagination.zone}{$pagination.zone}{else}content{/if}">{$i}</a>
                        </li>
                    {/for}
                {else}
                <li><span class="current">{$pagination.current_page}</span> / <span class="nberPage">{$pagination.nberPage}</span></li>
                {/if}
            {/if}
                <li class="next">
                    {if !$pagination.displayn}
                        <span class="current hidden">{$pagination.current_page}</span>
                        <span class="nberPage hidden">{$pagination.nberPage}</span>
                    {/if}
                    <a href="{$paramurl}?paginate=true&{if $pagination.p}{$pagination.p}{else}p{/if}={$pagination.current_page+1}{if $pagination.type}&type={$pagination.type}{/if}{if isset($urladdparam) && $urladdparam != ""}&{$urladdparam}{/if}" title="{l s='page suivante'}" class="navi next_page" name="{$pagination.current_page+1}" displayzone="{if $pagination.zone}{$pagination.zone}{else}content{/if}"></a></li>
            </ul>
        </div>
    {else if $pagination.displayn}
    <!--div class="pagination">
        <ul>
        <li><span class="current">{*$pagination.current_page}</span> / <span class="nberPage">{$pagination.nberPage*}</span></li>
        </ul>
    </div-->
    {/if}
{/if}