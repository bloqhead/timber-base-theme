<?php

  require_once('../../../../../wp-load.php');

  function showTemplate($template, $fullWidth = false, $incomingContext = null)
  {
    // Full Width disabled by Default
    if ($fullWidth) {
      setPageFullWidth();
    }

    $context = Timber::get_context();
    if (is_array($incomingContext)) {
      $context = array_merge($context, $incomingContext);
    }
    Timber::render( $template, $context );
  }