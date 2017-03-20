<?php
/*
Plugin Name: WP-GMDC
Plugin URI: https://celox.io
Description: Get access to 15 Google Material Design components.
Version: 0.0.4
Author: Martin Pfeffer
Author URI: https://celox.io
License: Apache 2.0

Copyright (c) 2017 Martin Pfeffer

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

*/

// add loader
require_once plugin_dir_path(__FILE__) . 'includes/wp-gmdc-loader.php';

// hook links files in front-end
add_action('wp_enqueue_scripts', 'clx_gmdc_load_res');


// TODO 2017-03-15 18-57:  Write tut
// --no-cache --style compressed --update  set in phpStorm file watcher in SCSS as arguments in
// front
// TODO 2017-03-15 19-01: Write tut
// set up jsminification

/**
 * Constructs a GMD colored raised Button.
 *
 * Example:
 * [wp_gmdc_button text="OK" text-size="36px" color="#00796B" width="64px" height="24px"]
 *
 * @param string $attrs The configuration of the wp_gmdc_.
 *
 * @return string A wp_gmdc_.
 */
add_shortcode('wp_gmdc_button', function ($attrs) {
    $attrs = shortcode_atts(array('text' => 'OK', 'color' => '#424242', 'width' => '#424242', 'height' => '#424242', 'ripple' => true), $attrs);

    // @formatter:off
    return '<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored '
           . ($attrs["ripple"] == 'true' ? 'mdl-js-ripple-effect ' : ' ') . ' ">
  			' . $attrs["text"] . '
			</button>';
    // @formatter:on
});


/**
 * Constructs a GMD colored raised Button.
 *
 * Example:
 * [wp_gmdc_button_flat text="OK" text-size="36px" color="#00796B" width="64px" height="24px"]
 *
 * @param string $attrs The configuration of the wp_gmdc_.
 *
 * @return string A wp_gmdc_.
 */
add_shortcode('wp_gmdc_button_flat', function ($attrs) {
    $attrs = shortcode_atts(array('text' => 'OK', 'text-size' => '18px', 'color' => '#424242', 'width' => '#424242', 'height' => '#424242', 'ripple' => true), $attrs);

    // @formatter:off
    return '<button class="mdl-button mdl-js-button '
           . ($attrs["ripple"] == 'true' ? 'mdl-js-ripple-effect' : '') . '">
  			' . $attrs["text"] . '
			</button>';
    // @formatter:on
});

/**
 * Constructs a GMD colored FAB.
 *
 * Example:
 * [wp_gmdc_fab symbol="+" symbol-size="36px" color="#00796B" radius="64px"]
 *
 * @param string $attrs The configuration of the wp_gmdc_.
 *
 * @return string A wp_gmdc_.
 */
add_shortcode('wp_gmdc_fab', function ($attrs) {
    $attrs = shortcode_atts(array('symbol' => '+', 'text-size' => '18px', 'color' => '#424242', 'colored' => true, 'ripple' => true), $attrs);

    // @formatter:off
    return '<button class="mdl-button mdl-js-button mdl-button--fab '
           . ($attrs["ripple"] == 'true' ? 'mdl-js-ripple-effect' : '') . ' '
           . ($attrs["colored"] == 'true' ? 'mdl-button--colored' : '') . '">
  			' . $attrs["symbol"] . '
			</button>';
    // @formatter:on
});

/**
 * Constructs a GMD Dialog.
 *
 * Example:
 * [wp_gmdc_dialog title="The Title" content="CONT"
 * button-text="Show" button-positive="Agree" button-negative="" button-neutral="Cancel"]
 *
 * @param string $attrs The configuration of the wp_gmdc_.
 *
 * @return string A wp_gmdc_.
 */
add_shortcode('wp_gmdc_dialog', function ($attrs) {
    $attrs = shortcode_atts(array('title' => 'Info', 'content' => 'This is a GDM Dialog', 'width' => '240px', 'height' => '120px', 'button-text' => 'Show', 'button-positive' => '', 'button-negative' => '', 'button-neutral' => '', 'dismissable' => true, 'modal' => true), $attrs);

    // @formatter:off
    return '<button id="show-dialog" type="button" class="mdl-button">'
           . $attrs["button-text"] .
           '</button>
  <dialog class="mdl-dialog">
    <h4 class="mdl-dialog__title">'  . $attrs["title"] . '</h4>
    <div class="mdl-dialog__content">
      <p>
        '  . $attrs["content"] . '
      </p>
    </div>
    <div class="mdl-dialog__actions">
      ' . ($attrs["button-positive"] != '' ? '<button type="button" class="mdl-button">Agree</button>' : '') . '
      ' . ($attrs["button-negative"] != '' ? '<button type="button" class="mdl-button close">Disagree</button>' : '') . '
      ' . ($attrs["button-neutral"] != '' ? '<button type="button" class="mdl-button close">Cancel</button>' : '') . '
    </div>
  </dialog>
  <script>
    var dialog = document.querySelector("dialog");
    var showDialogButton = document.querySelector("#show-dialog");
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    showDialogButton.addEventListener("click", function() {
      dialog.showModal();
    });
    dialog.querySelector(".close").addEventListener("click", function() {
      dialog.close();
    });
  </script>';
    // @formatter:on
});


