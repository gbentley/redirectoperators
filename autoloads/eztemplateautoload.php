<?php

// Operator autoloading

$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] =
  array( 'script' => 'extension/redirectoperators/autoloads/redirectoperators.php',
         'class' => 'RedirectOperators',
         'operator_names' => array( 'redirectabsolute', 'redirectrelative' ) );

?>