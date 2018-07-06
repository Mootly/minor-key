<?php
/**
  * Documentation Menu.
  * --------------------------------------------------------------------------- */
ob_start();
?>
<nav class="page-nav">
  <div id="page-nav-toggle" class="mobile-only">
    <a href="#" role="button" id="page-menu-control" aria-hidden="true"><i class="fa fa-bars"></i> Section Navigation</a>
  </div>
  <div id="page-nav-body" class="mobile-hidden">
    <ul id="page-nav-list">
      <li class="top-page"><a href="<?= $mpo_parts->section_base; ?>">Documentation Home</a></li>
      <li class="collapse-header closed"><a href="#">Style Guide</a>
        <ul class="page-nav-sublist collapse-list hidden">
          <li><a href="<?= $mpo_parts->section_base; ?>/styles/">Style Guide Home</a></li>
          <li><a href="<?= $mpo_parts->section_base; ?>/styles/callouts.php">Text Elements &amp; Callouts</a></li>
          <li><a href="<?= $mpo_parts->section_base; ?>/styles/headings.php">Headings</a></li>
          <li><a href="<?= $mpo_parts->section_base; ?>/styles/links.php">Links &amp; Images</a></li>
          <li><a href="<?= $mpo_parts->section_base; ?>/styles/lists.php">Lists</a></li>
          <li><a href="<?= $mpo_parts->section_base; ?>/styles/tables.php">Tables</a></li>
          </ul>
      </li>
      <li class="collapse-header closed"><a href="#">Developer Notes</a>
        <ul class="page-nav-sublist collapse-list hidden">
          <li><a href="<?= $mpo_parts->section_base; ?>/dev-notes/">Developer Notes</a></li>
          <li><a href="<?= $mpo_parts->section_base; ?>/dev-notes/organization.php">Code Organization</a></li>
          <li><a href="<?= $mpo_parts->section_base; ?>/dev-notes/naming.php">Naming Conventions</a></li>
          <li><a href="<?= $mpo_parts->section_base; ?>/dev-notes/comments.php">Comments</a></li>
        </ul>
      </li>
      <li class="collapse-header closed"><a href="#">Class Library</a>
        <ul class="page-nav-sublist collapse-list hidden">
          <li><a href="<?= $mpo_parts->section_base; ?>/classes/">Class List</a></li>
          <li><a href="<?= $mpo_parts->section_base; ?>/classes/mpc_menus.php">mpc_menus</a></li>
          <li><a href="<?= $mpo_parts->section_base; ?>/classes/mpc_parts.php">mpc_parts</a></li>
          <li><a href="<?= $mpo_parts->section_base; ?>/classes/mpc_paths.php">mpc_paths</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<?php
$mpo_parts->page_menu = ob_get_clean();
ob_end_clean();
?>
