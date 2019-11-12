<?php
/* === Blank Page Template ==================================================== *
 * Copyright (c) 2019 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2019-11-08 | Created.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
                    # Set our login calls up ---------------------------------- *
                    # Inactive logout is 2 hours                                *
                    # array of users - string is 'group -flag'                  *
// $valid_users        = ['CMS -g', [...]];
// require_once( $mpo_paths->template.$mpo_parts->template.'/_assets/php_widgets/login/redirect.php' );
                    # Set up our database calls ------------------------------- *
// $mp_edit_rights     = 'CMS';
// require_once( $_SERVER['DOCUMENT_ROOT'].'/_assets/php_widgets/forms/regex_patterns.php' );
// require_once( $mpo_paths->template.$mpo_parts->template.'/db_config.php' );
// $dbSession          = new mpc_db('sqlsrv', $db_login);
                    # include our data scrubber is using GET or POST values     *
// $getData            = new mpc_datacleaner($_GET);
                    # Sample DB code ------------------------------------------ *
                    # Do all data processing before generating any content      *
                    # This examples uses the pagination bar generator as a      *
                    # coding example                                            *
                    # --------------------------------------------------------- *
                    # find out how many records we have                         *
// $p_getkey           = $getData->key;
// $p_search           = '%' . preg_replace('/\s+/', '%', $p_getkey) . '%';
// $p_topic            = ($getData->topic and ($getData->topic != 'all')) ? $getData->topic : '%';
// $sqlQuery           = 'select count(*) as "seqCount" from OCFSWeb.dbo.home_page where posted_internet = 1 and Post_Home_Page = 1 and heading like ? and division like ?';
// $sqlParams          = array($p_search, $p_topic);
// $sqlOptions         = array('Scrollable' => SQLSRV_CURSOR_KEYSET);
// $t_recCount         = $dbSession->runquery( $sqlQuery, $sqlParams, $sqlOptions );
                    # --------------------------------------------------------- *
                    # Generate our menu bar, set sequence variables             *
// $mpo_paginator      = new mpc_paginate_bar();
// $t_count                      = $t_recCount[0]['seqCount'];
// $t_params['type']             = 'get';
// $t_params['per_page']         = 22;
// $t_params['curr_page']        = ($getData->get_as('int', 'page')) ? $getData->get_as('int', 'page') : 1;
// $t_params['direction']        = 'asc';
// $t_params['max_run']          = 5;
// $t_params['firstlast']        = true;
// $t_params['overlap']          = true;
// $t_params['compress']         = true;
// # overlapping == true, so per_page-1 for the next record    *
// $t_num_pages        = ceil($t_count/($t_params['per_page']-(int)$t_params['overlap']));
// $t_num_pages        = $t_num_pages ? $t_num_pages : 1;
// $t_page_max         = ($t_params['per_page']-(int)$t_params['overlap']) * ($t_params['curr_page']-1);
// $t_result           = $mpo_paginator->setposition($t_count, $t_params);
// $t_result           = $mpo_paginator->makebar();
// $t_paginate_bar     = $mpo_paginator->getbar();
                    # --------------------------------------------------------- *

                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->h1_title          = 'Blank Page';
$mpo_parts->link_title        = 'Blank Page'; # Used by breadcrumb bar
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Documentation';
$mpo_parts->section_base      = $mpo_paths->docs;
// $mpo_parts->section_base      = $mpo_parts->site_base .'/path from root';
                    # array of menu names ------------------------------------- *
                    # will stack in order listed                                *
                    # if none listed, defaults to documentation menu            *
// $mpo_parts->pagemenu          = ['menu, menu'];
                    # *** OR ***                                                *
                    # embed directly, note using string, not array              *
// $mpo_parts->pagemenu = 'import';
// ob_start();
// include('menu path or replace with code');
// $mpo_parts->page_menu         = ob_get_clean();
// ob_end_clean();
                    # Add custom style sheets that are not in the template ---- *
                    # paths object uses magick functinos to dynamically create
                    # properties - use meaningful names
// $mpo_styles                   = new mpc_paths();
// $mpo_styles->sheet01          = '';
                    # Add custom scripts that are not in the template
// $mpo_scripts                  = new mpc_paths();
// $mpo_scripts->script01        = '';
                    # Add any additional blocks ------------------------------- *
                    # Currently checks for those below                          *
// $mpo_parts->announce_widget   = '';
// $mpo_parts->announce_main     = '';
                    # Add our breadcrumbs bar - creates $mpo_parts->crumbs      *
require_once( $mpo_paths->php_widgets.'/menus/simple_crumbs.php' );
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
ob_start();
?>
<!-- *** BEGIN CONTENT ******************************************************** -->

<h2 id="toc-links">Contents</h2>

<h2>Blank</h2>

<p>This is a blank page to be used as a template for other pages</p>

<!-- *** end contents ********************************************************* -->
<?php
                    # ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ EDIT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
                    # Content developers shouldn't touch anything below here.
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
                    // Submit to template generator --------------------------- *
mpf_renderPage($mpo_parts->template.$mpt_['default'].$mpt_['suffix'], $mpo_parts);
?>
