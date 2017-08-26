<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="MBIDA Luc Alfred - www.gdt-core.com">
  <title>{$s_config.name}</title>
  {foreach from=$liste_css item=css}
      <link href="{$css.fichier}" type="text/css" rel="stylesheet" media="{$css.media}" />
  {/foreach}
  <script>
    var id_langue = {$s_config.usr.default_lang};
  </script>
</head>
<body{if $s_page=="login" || $s_page=="signup"} class="signwrapper"{/if}>
    {if $logged}
    <header>
        <div class="headerpanel">
          <div class="logopanel">
            <h2><a href="{$rootDir}"><img src="/assets/img/logo.png"></a></h2>
          </div><!-- logopanel -->
          <div class="headerbar">
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            <div class="searchpanel">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Recherche...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="header-right">
              <ul class="headermenu">
                    <li>
                        <div id="noticePanel" class="btn-group">
                            <button class="btn btn-notice alert-notice" data-toggle="dropdown" title="Notifications"><i class="fa fa-globe"></i></button>
                            <div id="noticeDropdown" class="dropdown-menu dm-notice pull-right"></div>
                        </div>
                    </li>
                    <li>
                      <div class="btn-group">
                        <button type="button" class="btn btn-logged" data-toggle="dropdown">
                          {$currentuserinfos.prenom|encode|escape} {$currentuserinfos.nom|encode|escape}
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right">
                          <li><a href="#"><i class="glyphicon glyphicon-user"></i> Mes informations</a></li>
                          <li><a href="#"><i class="glyphicon glyphicon-cog"></i> Changer le mot de passe</a></li>
                          <li><a href="#"><i class="fa fa-at"></i> Historique des connexions</a></li>
                          <li><a href="log-out.html"><i class="glyphicon glyphicon-log-out"></i> Déconnexion</a></li>
                        </ul>
                      </div>
                    </li>
              </ul>
            </div><!-- header-right -->
          </div><!-- headerbar -->
        </div><!-- header-->
    </header>
    <section>
        <div class="leftpanel">
            <div class="leftpanelinner">
                <!-- ################## LEFT PANEL PROFILE ################## -->
                <ul class="nav nav-tabs nav-justified nav-sidebar">
                  <li class="tooltips active" data-toggle="tooltip" title="Menu principal"><a data-toggle="tab" data-target="#mainmenu"><i class="tooltips fa fa-ellipsis-h"></i></a></li>
                  <li class="tooltips" data-toggle="tooltip" title="Deconnexion"><a href="log-out.html"><i class="fa fa-sign-out"></i></a></li>
                </ul>
                <div class="tab-content">
                    <!-- ################# MAIN MENU ################### -->
                    <div class="tab-pane active" id="mainmenu">
                        <h5 class="sidebar-title">Menu</h5>
                        {include file='./menu.tpl'}
                    </div><!-- tab-pane -->
                </div><!-- tab-content -->

            </div><!-- leftpanelinner -->
        </div><!-- leftpanel -->
        <div class="mainpanel">
            <div class="contentpanel">
                {include file='./ariane.tpl'}
                <div class="row">
                    <div class="adminonline">
                        {if isset($msg_alert)}
                            <div id="alert-content">
                                 {$msg_alert}
                            </div>
                        {/if}
                    </div>
                       
    {/if}
            