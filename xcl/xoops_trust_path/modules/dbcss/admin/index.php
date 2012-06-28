<?php

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
echo '<h3>'.$xoopsModule->getVar('name').'</h3>' ;
echo '
<hr />
<br />
<div class="tips">
<p>The module Theme Editor features a simple way to edit your theme css, insert a script into a specific module, define header meta tag keywords and description to each module. To apply your changes and, or override default settings, you only need to install Theme Editor blocks with your target module.</p>
</div>


<div class="return_top"><a href="#container">TOP</a></div>
<hr />
<br />

<h4 class="admintitle">Text Sanitizer</h4>
<div class="tips">
<p>The first step is to import your Theme stylesheet (css files) to Theme Editor</p>
<p>Go to "Manage CSS" and import your stylesheet files.</p>
<p>The original file is saved to database and a default template is created and editable.</p>
<p>A Default template can be easily copied to a new set of templates to be used with a specific module.</p>
<p>To apply your new stylesheet files, instal the block then click edit to manage block settings and select the modules to apply the new CSS.</p>
<p>Attention ! Go to "User Module" and give group "anonymous" permission to "access" Theme Editor. So your visitors can see the changes you made to stylesheet.</p>
</div>


<div class="return_top"><a href="#container">TOP</a></div>
<hr />
<br />

<h4 class="admintitle">Manage Script</h4>
<div class="tips">
<p>You can easily add new scripts to your theme header</p>
<p>Alike CSS, the block should be installed and modules selected from block settings.</p>
</div>


<div class="return_top"><a href="#container">TOP</a></div>
<hr />
<br />

<h4 class="admintitle">Manage Meta Tag</h4>
<div class="tips">
<p>Define description and keywords for each module installed in your CMS.</p>
<p>The items set here are only applied to modules selected in "META Tag hook block"<br />
Make a directory CMS_TRUST_PATH/cache and change permissions to writable.</p>
</div>


<div class="return_top"><a href="#container">TOP</a></div>
<hr />
<br />

<h4 class="admintitle">Meta Scripts</h4>
<div class="tips">
<p>An external script can be inserted to the header of theme.html
To avoid security issues here, only the scripts that exist in CMS URL or less are allowed.
The item set here is only applied to modules selected in "SCRIPT tag hook block".</p>
</div>


<div class="return_top"><a href="#container">TOP</a></div>
<hr />
<br />

<h4 class="admintitle">Theme Admin</h4>
<div class="tips">
<p>Choose the look of your site by clicking the "select" button next to your favourite theme.
Let your users choose their own favourite look and feel for your site. Check the boxes to add a theme to the theme selection block. For more details, read the help.</p>
</div>

<div class="return_top"><a href="#container">TOP</a></div>
<hr />
<br />

<h4 class="admintitle">Languages</h4>
<div class="tips">
<p>You can easily edit and custom your language catalog</p>
<p>To edit and personalize your language variables<br />
<a href="index.php?mode=admin&lib=altsys&page=mylangadmin">Click  here</a>!</p>
</div>


<div class="return_top"><a href="#container">TOP</a></div>
<hr />
<br />

<h4 class="admintitle">Templates</h4>
<div class="tips">
<p>You can easily duplicate and custom your Templates</p>
<br />
<p>To start editing your module templates<br />
<a href="index.php?mode=admin&lib=altsys&page=mytplsadmin">Click  here</a>!</p>
</div>


<div class="return_top"><a href="#container">TOP</a></div>
<hr />
<br />

<h4 class="admintitle">Blocks/Permissions</h4>
<div class="tips">
<p>Install the Theme Editor blocks to override selected modules with your stylesheet, scripts and meta tags.</p>
<p>To install blocks and set permissions<br />
<a href="index.php?mode=admin&lib=altsys&page=myblocksadmin">Click  here</a>!</p>
</div>';

xoops_cp_footer();

?>