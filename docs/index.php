<?php
/* === Style Guide: Text and Callouts ========================================= *
 * Copyright (c) 2017-2018 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2018-05-09 | Copied over from test page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
require_once( $mpo_paths->php_widgets.'/menus/simple_crumbs.php' );
# --- ↓↓↓ EDIT VARIABLES BELOW ↓↓↓ -------------------------------------------- ***
$mpo_parts->h1_title          = 'MoosePress Docs';
$mpo_parts->link_title        = 'MoosePress Docs';
                    # page_name should equal your H1 title.
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Documentation';
$mpo_parts->accessibility     = 'standard';
// $mpo_parts->pagemenu          = 'docs.internal';
$mpo_parts->bodyclasses       = 'final';
$page_path                    = $mpo_parts->page_path;
ob_start();
# --- ↓↓↓ EDIT CONTENT BELOW ↓↓↓ ---------------------------------------------- ***
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
?>
<h2 id="toc-links">Contents</h2>

<h2>Code organization</h2>

<p>These are the basic rules set out for writing code for this application.</p>

<p>The standards are kept pretty loose, but should be adhered to.</p>

<h3 class="add-toc">Component separation and processing order</h3>

<p>All core code has been written with the unidirectional flow described below. You can iterate, but not move backwards.</p>

<p>Direction of flow is enforced by encapsulation and an expection that a particular type of object will be passed each step of the way. Core files will include the following strings to indicate what part of the process they are involved with.</p>

<p>Request evaluation and computation:</p>
<dl class="inline-terms">
  <dt id="dfn-process-init">init</dt><dd>Initialize core.</li></dd>
  <dt id="dfn-process-grab">grab</dt><dd>Retrieve requests and accompanying data.</dd>
  <dt id="dfn-process-proc">proc</dt><dd>Process request data and gather response data.</dd>
</dl>

<p>Response assembly and presentation:</p>
<dl class="inline-terms">
  <dt id="dfn-process-prep">prep</dt><dd>Use the template to prepare response for presentation</dd>
  <dt id="dfn-process-send">send</dt><dd>Send response</dd>
</dl>

<!-- *** NAMING CONVENTIONS *** ********************************** -->
<h3 class="add-toc">Naming conventions</h3>

<p>MoosePress uses prefixes to designate namespaces reserved for use by core and to designate certain categories of variables. These prefexes are broken out by what they label.</p>

<p>Reserved prefixes:</p>
<dl class="inline-terms">
  <dt id="dfn-prefix-usc">_ <small>(underscore)</small></dt><dd>System folders in root begin with an underscore to float them to the top. These are <b>_assets</b>, <b>_core</b>, and <b>_vendors</b>.</dd>
  <dt id="dfn-prefix-mppost">DEF_</dt><dd>Site specific default constants. These should only be set in <b>init.php</b> or the template-specific equivalent.</dd>
  <dt id="dfn-prefix-mp">mp_</dt><dd>General use to clarify files and directories as part of the  code base.</dd>
  <dt id="dfn-prefix-mpk">MP_</dt><dd>Constants defined by core.</dd>
  <dt id="dfn-prefix-mpc">mpc_</dt><dd>Class definitions. There may be a fourth letter to specify specific the nature of the class definition.</dd>
  <dt id="dfn-prefix-mpf">mpf_</dt><dd>Functions. All public core functions are prefixed with <b>mkf_</b></dd>
  <dt id="dfn-prefix-mpo">mpo_</dt><dd>Object instances. All instantiated core objects should be prefixed with <b>mpo_</b>.</dd>
  <dt id="dfn-prefix-mpv">mpt_</dt><dd>Template settings.</dd>
  <dt id="dfn-prefix-mpv">mpv_</dt><dd>Variables. Most public core variables are prefixed with <b>mpv_</b>.</dd>
  <dt id="dfn-prefix-mppre">mppre_</dt><dd>User defined functions to run before a core function of the same name. Not all functions support this.</dd>
  <dt id="dfn-prefix-mppost">mppost_</dt><dd>User defined functions to run after a core function of the same name. Not all functions support this.</dd>
  <dt id="dfn-prefix-mppost">t_, temp_</dt><dd>Temporary variables. They should be assumed to contain garbage and should never be used across more than a few lines of code.</dd>
  <dt id="dfn-prefix-mppost">tp_</dt><dd>Overrides from the current template.</dd>
  <dt id="dfn-prefix-mppost">tpo_</dt><dd>Object instances. All instantiated objects from a template library should be prefixed with <b>mpo_</b>.</dd>
</dl>

<!-- *** COMMENT STLYES *** ************************************** -->

<h3 class="add-toc">Commenting the code</h3>

<p>MoosePress uses multiple types of commments, depending on function.</p>
<p>All comments in the code should be written to be stripped out by the parser unless otherwise noted.</p>
<dl class="inline-terms">
  <dt id="dfn-comments-block">simple block</dt>
  <dd>
    A basic block or multiline comment uses slashterisk notation.
    <pre>/*<br /> * Some long decription<br /> */</pre>
  </dd>
  <dt id="dfn-comments-block">PHPDoc</dt>
  <dd>
    A comment block that documents how functions or objects work, or catalogs the contents of the current file, uses the modified slashterisk format to conform to PHPDoc standard. This allows PHPDoc-aware editors to color code keywords in the comments, as well as allowing a PHPDoc parser to generate documentation from the comments.
    <pre>/**<br />  * Some long decription<br />  */</pre>
  </dd>
  <dt id="dfn-comments-block">inline</dt>
  <dd>
    Where possible, inline comments beign with a hash mark: <code>#</code>. This is to differentiate it from commented-out code.
    <pre># inline comment</pre>
    For section breaks, or to call out a comment, use one or more asterisks at the end to make it easier to scan for comments.
    <pre># Do some new stuff -------------------------------------------------- ***</pre>
  </dd>
  <dt id="dfn-comments-block">inactive code</dt>
  <dd>
    Code is commented out with a double slash <code>//</code>. This is the default in PHP, so if you use hot keys to comment out blocks of code, it is what you will get.
    <pre>// echo testvar;</pre>
  </dd>
  <dt id="dfn-comments-block">template</dt>
  <dd>
    Twig uses the following syntax for comments in its templates.
    <pre>{# Your comment here #}</pre>
  </dd>
  <dt id="dfn-comments-block">important</dt>
  <dd>
    For important comments that need to be preserved when minifying CSS and JavaScript, most parsers follow the system of including an exclamation mark after the opening tag of the comment. It is most commonly used to preserve copyright information or attributions.
    <pre>/*! Keep this comment intact! */</pre>
  </dd>
</dl>

<!-- *** OBJECTS *** ********************************************* -->
<h2>Objects</h2>

<p>Minor Key uses objects for tracking various page components and some of the site settings. This is to make the code easier to use and to allow for automated validation of various elements.</p>

<!-- *** menu object *** *************************************** -->
<h3 class="add-toc">mpc_menus</h3>

<p>The <cite>menu</cite> object stores the menu sets for a page.</p>

<p>Except for instantiation, method calls to the menus object always return arrays. The return array will have the following stucture:</p>

<dl>
  <dt><code>results['success'] bool</code></dt>
  <dd>
    <p>Returns true on success, false on an error.</p>
  </dd>
  <dt><code>results['content'] string | array</code></dt>
  <dd>
    <p>If there was an error, this will contain the error message associated with the reference code above. Otherwise it will return the string or array containing the returned values.</p>
  </dd>
</dl>

<p>At present, there is no functionality to:</p>
<ul>
  <li>remove menus or links from the menus object</li>
  <li>edit individual menu or link properties</li>
</ul>

<p>These are beyond the scope of the minimum viable product.</p>

<dl class="clamshell">

<dt>Constructor</dt>
  <dd>
    <pre>$mpo_menus = new $mpc_menus( [bool $is_locked=true] );</pre>

    <p>Use <code>$is_locked</code> to specify existing values as immutable. This allows later scripts to add new menus and add new links to menus, but not change the attributes of existing links or menus.</p>

    <p>It is set to <code>true</code> by default.</p>
  </dd>
<dt>Create or edit menu</dt>
  <dd>
    <p>If a menu and its menu set is not locked, this method can be used to reset a menu.</p>

    <pre>$mpo_menus->setmenu( str $name  [, array $settings] );</pre>

    <p>Settings:</p>

    <dl>
    <dt><code>$settings['is_locked'] bool = false</code></dt>
      <dd><p>A menu can be locked spearately from the menu set. Setting this to false will not override a parent setting of true.</p></dd>
    <dt><code>$settings['permissions'] string = 'public'</code></dt>
      <dd>
        <p>A space separated string of permission levels for this menu. These are restrictive values. The string must be provided when generating the menu or the menu is blocked. The value of 'public' is a placeholder and is ignored by the code. Current permission levels are:</p>
        <ul>
          <li>public</li>
          <li>internal</li>
          <li>editor</li>
          <li>pio</li>
          <li>admin</li>
        </ul>
      </dd>
    <dt><code>$settings['type'] string = 'left-sidebar'</code></dt>
      <dd>
        <p>A template specific description of the function this menu serves. Most commonly, its location on the page.</p>
      </dd>
    <dt><code>$settings['classes'] string = ''</code></dt>
      <dd>
        <p>A space separated list of classes to be added to the container element when generating the menu.</p>
      </dd>
    </dl>
  </dd>
<dt>Create or edit a link</dt>
  <dd>
    <pre>$mpo_menus->setlink( str $menu, string $text, str $url [, array $settings] );</pre>
  </dd>
<dt>Return a menu as an HTML list</dt>
  <dd>
    <pre>$result = $mpo_menus->getmenu( str $name [, array $settings ] );</pre>
  </dd>
<dt>Return a menu as an array</dt>
  <dd>
    <pre>$result = $mpo_menus->getlist( str $name [, array $settings ] );</pre>
  </dd>
<dt>Return the properties of a menu</dt>
  <dd>
    <pre>$result = $mpo_menus->getmenuprop( str $menu, str $property );</pre>
  </dd>
<dt>Return the properties of a link</dt>
  <dd>
    <pre>$result = $mpo_menus->getlink( str $menu, str $text [, array $settings] );</pre>
  </dd>
</dl>

<!-- *** parts object *** **************************************** -->
<h3 class="add-toc">mpc_parts</h3>

<p>The <cite>parts</cite> object contains information fields for a page as well as a content blob.</p>

<p>It can also be used recursively for page components.</p>

<p>It uses magic functions to generate properties as needed. The properties defined on initialization and/or instantiation or otherwise used by the default page templates are:</p>

<ul>
  <li>bodyclasses</li>
  <li>page_name</li>
  <li>page_path</li>
  <li>page_title</li>
  <li>section_name</li>
  <li>separator *</li>
  <li>site_abbr</li>
  <li>site_name</li>
  <li>template</li>
  <li>title_struct *</li>
</ul>

<p><small>* These are not part of the final component array.</small></p>

<dl class="clamshell">

  <dt>Constructor</dt>
  <dd>
    <pre>$mpo_parts = new $mpc_parts( [bool $is_locked=false] );</pre>

    <p>On instantiation, can be passed boolean to determine whether to protect existing values. When protected, you can add new page components, but not overwrite old.</p>
  </dd>

  <dt>Store or update a page component</dt>
  <dd>
    <pre>$mpo_parts-><var>component</var> = <var>value</var>;</pre>

    <p>Uses magic functions to generate properties as needed.</p>
  </dd>

  <dt>Return a page component</dt>
  <dd>
    <pre>$result = $mpo_parts-><var>component</var>;</pre>
  </dd>

  <dt>Set the page title</dt>
  <dd>
    <p>There are two parts to setting the page title:</p>
    <ul>
      <li>specifying the format, and</li>
      <li>specifying the values.</li>
    </ul>
    <p>The format consists of an array of the names of the property to be concatenated, in order of appearance, and the separator to use between them, including spaces.</p>
    <p>The default format and values are as follows:</p>
    <pre>
// set the structure
$mpo_parts->title_struct  = ['page_name','section_name','site_name'];
$mpo_parts->separator     = ' | ';
// set the parts
$mpo_parts->page_name     = <var>value</var>;
$mpo_parts->section_name  = <var>value</var>;
$mpo_parts->site_name     = <var>value</var>;</pre>
  <p>A simple title including just the page name would be formatted as follows:</p>
  <pre>
$mpo_parts->title_struct  = ['page_name'];
$mpo_parts->separator     = '';
$mpo_parts->page_name     = <var>value</var>;</pre>
  </dd>

  <dt>Return the complete page title for the title bar</dt>
  <dd>
    <pre>$result = $mpo_parts->build_title();</pre>

    <p>This action is performed automatically when you build the page.</p>
    <p>The default title has the format of: <b><var>page name</var> | <var>section name</var> | <var>site name</var></b>. Empty components will be omitted from the string.</p>
  </dd>

  <dt>Return an array of all page components</dt>
  <dd>
    <pre>$result = $mpo_parts->build_page();</pre>

    <p>The results include an arry of all page components added by the name of the property to which they were assigned.</p>
  </dd>

</dl>

<!-- *** paths object *** **************************************** -->
<h3 class="add-toc">mpc_paths</h3>

<p>The <cite>paths</cite> object stores internal paths for PHP use. This is to allow paths to be defined up front and then called from the object. This reduces typos and inconsistencies.</p>

<p>If a path is hard-coded in the process code instead of being defined in the config or init files, you did something wrong.</p>

<p>It uses magic functions to generate properties as needed. The properties defined on initialization and/or instantiation are:</p>

<ul>
  <li>core</li>
  <li>mp_classlib</li>
  <li>template</li>
  <li>tp_classlib</li>
  <li>vendor</li>
</ul>

<dl class="clamshell">

  <dt>Constructor</dt>
  <dd>
    <pre>$mpo_paths = new $mpc_paths( [bool $is_locked=false] );</pre>

    <p>On instantiation, can be passed boolean to determine whether to protect existing values. When protected, you can add new paths, but not overwrite old.</p>
  </dd>

  <dt>Store or update a path</dt>
  <dd>
    <pre>$mpo_paths-><var>path</var> = <var>value</var>;</pre>

    <p>Uses magic functions to generate properties as needed.</p>
  </dd>

  <dt>Return a path</dt>
  <dd>
    <pre>$result = $mpo_paths-><var>path</var>;</pre>
  </dd>

  <dt>Return all paths in an array</dt>
  <dd>
    <pre>$result = $mpo_paths->build_list();</pre>
  </dd>
</dl>
<?php
# --- ↑↑↑ EDIT CONTENT ABOVE ↑↑↑ ---------------------------------------------- ***
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpt_full_template, array('page'=>$page_elements['content'])));
?>
