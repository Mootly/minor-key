<?php
/**
  * Demo homepage.
  *
  * @copyright 2017 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
                    # Call config to inti the application --------------------- *
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT VARIABLES BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->page_name     = 'Hello!';
$mpo_parts->h1_title      = 'Element Test Page';
$mpo_parts->link_title    = 'Home';
$mpo_parts->page_name     = $mpo_parts->h1_title;
$mpo_parts->section_name  = 'Home';
$mpo_parts->accessibility = 'standard';
$mpo_parts->bodyclasses   = 'draft';
// $mpo_parts->pagemenu = 'docs.general';

                    # The main content body of the page is developed here.      *
                    # You can iterate across the two ob_ functions to create    *
                    # more page parts.                                          *
                    # Each part must be defined in the receiving template       *
                    # to be used.                                               *
ob_start();
                    # ↓↓↓ EDIT CONTENT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ ***
?>

<h2 id="toc-links">Contents</h2>

<h2 class="section">Headings</h2>

<h1>Stacked H1</h1>
<h2 class="toc-skip">Stacked H2</h2>
<h3>Stacked H3</h3>
<h4>Stacked H4</h4>
<h5>Stacked H5</h5>
<h6>Stacked H6</h6>

<h1>Inline H1</h1>
<p>First Paragraph. Aliqua eiusmod sunt ullamco minim consequat duis ad ipsum cupidatat est dolore do occaecat. Officia dolore anim ut sit consequat mollit est esse proident veniam velit. Labore non tempor ipsum officia commodo et aute mollit aute cillum ex sit excepteur occaecat reprehenderit nisi.</p>
<p>Subsequent paragraphs. Et elit sint officia mollit officia anim sit ipsum eiusmod elit.</p>

<h2 class="toc-skip">Inline H2</h2>
<p>Ea consequat aliqua in proident nisi fugiat ipsum sint adipisicing laboris deserunt et tempor et magna magna nostrud.</p>

<h3>Inline H3</h3>
<p>Irure velit laborum non culpa sint est ullamco elit qui incididunt id nulla ut pariatur est ea.</p>

<h4>Inline H4</h4>
<p>Nisi pariatur enim ullamco in aute dolore aliqua proident.</p>

<h5>Inline H5</h5>
<p>Aute culpa duis tempor nulla incididunt aliquip duis eu veniam qui.</p>

<h6>Inline H6</h6>
<p>Sit non veniam ex ex exercitation reprehenderit aute ullamco proident et velit.</p>

<h2 class="section">Lists</h2>

<p>Laboris reprehenderit deserunt aliquip aliqua dolore in ad dolore sint quis dolor aliquip occaecat in proident esse. Commodo ad non aliqua culpa tempor est ex.</p>
<ul>
  <li>List following a pragraph.</li>
  <li>Consectetur minim amet aliqua qui adipisicing Lorem consectetur pariatur qui eiusmod. Pariatur sunt ipsum sint voluptate cillum consequat mollit ullamco aliquip laborum nulla proident dolore.</li>
  <li>Item 3</li>
  <li>Item 4</li>
</ul>
<p>Paragraph following a list. Dolor occaecat veniam voluptate in Lorem aliquip laboris. Lorem deserunt laboris quis esse ipsum dolore in do est veniam dolore excepteur.</p>

<p>Always do the following:</p>
<ol>
  <li>Stop</li>
  <li>Look</li>
  <li>Listen</li>
  <li value="99">Listen some more</li>
  <li value="999">Keep listening</li>
</ol>

<h3>Nesting</h2>

<ul>
  <li>Item 1
    <ul>
      <li>Item 1</li>
      <li>Item 2
        <ul>
          <li>Item 1</li>
          <li>Item 2</li>
          <li>Item 3</li>
        </ul>
      </li>
      <li>Item 3</li>
    </ul>
</li>
  <li>Item 2</li>
  <li>Item 3</li>
</ul>

<h3>Definition Lists</h3>

<h4>Basic DL</h4>
<dl>
  <dt>Some term</dt>
  <dd>
    <p>With paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</p>
    <p>Laborum dolore sit non tempor qui laboris excepteur aliquip incididunt velit velit excepteur qui ad nulla elit.</p>
  </dd>
  <dt>Some other term</dt>
  <dd> No paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</dd>
</dl>

<h4>Inline DL (<code>.inline-terms</code>)</h4>

<dl class="inline-terms">
  <dt>Some term</dt>
  <dd>
    <p>With paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</p>
    <p>Laborum dolore sit non tempor qui laboris excepteur aliquip incididunt velit velit excepteur qui ad nulla elit.</p>
</dd>
  <dt>Some other term</dt>
  <dd> No paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</dd>
</dl>


<h2 class="section">Tables</h2>

<h3>Unformatted Tables</h3>

<p class="warning">All tables should use a class to style them. The following two tables should appear unformatted (with default table styling).</p>

<h4>Plain</h4>
<table>
  <tr>
    <td>Unadorned</td>
    <td>Table</td>
  </tr>
  <tr>
    <td>Not</td>
    <td>Formatted</td>
  </tr>
</table>

<h4>With THEAD and TFOOT</h4>

<table>
  <caption>A caption about this table.</cpation>
  <thead>
    <tr>
      <th>Unadorned</th>
      <th>Header</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>Unadorned</th>
      <th>Footer</th>
    </tr>
  </tfoot>
  <tbody>
    <tr>
      <td>Unadorned</td>
      <td>Table</td>
    </tr>
    <tr>
      <td>Lorem Ipsum</td>
      <td>Labore irure sint et aliquip labore ipsum deserunt elit cillum quis aute anim Lorem duis id amet.</td>
    </tr>
  </tbody>
</table>

<h3>Styled Tables</h3>

<h4>List table (<code>.list-table</code>)</h4>

<table class="list-table">
  <caption><span class="title">Label:</span> A caption about this table.</cpation>
  <thead>
    <tr>
      <th>Header</th>
      <th>Header</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <td>Footer</td>
      <td>Section</td>
    </tr>
  </tfoot>
  <tbody>
    <tr>
      <td>First</td>
      <td>Body</td>
    </tr>
    <tr>
      <td>Lorem Ipsum</td>
      <td>Labore irure sint et aliquip labore ipsum deserunt elit cillum quis aute anim Lorem duis id amet.</td>
    </tr>
  </tbody>
  <tbody>
    <tr>
      <td>Second</td>
      <td>Body</td>
    </tr>
    <tr>
      <td>Second</td>
      <td>Body</td>
    </tr>
  </tbody>
</table>

<h4>Accounting table (<code>.list-table .accounting</code>)</h4>

<table class="list-table accounting">
    <thead>
      <tr> <th>Thing</th>   <th>Received</th></tr>
    </thead>
    <tbody>
      <tr><td>Thing 1</td>  <td>$120,792,000</td></tr>
      <tr><td>Thing 2</td>	<td>28,198,100</td></tr>
      <tr><td>Thing 3</td>  <td>28,814,700</td></tr>
    </tbody>
    <tbody class="totals">
      <tr><td>Total</td>    <td>$177,804,800</td></tr>
    </tbody>
  </table>

<h2 class="section">Callouts</h2>

<h3>Alert Boxes</h3>

<p class="task">This is a task to remind me to do something.</p>
<p class="note">This is a helpful tip.</p>
<p class="note"><span class="title">Note:</span> This is a helpful tip with a label.</p>
<p class="warning">This is a warning.</p>
<p class="warning"><span class="title">Caution:</span> This is a warning with a label.</p>
<p class="alert-box">This is an alert box.</p>
<p class="wrong-box">This is a "wrong" box.</p>

<h3>Text Flagging</h3>

<p class="wrong-flag">This is a paragraph flagged as wrong.</p>
<p class="right-flag">This is a paragraph flagged as right.</p>
<ul>
  <li class="wrong-flag">This is a list item flagged as wrong.</li>
  <li class="right-flag">This is a list item flagged as right.</li>
</ul>
<p class="bad-idea">This text is a bad idea. So let's not do it.</p>

<p>Text can be called out with <span class="red">red</span> or <span class="green">green</span>.</p>

<div class="pull-box-dark">
  <p>On dark background it can also be highlighted in <span class="hilite-red">red</span>, <span class="hilite-yellow">yellow</span>, or <span class="hilite-green">green</span>.</p>
</div>

<h3>Icons</h3>

<p>The following <a href="https://fontawesome.com/" target="_blank">Font Awesome</a> icons have styling applied in the default style sheet.</p>

<p><i class="fa fa-ban"></i> - <code>fa-ban</code></p>
<p><i class="fa fa-check"></i> - <code>fa-check</code></p>
<p><i class="fa fa-question"></i> - <code>fa-question</code></p>
<p><i class="fa fa-times"></i> - <code>fa-times</code></p>

<h4 class="aud-general">General Audience Stuff</h4>

<p>A little icon to put after the heading of a section to let people know it is general audience friendly.</p>

<h4 class="aud-technical">Technical Audience Stuff</h4>

<p>A little icon to put after the heading of a section to let people know there are technical details for technical audiences ahead. It is also applied to the main title of the page if they body has a class of <code>.tech-notes</code>.</p>

<h3>Boxes</h3>

<div class="pull-box-dark">
  <h4>Dark Box</h4>
  <p>A box with a dark background.</p>
</div>

<div class="pull-box">
  <h4>Light Box</h4>
  <p>A box with a light background.</p>
</div>

<div class="pull-box-alt">
  <h4>Alt Box</h4>
  <p>Alternate color for light boxes.</p>
</div>

<div class="pull-box-example">
  <h4>Example Box</h4>
  <p>An example box.</p>
</div>

<h2 class="section">Links</h2>

<p>This is a <span class="fake-link">fake link</span>.</p>
<p>This is a <a href="ocfs">real link</a>.</p>
<p>Look in the right margin to see top-links.</p>

<h3>Link Icons</h3>

<p>You may want to further refine the external link, in case you are using full pathing in all URLS. See CSS for commented example.</p>
<p><a href="https://external.org">External Link</a> (begins with "http")</p>
<p><a href="ocfs/document.xls">Excel document</a> (.xls, .xlsx)</p>
<p><a href="ocfs/document.wmv">Media files</a> (.wmv, .wvx, .mov, .mpg, .mpeg, .flv, .avi, .mp4, .asx, .rm)</p>
<p><a href="ocfs/document.pdf">PDF document</a> (.pdf)</p>
<p><a href="ocfs/document.ppt">PowerPoint presentation</a> (.pps, .ppt, .pptx)</p>
<p><a href="ocfs/word.doc">Word document</a> (.rtf, .doc, .docx, .dot, .dotx)</p>
<p><a href="www.youtube.com/watch">YouTube</a></p>

<h2 class="section">Code</h2>

<pre>
<span class="cc-html">&lt;p></span>Some HTML.<span class="cc-html">&lt;p></span>
JS w/ VAR tags  : <span class="cc-js">x = (<var>yourVar</var> !== null) ? <var>yourVar</var> : 'oops!'</span>
PHP w/ VAR tags : <span class="cc-php">$x = ($<var>yourVar</var> !== null) ? $<var>yourVar</var> : 'oops!'</span>
A <b>bold</b> and <em>emphatic</em> thing.
</pre>

<p>The most common use of the <code class="cc-php">ob_</code> (output buffer) control functions is to defer buffer output until a specific time. In this case, this allows the write proces to be delayed until the content is passed to the template, allowing the page to be fully generated before writing anything to output.</p>

<p>Be <b>bold</b> and <em>emphatic</em>. Don't just stand there, <cite>cite</cite> something!</p>

<p>This means we can create static content for an HTML page in a file then invoke the template to wrap that content. The content file is an easy to read PHP file that only requires the content creator to assign values to a few variables and fill in the content between the proverbial lines.</p>
<?php
                    # ↑↑↑ EDIT CONTENT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ ***
$mpo_parts->accessibility = 'standard';
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpt_full_template, array('page'=>$page_elements['content'])));
?>
