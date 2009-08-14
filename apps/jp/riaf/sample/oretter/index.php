<?php require dirname(__FILE__). '/__settings__.php'; app(); ?>
<app name="Oretter">
    <handler>
        <map url="^/status/(\d+)" template="statuses_detail.html" class="jp.riaf.generic.flow.Status" method="model" />
        <map url="^/update" class="jp.riaf.generic.flow.Status" method="create" redirect="/" />
        <map template="statuses.html" class="jp.riaf.generic.flow.Status" method="models" />
    </handler>
</app>
