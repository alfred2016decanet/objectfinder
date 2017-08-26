<ul class="nav nav-pills nav-stacked nav-quirk nav-quirk-danger">
    <li {if $s_page eq 'accueil'}class='active'{/if}>
        <a href="index.php"><i class="fa fa-dashboard" aria-hidden="true"></i><span class="title">Tableau de bord</span></a>
    </li>
    {if $currentuserinfos.access_all}
        <li class="nav-parent {if $s_page eq 'edit-habillage' || $s_page eq 'liste-habillages' || $s_page eq 'logo'}active open{/if}">
            <a aria-expanded="false" role="button"  href="#">
                <i class="fa fa-th-large" aria-hidden="true"></i>
                <span class="title">Site</span>
            </a>
            <ul class="children" role="menu">
                <li><a href="logo.html">Modifier le logo</a></li>
            </ul>
        </li>
    {/if}

    {if $udroits.view_2 || $currentuserinfos.access_all}
        <li class="nav-parent {if $s_page eq 'gestionnaires' || $s_page eq 'edit-gestionnaire'  || $s_page eq 'groupes' || $s_page eq 'edit-groupe'}active open{/if}">
            <a aria-expanded="false" role="button"   href="#">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span class="title">Utilisateurs</span>
            </a>
            <ul class="children" role="menu">
				{*{if $udroits.view_11 || $currentuserinfos.access_all}
					<li class="{if $s_page eq 'inscriptions'}active open{/if}">
						<a href="inscriptions.html">
							<span class="title">Clients</span>
						</a>
					</li>
				{/if}*}
                {if $udroits.view_2_2 || $currentuserinfos.access_all}<li class="{if $s_page eq 'gestionnaires' || $s_page eq 'edit-gestionnaire'}active{/if}"><a href="gestionnaires.html">Gestionnaires</a></li>{/if}
                {if $udroits.view_2_3 || $currentuserinfos.access_all}<li class="{if $s_page eq 'groupes' || $s_page eq 'edit-groupe'}active{/if}"><a href="groupes.html">Groupes</a></li>{/if}
            </ul>                      
        </li>
    {/if}

    {if $udroits.view_7 || $currentuserinfos.access_all}
        <li class="nav-parent {if $s_page eq 'langues' || $s_page eq 'edit-langue' || $s_page eq 'localisation' || $s_page eq 'traduction'}active open{/if}">
            <a aria-expanded="false" role="button"   href="#">
                <i class="fa fa-globe" aria-hidden="true"></i>
                <span class="title">Localisation</span>
            </a>
            <ul class="children" role="menu">
                <li class="{if $s_page eq 'localisation'}active{/if}"><a href="localisation.html">Localisation</a></li>
                    {if $udroits.view_7_2 || $currentuserinfos.access_all}
                    <li class="{if $s_page eq 'langues'}active{/if}">
                        <a href="langues.html">Langues</a>
                    </li>
                {/if}
                <li class="{if $s_page eq 'liste-urls'}active{/if}">
                    <a href="liste-urls.html">SEO et URLs</a>
                </li>
                {if $udroits.view_7_3 || $currentuserinfos.access_all}
                    <li class="{if $s_page eq 'traduction'}active{/if}">
                        <a href="traductions.html">Traduction</a>
                    </li>
                {/if}
            </ul>  
        </li>
    {/if}
    {if $currentuserinfos.access_all}
        <li class="nav-parent {if $s_page eq 'performances' || $s_page eq 'maintenance'}active open{/if}">
            <a aria-expanded="false" role="button"   href="#">
                <i class="fa fa-cog" aria-hidden="true"></i>
                <span class="title">Réglages</span>
            </a>
            <ul class="children" role="menu">
                <li><a class="der" href="performances.html">Performances</a></li>
                <li><a class="der" href="maintenance.html">Maintenance</a></li>
                <li><a class="der" href="securite.html">Sécurité</a></li>
                <li><a class="der" href="mail-configs.html">Services Mail</a></li>
				{*<li><a class="der" href="modules.html">Modules</a></li>*}
                <li><a class="der" href="test.html">Test formulaire</a></li>
                <li><a class="der" href="crudgenerate.html">CRUD Generator</a></li>
                <li><a class="der" href="test1.html">test1</a></li>
            </ul>
        </li>
    {/if}
</ul>