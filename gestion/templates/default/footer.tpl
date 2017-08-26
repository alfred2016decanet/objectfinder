{*utf8 é*}   
{if $logged}
            </div>
        </div><!-- contentpanel -->
      </div><!-- mainpanel -->
</section>
{/if}

<script type="text/javascript">
	var rootDir = "{$rootDir}";
</script>

{foreach from=$liste_js item=js}
	<script type="text/javascript" src="{if $js|substr:0:4!="http"}{*$URL_STATIC*}{/if}{$js}"></script>
{/foreach}

{if isset($ok)}{literal}
<script type="text/javascript">
$(document).ready(function() {$.gritter.add({
  title: 'Opération réussie',
  text: 'Vos modifications ont bien été enregistrées.',
  class_name: 'with-icon check-circle success'
});
});
</script>{/literal}{/if}
{if isset($error1)}{literal}
<script type="text/javascript">
$(document).ready(function() {$.gritter.add({
  title: 'Echec',
  text: 'Le mot de passe actuel est incorrect.',
  class_name: 'with-icon check-circle danger'
});
});
</script>{/literal}{/if}
{if isset($error2)}{literal}
<script type="text/javascript">
$(document).ready(function() {$.gritter.add({
  title: 'Echec',
  text: 'Les mots de passe saisis ne sont pas identiques.',
  class_name: 'with-icon check-circle danger'
});
});
</script>{/literal}{/if}
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="{$s_config.assetPath}lib/html5shiv/html5shiv.js"></script>
  <script src="{$s_config.assetPath}lib/respond/respond.src.js"></script>
  <![endif]-->
{if isset($include_js)}<script type="text/javascript" src="{$URL_STATIC}{$include_js}"></script>{/if}
{if isset($scripts_js)}<script type="text/javascript">{$scripts_js}</script>{/if}

{if $s_page == "graphique"}
<script type="text/javascript">
$(function () {	
    $('#container').highcharts({
        chart: {
            zoomType: 'x'
        },
        title: {
            text: '{if $service=="load"}Charge du serveur (load){else if $service=="mem"}Consommation de la RAM (en %){else if $service=="swap"}Consommation de l\'espace swap (en %){else}Consommation du processeur (en %){/if}'
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                    'Cliquez et déplacez le curseur sur la période sur laquelle zoomer' :
                    'Pinch the chart to zoom in'
        },
        xAxis: {
            type: 'datetime',
            minRange: 1 * 24 * 3600000 // fourteen days
        },
        yAxis: {
            title: {
                text: '{if $service=="load"}Charge{else if $service=="mem"}Mémoire{else if $service=="swap"}SWAP{else}CPU{/if}'
            },
			min: 0
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }
        },

        series: [{
            type: 'area',
            name: '{if $service=="load"}Charge{else if $service=="mem"}Mémoire{else if $service=="swap"}SWAP{else}CPU{/if}',
            data: {$data},
			pointInterval: 60 * 1000,
			pointStart: {$startdate}
        }]
    });
});
</script>
{/if}

</body>
</html>