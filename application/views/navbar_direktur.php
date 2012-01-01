<?php
$nav_dashboard = $nav_knowledge = $nav_forum =  $nav_frontdesk =
$nav_helpdesk = '';

switch ($this->uri->segment(2)) {
    case 'dashboard':
        $nav_dashboard = 'current';
        break;
    case 'frontdesk':
        $nav_frontdesk = 'current';
        break;
    case 'helpdesk':
        $nav_helpdesk = 'current';
        break;
    case 'knowledge_base':
        $nav_knowledge = 'current';
        break;
    case 'man_forum':
        $nav_forum = 'current';
        break;
}
?>

<div id="navbar" class="clearfloat">
    <ul class="sf-menu">
        <li class="<?php echo $nav_dashboard ?>"><?php echo anchor('direktur/dashboard', 'Dashboard');?></li>
        <li class="<?php echo $nav_helpdesk ?>"><?php echo anchor('direktur/helpdesk', 'Helpdesk');?></li>
        <li class="<?php echo $nav_frontdesk ?>"><?php echo anchor('direktur/frontdesk', 'Front Desk');?></li>
        <li class="<?php echo $nav_knowledge ?>"><?php echo anchor('direktur/knowledge_base', 'Knowledge Base');?></li>
        <li class=""><a href="<?php echo base_url() . 'upload/PMK-93.pdf' ?>" target="pdf">Referensi Peraturan</a></li>
        <li class="<?php echo $nav_forum ?>"><?php echo anchor('direktur/man_forum', 'Forum');?></li>
    </ul>
    <div id="logout"><?php echo $this->session->userdata('nama') ?> &nbsp; | &nbsp; <?php echo anchor("login/process_logout", 'Logout') ?> &nbsp; <em><?php echo date('d-m-Y') ?></em></div>
</div>
