<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

/**
 * @global CMain $APPLICATION
 */

?>
<div class="intec-content">
    <div class="intec-content-wrapper">
        <h1 id="pagetitle pagetitle_main_header"><?php $APPLICATION->ShowTitle(false) ?></h1>
        <h2 id="pagetitle_add_header"></h2>
    </div>
</div>

<style>
    .intec-content-wrapper {
        position: relative;
    }

    #pagetitle_add_header::before {
        content: url('/local/templates/universe_s1/images/graph_element.png');
        position: absolute;
        transform: translateY(-18%);
        margin-left: -30px;
    }

    #pagetitle_add_header {
        padding-left: 30px;
        font-size: 1.5em;

    }

    @media all and (max-width: 430px) {
        #pagetitle_add_header {
            padding-left: 30px;
            font-size: 1.3em;
            margin-bottom: 0px;
        }
    }
</style>