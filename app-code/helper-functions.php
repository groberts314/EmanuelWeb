<?php
function date_sort_descending(&$array, $dateKey = 'dateTime') {
  usort($array, function($a, $b) use ($dateKey) {
    return strtotime($b[$dateKey]) - strtotime($a[$dateKey]);
  });
}

function display($template, $params = array()) {
  extract($params);
  include $template;
}

function function_get_output($fn) {
  $args = func_get_args();
  unset($args[0]);
  ob_start();
  call_user_func_array($fn, $args);
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

function get(&$var, $default = null) {
    return isset($var) ? $var : $default;
}

function is_date_in_range($startDate, $endDate, $dateToCheck) {
  $startDate_ts = strtotime($startDate);
  $endDate_ts = strtotime($endDate);
  $dateToCheck_ts = strtotime($dateToCheck);

  return (($dateToCheck_ts >= $startDate_ts) && ($dateToCheck_ts <= $endDate_ts));
}

function render($template, $params = array()) {
  return function_get_output('display', $template, $params);
}
?>