/**
 * Constructs a Tool-Tip.
 *
 * Example:
 * [wp_gmdc_tooltip id="tt1" large="true" icon="print" tip_text="Print!"]
 *
 * @param string $attrs The configuration of the wp_gmdc_tooltip.
 *
 * @return string .
 */
add_shortcode('wp_gmdc_tooltip', function ($attrs) {
    $uid = 'x' . uniqid();
    $attrs = shortcode_atts(array('id' => $uid, 'large' => '', 'icon' => 'add', 'tip_text' => 'tip_text'), $attrs);

    // @formatter:off
    return '<div id="' . $attrs["id"] . '" class="icon material-icons">' . $attrs["icon"] . '</div>
			<div class="mdl-tooltip ' . ($attrs["large"] === 'true' ? 'mdl-tooltip--large' : '')
           . '"' . ' data-mdl-for="' . $attrs["id"] . '">' . $attrs["tip_text"] . '</div>';
    // @formatter:on
});


/**
 * Constructs a Slider.
 *
 * Example:
 * [wp_gmdc_slider id="s1" width="300px" min="1" max="100" value="40" step="1" type="range"]
 *
 * @param string $attrs The configuration of the wp_gmdc_tooltip.
 *
 * @return string .
 */
add_shortcode('wp_gmdc_slider', function ($attrs) {
    $uid = 'x' . uniqid();
    $attrs = shortcode_atts(array('id' => $uid, 'width' => '300px', 'min' => '1', 'max' => '100', 'value' => '40', 'step' => '1', 'type' => 'range'), $attrs);

    // @formatter:off
    return '<p style="width:' . $attrs["width"] . '">
			<input class="mdl-slider mdl-js-slider "
			type="' . $attrs["type"] . '"
			id="' . $attrs["id"] . '"
			min="' . $attrs["min"] . '"
			max="' . $attrs["max"] . '"
			value="' . $attrs["value"] . '"
			step="' . $attrs["step"] . '">
			</p>';
    // @formatter:on
});


/**
 * Constructs a Card.
 *
 * Example:
 * [wp_gmdc_card width="512px" height="176px" img_url="" title="Title" content="foo bar()"
 * button_text="OK" menu_button_icon="share"]
 *
 * @param string $attrs The configuration of the wp_gmdc_tooltip.
 *
 * @return string .
 */
add_shortcode('wp_gmdc_card', function ($attrs) {
    $uid = 'x' . uniqid();
    $attrs = shortcode_atts(array('width' => '512px', 'height' => '176px', 'img_url' => 'https://maxcdn.icons8.com/Share/icon/Logos//google_logo1600.png', 'title' => 'Title', 'title_color' => '#212121', 'content' => 'Content', 'content_color' => '#212121', 'button_text' => '', 'menu_button_icon' => ''), $attrs);

    // @formatter:off
    return '<style>
.demo-card-wide.mdl-card {
  width: ' . $attrs["width"] . ';
}
.demo-card-wide > .mdl-card__title {
  color: ' . $attrs["title_color"] . ';
  height: ' . $attrs["height"] . ';
  background: url("' . $attrs["img_url"] . '") center / cover;
}
.mdl-card__supporting-text {
  color: ' . $attrs["content_color"] . ';
}
.demo-card-wide > .mdl-card__menu {
  color: #fff;
}
</style>

<div class="demo-card-wide mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">' . $attrs["title"] . '</h2>
  </div>
  <div class="mdl-card__supporting-text">
    ' . $attrs["content"] . '
  </div>
  <div class="mdl-card__actions mdl-card--border">
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
      ' . $attrs["button_text"] . '
    </a>
  </div>
  <div class="mdl-card__menu">
    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
      <i class="material-icons">' . $attrs["menu_button_icon"] . '</i>
    </button>
  </div>
</div>';
    // @formatter:on
});


/**
 * Constructs a SnackBar.
 *
 * Example:
 * [wp_gmdc_snackbar button_text="Hmm" snack_text="Title?" snack_button_text="kkk" snackbar_color="#CDCDCD" timeout="5000"]
 *
 * @param string $attrs The configuration of the wp_gmdc_tooltip.
 *
 * @return string .
 */
add_shortcode('wp_gmdc_snackbar', function ($attrs) {
    $uid = 'x' . uniqid();
    $uid2 = 'x' . uniqid();
    $attrs = shortcode_atts(array('id' => $uid, 's_id' => $uid2, 'button_text' => 'OK', 'snack_text' => 'Some Text', 'snack_button_text' => 'Action', 'snackbar_color' => '#212121', 'timeout' => '2000'), $attrs);

    // @formatter:off
    return '<button id="' . $attrs["id"] . '" class="mdl-button mdl-js-button mdl-button--raised" type="button">' . $attrs["button_text"] . '</button>
<div id="' . $attrs["s_id"] . '" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script>
(function() {
  "use strict";
  var snackbarContainer = document.querySelector("#' . $attrs["s_id"] . '");
  var showSnackbarButton = document.querySelector("#' . $attrs["id"] . '");
  var handler = function(event) {
    showSnackbarButton.style.backgroundColor = "' . $attrs["snackbar_color"] . '";
  };
  showSnackbarButton.addEventListener("click", function() {
    "use strict";
    showSnackbarButton.style.backgroundColor = "#" +
        Math.floor(Math.random() * 0xFFFFFF).toString(16);
    var data = {
      message: "' . $attrs["snack_text"] . '.",
      timeout: ' . $attrs["timeout"] . ',
      actionHandler: handler,
      actionText: "' . $attrs["snack_button_text"] . '"
    };
    snackbarContainer.MaterialSnackbar.showSnackbar(data);
  });
}());
</script>';
    // @formatter:on
});


/**
 * Constructs a Toast.
 *
 * Example:
 * [wp_gmdc_toast button_text="Hmm" toast_text="Title?" toast_color="#CDCDCD" timeout="5000"]
 *
 * @param string $attrs The configuration of the wp_gmdc_tooltip.
 *
 * @return string .
 */
add_shortcode('wp_gmdc_toast', function ($attrs) {
    $uid = 'x' . uniqid();
    $uid2 = 'x' . uniqid();
    $attrs = shortcode_atts(array('id' => $uid, 's_id' => $uid2, 'button_text' => 'OK', 'toast_text' => 'Some Text', 'snack_button_text' => 'Action', 'toast_color' => '#212121', 'timeout' => '2000'), $attrs);

    // @formatter:off
    return '<button id="' . $attrs["id"] . '" class="mdl-button mdl-js-button mdl-button--raised" type="button">' . $attrs["button_text"] . '</button>
<div id="' . $attrs["s_id"] . '" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script>
(function() {
  "use strict";
  window["counter"] = 0;
  var snackbarContainer = document.querySelector("#' . $attrs["s_id"] . '");
  var showToastButton = document.querySelector("#' . $attrs["id"] . '");
  showToastButton.addEventListener("click", function() {
    "use strict";
    var data = {message: "' . $attrs["toast_text"] . ' # " + ++counter};
    snackbarContainer.MaterialSnackbar.showSnackbar(data);
  });
}());
</script>';
    // @formatter:on
});


/**
 * Constructs a default ProgressBar.
 *
 * Example:
 * [wp_gmdc_progressbar id="x101" progress="30"]
 * or
 * [wp_gmdc_progressbar id="x102" progress="14" buffer="60"]
 *
 * @param string $attrs The configuration of the wp_gmdc_tooltip.
 *
 * @return string .
 */
add_shortcode('wp_gmdc_progressbar', function ($attrs) {
    $uid = 'x' . uniqid();
    $attrs = shortcode_atts(array('id' => $uid, 'progress' => '0', 'buffer' => ""), $attrs);
    if ($attrs["buffer"] === '') {
        return '<div id="' . $attrs["id"] . '" class="mdl-progress mdl-js-progress"></div>
<script>
  document.querySelector("#' . $attrs["id"] . '").addEventListener("mdl-componentupgraded", function() {
    this.MaterialProgress.setProgress(' . $attrs["progress"] . ');
  });
</script>';
    } else {
        return '<div id="' . $attrs["id"] . '" class="mdl-progress mdl-js-progress"></div>
<script>
  document.querySelector("#' . $attrs["id"] . '").addEventListener("mdl-componentupgraded", function() {
    this.MaterialProgress.setProgress(' . $attrs["progress"] . ');
    this.MaterialProgress.setBuffer(' . $attrs["buffer"] . ');
  });
</script>';
    }
});


