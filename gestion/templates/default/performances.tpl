
<div class="panel panel-danger">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="glyphicon glyphicon-cog"></i> Performances</h4>
    </div>
    {nocache}
    <form action="" method="post">
    <div class="panel-body">
        <div class="row-fluid">
            <div class="panel panel-default">
                <div id="cache">
                        <legend><b>Système de cache</b></legend>
                        <p style="float: left;">Mode de cache :</p> 
{*                        <input type="radio" name="conf_caching" id="caching_disk" value="disk"{if $s_config.usr.caching=="disk"} checked{/if}> <label for="caching_disk">Disque dur</label>*}
                        <label class="rdiobox rdiobox-danger" style="margin-left: 73px; float: left;">
                            <input type="radio" name="conf_caching" id="caching_disk" value="disk"{if $s_config.usr.caching=="disk"} checked{/if}>
                            <span>Disque dur</span>
                        </label>
{*                        <input type="radio" name="conf_caching" id="caching_memcache" value="memcache"{if $s_config.usr.caching=="memcache"} checked{/if}> <label for="caching_memcache">Serveur Memcached</label><br>*}
                        <label class="rdiobox rdiobox-danger" style="margin-left: 7px; float: left;">
                            <input type="radio" name="conf_caching" id="caching_memcache" value="memcache"{if $s_config.usr.caching=="memcache"} checked{/if}>
                            <span>Serveur Memcached</span>
                        </label><br>
                   <div id="div_memcache"{if $s_config.usr.caching=="disk"} style="display:none; clear: both;"{/if}>
                  Liste des serveurs Memcache:<br>
                    1 - IP : <input type="text" name="memcache[0][ip]" value="{$memcache_servers.0->ip|escape}"> Port : <input type="text" name="memcache[0][port]" size="10" value="{$memcache_servers.0->port|escape}"><br>
                    2 - IP : <input type="text" name="memcache[1][ip]" value="{$memcache_servers.1->ip|escape}"> Port : <input type="text" name="memcache[1][port]" size="10" value="{$memcache_servers.1->port|escape}"><br>
                    3 - IP : <input type="text" name="memcache[2][ip]" value="{$memcache_servers.2->ip|escape}"> Port : <input type="text" name="memcache[2][port]" size="10" value="{$memcache_servers.2->port|escape}"><br>
                    4 - IP : <input type="text" name="memcache[3][ip]" value="{$memcache_servers.3->ip|escape}"> Port : <input type="text" name="memcache[3][port]" size="10" value="{$memcache_servers.3->port|escape}"><br>
                    5 - IP : <input type="text" name="memcache[4][ip]" value="{$memcache_servers.4->ip|escape}"> Port : <input type="text" name="memcache[4][port]" size="10" value="{$memcache_servers.4->port|escape}"><br>
                   </div>
                </div><br>
                <div id="db" style="clear: both;">
                    <legend><b>Base de données</b></legend> 
                    <p style="float: left;"> Activer le cache BDD :</p>
                    <label class="rdiobox rdiobox-danger" style="margin-left: 45px; float: left;">
                        <input type="radio" name="conf_db_cache" id="db_cache_1" value="1"{if $s_config.usr.db_cache=="1"} checked{/if}>
                        <span>Oui</span>
                    </label>
                    <label class="rdiobox rdiobox-danger" style="margin-left: 7px; float: left;">
                        <input type="radio" name="conf_db_cache" id="db_cache_0" value="0"{if $s_config.usr.db_cache=="0"} checked{/if}>
                        <span>Non</span>
                    </label>
                </div><br>
                <div id="smarty" style="clear: both;">
                        <legend><b>Smarty</b></legend>
                        <p style="float: left;">Activer le cache Smarty :</p>
{*                        <input type="radio" name="conf_smarty_cache" id="smarty_cache_1" value="1"{if $s_config.usr.smarty_cache=="1"} checked{/if}> <label for="smarty_cache_1">Oui</label> <input type="radio" name="conf_smarty_cache" id="smarty_cache_0" value="0"{if $s_config.usr.smarty_cache=="0"} checked{/if}> <label for="smarty_cache_0">Non</label><br>*}
                        <label class="rdiobox rdiobox-danger" style="margin-left: 33px; float: left;">
                            <input type="radio" name="conf_smarty_cache" id="smarty_cache_1" value="1"{if $s_config.usr.smarty_cache=="1"} checked{/if}>
                            <span>Oui</span>
                        </label>
                        <label class="rdiobox rdiobox-danger" style="margin-left: 7px; float: left;">
                            <input type="radio" name="conf_smarty_cache" id="smarty_cache_0" value="0"{if $s_config.usr.smarty_cache=="0"} checked{/if}>
                            <span>Non</span>
                        </label><br>
                        <p style="float: left; clear: both;">Durée du cache : <input  style="margin-left: 70px;" type="text" size="10" name="conf_smarty_cachetime" value="{$s_config.usr.smarty_cachetime|intval}"> secondes</p><br>
                        <p style="float: left; clear: both;">Forcer la compilation :</p>
{*                        <input type="radio" name="conf_smarty_forcecompile" id="smarty_forcecompile_1" value="1"{if $s_config.usr.smarty_forcecompile=="1"} checked{/if}> <label for="smarty_forcecompile_1">Oui</label> <input type="radio" name="conf_smarty_forcecompile" id="smarty_forcecompile_0" value="0"{if $s_config.usr.smarty_forcecompile=="0"} checked{/if}> <label for="smarty_forcecompile_0">Non</label>*}
                        <label class="rdiobox rdiobox-danger" style="margin-left: 43px; float: left;">
                            <input type="radio" name="conf_smarty_forcecompile" id="smarty_forcecompile_1" value="1"{if $s_config.usr.smarty_forcecompile=="1"} checked{/if}>
                            <span>Oui</span>
                        </label>
                        <label class="rdiobox rdiobox-danger" style="margin-left: 7px; float: left;">
                            <input type="radio" name="conf_smarty_forcecompile" id="smarty_forcecompile_0" value="0"{if $s_config.usr.smarty_forcecompile=="0"} checked{/if}>
                            <span>Non</span>
                        </label>
                </div><br>
                <div id="html" style="clear: both;">
                    <legend><b>Rendu HTML</b></legend>
                    <p style="float: left;">Combiner les fichiers CSS :</p>
    {*                <input type="radio" name="conf_unifycss" id="conf_unifycss1" value="1"{if $s_config.usr.unifycss=="1"} checked{/if}> <label for="conf_unifycss1">Oui</label> <input type="radio" name="conf_unifycss" id="conf_unifycss0" value="0"{if $s_config.usr.unifycss=="0"} checked{/if}> <label for="conf_unifycss0">Non</label><br>*}
                    <label class="rdiobox rdiobox-danger" style="margin-left: 12px; float: left;">
                                <input type="radio" name="conf_unifycss" id="conf_unifycss1" value="1"{if $s_config.usr.unifycss=="1"} checked{/if}>
                                <span>Oui</span>
                            </label>
                            <label class="rdiobox rdiobox-danger" style="margin-left: 7px; float: left;">
                                <input type="radio" name="conf_unifycss" id="conf_unifycss0" value="0"{if $s_config.usr.unifycss=="0"} checked{/if}>
                    <span>Non</span></label><br>
                    <p style="float: left; clear: both;">Combiner les fichiers JS :</p>
    {*                <input type="radio" name="conf_unifyjs" id="conf_unifyjs1" value="1"{if $s_config.usr.unifyjs=="1"} checked{/if}> <label for="conf_unifyjs1">Oui</label> <input type="radio" name="conf_unifyjs" id="conf_unifyjs0" value="0"{if $s_config.usr.unifyjs=="0"} checked{/if}> <label for="conf_unifyjs0">Non</label><br>*}
                    <label class="rdiobox rdiobox-danger" style="margin-left: 23px; float: left;">
                                <input type="radio" name="conf_unifyjs" id="conf_unifyjs1" value="1"{if $s_config.usr.unifyjs=="1"} checked{/if}>
                                <span>Oui</span>
                            </label>
                            <label class="rdiobox rdiobox-danger" style="margin-left: 7px; float: left;">
                                <input type="radio" name="conf_unifyjs" id="conf_unifycss0" value="0"{if $s_config.usr.unifyjs=="0"} checked{/if}>
                    <span>Non</span></label><br>
                    <p style="float: left; clear: both;">Minimifier les fichiers CSS :</p>
    {*                <input type="radio" name="conf_minifycss" id="conf_minifycss1" value="1"{if $s_config.usr.minifycss=="1"} checked{/if}> <label for="conf_minifycss1">Oui</label> <input type="radio" name="conf_minifycss" id="conf_minifycss0" value="0"{if $s_config.usr.minifycss=="0"} checked{/if}> <label for="conf_minifycss0">Non</label><br>*}
                    <label class="rdiobox rdiobox-danger" style="margin-left: 13px; float: left;">
                                <input type="radio" name="conf_minifycss" id="conf_minifycss1" value="1"{if $s_config.usr.minifycss=="1"} checked{/if}>
                                <span>Oui</span>
                            </label>
                            <label class="rdiobox rdiobox-danger" style="margin-left: 7px; float: left;">
                                <input type="radio" name="conf_minifycss" id="conf_minifycss0" value="0"{if $s_config.usr.minifycss=="0"} checked{/if}>
                    <span>Non</span></label><br>
                    <p style="float: left; clear: both;">Minimifier les fichiers JS :</p>
    {*                <input type="radio" name="conf_minifyjs" id="conf_minifyjs1" value="1"{if $s_config.usr.minifyjs=="1"} checked{/if}> <label for="conf_minifyjs1">Oui</label> <input type="radio" name="conf_minifyjs" id="conf_minifyjs0" value="0"{if $s_config.usr.minifyjs=="0"} checked{/if}> <label for="conf_minifyjs0">Non</label><br>*}
                    <label class="rdiobox rdiobox-danger" style="margin-left: 24px; float: left;">
                                <input type="radio" name="conf_minifyjs" id="conf_minifyjs1" value="1"{if $s_config.usr.minifyjs=="1"} checked{/if}>
                                <span>Oui</span>
                            </label>
                            <label class="rdiobox rdiobox-danger" style="margin-left: 7px; float: left;">
                                <input type="radio" name="conf_minifyjs" id="conf_minifyjs0" value="0"{if $s_config.usr.minifyjs=="0"} checked{/if}>
                    <span>Non</span></label><br>
                    <p style="float: left; clear: both;">Minimifier le code HTML :</p>
    {*                <input type="radio" name="conf_minifyhtml" id="conf_minifyhtml1" value="1"{if $s_config.usr.minifyhtml=="1"} checked{/if}> <label for="conf_minifyhtml1">Oui</label> <input type="radio" name="conf_minifyhtml" id="conf_minifyhtml0" value="0"{if $s_config.usr.minifyhtml=="0"} checked{/if}> <label for="conf_minifyhtml0">Non</label><br>*}
                    <label class="rdiobox rdiobox-danger" style="margin-left: 24px; float: left;">
                                <input type="radio" name="conf_minifyhtml" id="conf_minifyhtml1" value="1"{if $s_config.usr.minifyhtml=="1"} checked{/if}>
                                <span>Oui</span>
                            </label>
                            <label class="rdiobox rdiobox-danger" style="margin-left: 7px; float: left;">
                                <input type="radio" name="conf_minifyhtml" id="conf_minifyhtml0" value="0"{if $s_config.usr.minifyhtml=="0"} checked{/if}>
                    <span>Non</span></label><br>
                </div><br><br><br>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <center><input type="submit" class="btn btn-danger btn-quirk" name="Enregistrer" value="Enregistrer"></center>
    </div>
    </form>
    {/nocache}
</div>