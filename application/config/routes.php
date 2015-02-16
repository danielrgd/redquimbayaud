<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "interfaz/interfaz_c";
$route['404_override'] = '';

$route['sesion'] = 'sesion/sesion_c';
$route['interfaz/buscar_perfiles_por_palabras_clave'] = 'interfaz/interfaz_c/buscar_perfiles_por_palabras_clave';
$route['interfaz'] = 'interfaz/interfaz_c';
$route['interfaz/crear_cuenta'] = 'interfaz/interfaz_c/crear_cuenta';
$route['interfaz/formulario_registro'] = 'interfaz/interfaz_c/formulario_registro';
$route['interfaz/visualizar_usuario/(:any)'] = 'interfaz/interfaz_c/visualizar_usuario/$1';
$route['interfaz/visualizar_tema_interes/(:any)'] = 'interfaz/interfaz_c/visualizar_tema_interes/$1';
$route['interfaz/modificar_perfil'] = 'interfaz/interfaz_c/modificar_perfil';
$route['interfaz/visualizar_opciones_cuenta/(:any)'] = 'interfaz/interfaz_c/visualizar_opciones_cuenta/$1';
$route['interfaz/visualizar_formulario_perfil/(:any)'] = 'interfaz/interfaz_c/visualizar_formulario_perfil/$1';
$route['interfaz/activar_cuenta/(:any)/(:any)'] = 'interfaz/interfaz_c/activar_cuenta/$1/$2';

//proyecto
$route['interfaz/formulario_proyecto'] = 'interfaz/interfaz_c/formulario_proyecto';
$route['interfaz/visualizar_proyecto/(:any)'] = 'interfaz/interfaz_c/visualizar_proyecto/$1';
$route['interfaz/visualizar_mis_proyectos'] = 'interfaz/interfaz_c/visualizar_mis_proyectos';
$route['interfaz/visualizar_formulario_seguimiento/(:any)'] = 'interfaz/interfaz_c/visualizar_formulario_seguimiento/$1';
$route['interfaz/visualizar_formulario_contabilidad/(:any)'] = 'interfaz/interfaz_c/visualizar_formulario_contabilidad/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */