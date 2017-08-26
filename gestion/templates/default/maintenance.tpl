
<div class="panel panel-danger">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="glyphicon glyphicon-cog"></i> Maintenance</h4>
    </div>
    {nocache}
    <form action="" method="post">
        <div class="panel-body">
            <p style="float: left;">Passer le site en maintenance :</p>
    {*            <input type="radio" name="conf_maintenance" id="maintenance1" value="1"{if $s_config.usr.maintenance=="1"} checked{/if}> <label for="maintenance1">Oui</label> <input type="radio" name="conf_maintenance" id="maintenance0" value="0"{if $s_config.usr.maintenance=="0"} checked{/if}> <label for="maintenance0">Non</label><br>*}
            <label class="rdiobox rdiobox-danger" style="margin-left: 12px; float: left;">
                <input type="radio" name="conf_maintenance" id="maintenance1" value="1"{if $s_config.usr.maintenance=="1"} checked{/if}>
                <span>Oui</span>
            </label>
            <label class="rdiobox rdiobox-danger" style="margin-left: 7px; float: left;">
                <input type="radio" name="conf_maintenance" id="maintenance0" value="0"{if $s_config.usr.maintenance=="0"} checked{/if}>
                <span>Non</span>
            </label><br>
            <p style="float: left; clear: both;">Adresses IP autorisées (une par ligne):</p><br>
            <textarea style="float: left; clear: both;" name="conf_maintenance_ip" cols="30" rows="20">{$s_config.usr.maintenance_ip}</textarea>
            <br>
        </div>
        <div class="panel-footer" style="clear: both;">
            <center><input type="submit" class="btn btn-danger btn-quirk" name="Enregistrer" value="Enregistrer"><a class="btn btn-default" href="?clearcache">Vider le cache</a></center>
        </div>
    </form>
    {/nocache}
</div>