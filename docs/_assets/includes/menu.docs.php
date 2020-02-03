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
      <li class="top-page"><a href="/docs/">Documentation Home</a></li>
      <li class="collapse-header closed"><a href="#">Style Guide</a>
        <ul class="page-nav-sublist collapse-list hidden">
          <li><a href="/docs/styles/">Style Guide Home</a></li>
          <li><a href="/docs/styles/callouts.php">Text Elements &amp; Callouts</a></li>
          <li><a href="/docs/styles/headings.php">Headings</a></li>
          <li><a href="/docs/styles/links.php">Links &amp; Images</a></li>
          <li><a href="/docs/styles/lists.php">Lists</a></li>
          <li><a href="/docs/styles/tables.php">Tables</a></li>
          <li><a href="/docs/styles/forms.php">Forms</a></li>
        </ul>
      </li>
      <li class="collapse-header closed"><a href="#">CMS Developer Notes</a>
        <ul class="page-nav-sublist collapse-list hidden">
          <li><a href="/docs/dev-notes/">CMS Dev Notes Home</a></li>
          <li><a href="/docs/dev-notes/organization.php">Code Organization</a></li>
          <li><a href="/docs/dev-notes/widget-template.php">Twig Widgets</a></li>
          <li><a href="/docs/dev-notes/comments.php">Comments</a></li>
          <li><a href="/docs/dev-notes/constants.php">Constants</a></li>
          <li><a href="/docs/dev-notes/naming.php">Naming Conventions</a></li>
        </ul>
      </li>
      <li class="collapse-header closed"><a href="#">Class Library</a>
        <ul class="page-nav-sublist collapse-list hidden">
          <li><a href="/docs/classes/">Class List</a></li>
          <li><a href="/docs/classes/mpc_cookies.php">mpc_cookies</a></li>
          <li><a href="/docs/classes/mpc_db.php">mpc_db</a></li>
          <li><a href="/docs/classes/mpc_db.php">mpc_db</a></li>
          <li><a href="/docs/classes/mpc_menus.php">mpc_menus</a></li>
          <li><a href="/docs/classes/mpc_parts.php">mpc_parts</a></li>
          <li><a href="/docs/classes/mpc_paths.php">mpc_paths</a></li>
          <li><a href="/docs/classes/mpc_sessions.php">mpc_sessions</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<?php
$mpo_parts->menu_left_content = ob_get_clean();
ob_end_clean();
?>
