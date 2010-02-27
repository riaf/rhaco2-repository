<?php require dirname(__FILE__)."/__settings__.php"; app(); ?>
<app name="wiki" summary="wiki">
	<description>wiki</description>
	<handler>
	    <module class="jp.riaf.flow.module.HtmlAutoEscape" />
	    <map url="" class="jp.riaf.flow.parts.Wiki" method="model" template="page.html" />
	    <maps class="jp.riaf.flow.parts.Wiki">
	        <map url="e/(.*?)" method="edit" template="edit.html" />
	        <map url="s" method="search" template="search.html" />
	        <map url="(.*?)" method="model" template="page.html" summary="" />
	    </maps>
	</handler>
</app>