/**
 * Constructs a indeterminate ProgressBar.
 *
 * Example:
 * [wp_gmdc_progressbar_indeterminate]
 *
 * @param string $attrs The configuration of the wp_gmdc_tooltip.
 *
 * @return string .
 */
add_shortcode('wp_gmdc_progressbar_indeterminate', function ($attrs) {
    $uid = 'x' . uniqid();
    $attrs = shortcode_atts(array('id' => $uid), $attrs);
    return '<div id="' . $attrs["id"] . '" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>';
    // @formatter:on
});

/**
 * Constructs a Spinner.
 *
 * Example:
 * [wp_gmdc_spinner]
 * or
 * [wp_gmdc_spinner change_color="true"]
 *
 * @param string $attrs The configuration of the wp_gmdc_tooltip.
 *
 * @return string .
 */
add_shortcode('wp_gmdc_spinner', function ($attrs) {
    $uid = 'x' . uniqid();
    $attrs = shortcode_atts(array('id' => $uid, 'change_color' => 'false'), $attrs);
    // @formatter:on
    if ($attrs['change_color'] === 'false') {
        return '<!-- MDL Spinner Component with Single Color -->
    <div id="' . $attrs["id"] . '" class="mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active"></div>';
    } else {
        return '<div id="' . $attrs["id"] . '" class="mdl-spinner mdl-js-spinner is-active"></div>';
    }
    // @formatter:on
});

/**
 * Constructs a Menu.
 *
 * Example:
 * [wp_gmdc_list id="list"]
 * or
 * [wp_gmdc_menu id="menu2" h_pos="right" v_pos="top"]
 *
 * @param string $attrs The configuration of the wp_gmdc_tooltip.
 *
 * @return string .
 */
add_shortcode('wp_gmdc_list', function ($attrs) {
    $args = pass_array_parse_atts($attrs, array('arg' => array()));
    $res = '<style>
.list-item {  width: 300px; }
</style>
<ul class="list-item mdl-list">';
    foreach ($args['arg'] as $key => $value) {
        $res .= '<li class="mdl-list__item">
    <span class="mdl-list__item-primary-content">
    ' . $key . ' # ' . $value . '
    </span>
  </li>';
    }
    return $res . '</ul>';
    // @formatter:on
});

function pass_array_parse_atts($atts, $expected) {
    $args = array();
    foreach ($atts as $index => $att) {
        if (preg_match('#^(.+)\((.+)\)=["\']?(.+)$#', $att, $match)) {
            // We have an array attribute where $att is something like: foo(1)="bar"
            $args[$match[1]][$match[2]] = rtrim(rtrim($match[3], '"'), "'");
        } else {
            // We have a simple attribute where $att is something like: foo="bar"
            list($key, $value) = explode('=', $att);
            $args[$key] = $value;
        }
    }
    return wp_parse_args($args, $expected);
}


/**
 * Constructs a Header with Tabs.
 *
 * Example:
 * [wp_gmdc_header_tabs]
 *
 * @param string $attrs The configuration of the wp_gmdc_tooltip.
 *
 * @return string .
 */
add_shortcode('wp_gmdc_header_tabs', function ($attrs) {
    $uid = 'x' . uniqid();
    $attrs = shortcode_atts(array('id' => $uid, 'items' => ''), $attrs);
    // @formatter:on
    return '<!-- Simple header with fixed tabs. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header
            mdl-layout--fixed-tabs">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title">Title</span>
    </div>
    <!-- Tabs -->
    <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
      <a href="#fixed-tab-1" class="mdl-layout__tab is-active">Tab 1</a>
      <a href="#fixed-tab-2" class="mdl-layout__tab">Tab 2</a>
      <a href="#fixed-tab-3" class="mdl-layout__tab">Tab 3</a>
    </div>
  </header>
  <div class="mdl-layout__drawer">
    <span class="mdl-layout-title">Title</span>
  </div>
  <main class="mdl-layout__content">
    <section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
      <div class="page-content"><!-- Your content goes here --></div>
    </section>
    <section class="mdl-layout__tab-panel" id="fixed-tab-2">
      <div class="page-content"><!-- Your content goes here --></div>
    </section>
    <section class="mdl-layout__tab-panel" id="fixed-tab-3">
      <div class="page-content"><!-- Your content goes here --></div>
    </section>
  </main>
</div>';
    // @formatter:on
});