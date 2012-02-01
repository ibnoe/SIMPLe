<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Profiler Sections
| -------------------------------------------------------------------------
| This file lets you determine whether or not various sections of Profiler
| data are displayed when the Profiler is enabled.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/profiling.html
|
*/

$config['benchmarks'] = FALSE;
$config['config'] = FALSE;
$config['controller_info'] = TRUE;
$config['get'] = TRUE;
$config['http_headers'] = FALSE;
$config['memory_usage'] = FALSE;
$config['post'] = TRUE;
$config['queries'] = TRUE;
$config['uri_string'] = TRUE;
$config['query_toggle_count'] = 25;

/* End of file profiler.php */
/* Location: ./application/config/profiler.php */