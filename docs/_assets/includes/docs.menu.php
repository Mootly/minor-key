<?php
/**
  * Create a static menu for the documentation section.
  * This will probably be replacd with a database generated one at some point.
  *
  * Invoke after config and setting variables. Will build $mpo_parts->page_menu.
  * Set $mpo_parts->pagemenu to 'import' to use $mpo_parts->page_menu.
  *
  * @copyright 2018 Mootly Obviate - See /LICENSE.md
  * @package   moosepress
  * --------------------------------------------------------------------------- */
ob_start();
?>
<nav class="page-nav">
  <div id="page-nav-toggle" class="mobile-only">
    <a href="#" role="button" id="page-menu-control" aria-hidden="true"><i class="fa fa-bars"></i> Section Navigation</a>
  </div>
  <div id="page-nav-body" class="mobile-hidden">
    <ul id="page-nav-list">
      <li class="top-page"><a href="/docs/">Help Pages Home</a></li>
      <li class="collapse-header closed"><a href="#">Style Guide</a>
        <ul class="page-nav-sublist collapse-list hidden">
          <li><a href="/docs/styles/">Style Guide</a></li>
          <li><a href="/docs/styles/callouts.php">Text Elements</a></li>
          <li><a href="/docs/styles/headings.php">Headings</a></li>
          <li><a href="/docs/styles/links.php">Links &amp; Images</a></li>
          <li><a href="/docs/styles/lists.php">Lists</a></li>
          <li><a href="/docs/styles/tables.php">Tables</a></li>
          </ul>
      </li>
      <li class="collapse-header closed"><a href="#">Developer Notes</a>
        <ul class="page-nav-sublist collapse-list hidden">
          <li><a href="/docs/dev-notes/">Developer Notes</a></li>
          <li><a href="/docs/dev-notes/organization.php">Code Organization</a></li>
          <li><a href="/docs/dev-notes/naming.php">Naming Conventions</a></li>
          <li><a href="/docs/dev-notes/comments.php">Comments</a></li>
        </ul>
      </li>
      <li class="collapse-header closed"><a href="#">Object Library</a>
        <ul class="page-nav-sublist collapse-list hidden">
          <li><a href="/docs/objects/">Style Guide</a></li>
          <li><a href="/docs/objects/callouts.php">Text Elements</a></li>
          <li><a href="/docs/objects/headings.php">Headings</a></li>
          <li><a href="/docs/objects/links.php">Links &amp; Images</a></li>
          <li><a href="/docs/obects/lists.php">Lists</a></li>
          <li><a href="/docs/objects/tables.php">Tables</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<?php
$mpo_parts->page_menu = ob_get_clean();
ob_end_clean();
?>
