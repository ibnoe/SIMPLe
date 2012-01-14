<?php
$nav_dashboard = $nav_helpdesk = $nav_frontdesk = $nav_knowledge_base = $nav_forum = '';

switch ($this->uri->segment(2)) {
    case 'dashboard':
        $nav_dashboard = 'current';
        break;
    case 'helpdesk':
        $nav_helpdesk = 'current';
        break;
    case 'frontdesk':
        $nav_frontdesk = 'current';
        break;
    case 'knowledge_base':
        $nav_knowledge_base = 'current';
        break;
    case 'man_forum':
        $nav_forum = 'current';
        break;
}
$nav_referensi = '';
if ($this->uri->segment(1) == 'referensi') {
    $nav_referensi = 'current';
}
if ($this->uri->segment(1) == 'knowledge') {
    $nav_knowledge = 'current';
}
?>


<div id="navbar" class="clearfloat">
    <ul class="sf-menu">
        <li><?php echo anchor('dirjen/dashboard', 'Dashboard', "class='$nav_dashboard'");?></li>
        <li><?php echo anchor('dirjen/helpdesk', 'Helpdesk', "class='$nav_helpdesk'");?></li>
        <li><?php echo anchor('dirjen/frontdesk', 'Front Desk', "class='$nav_frontdesk'");?></li>
        <li><?php echo anchor('knowledge', 'Knowledge Base', "class='$nav_knowledge_base'");?></li>
        <li><?php echo anchor('referensi', 'Referensi Peraturan', "class='$nav_referensi'") ?></li>
        <li><?php echo anchor('frontdesk/man_forum', 'Forum', "class='$nav_forum'");?></li>
    </ul>
</div>
