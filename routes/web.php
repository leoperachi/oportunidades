<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect("/login");
});

// Route::get('/', function () {
//     return redirect("/login/operadora");
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/operadora', 'OperadoraController@index')->name('operadora');
Route::match(['get', 'post'],'/operadora/listar', 'OperadoraController@listar')->name('operadora.listar');
Route::match(['get', 'post'],'/vaga/listar', 'VagaController@listar')->name('vaga.listar');
Route::get('/vaga/cadastrar', 'VagaController@cadastrar')->name('vaga.cadastro');
Route::post('/vaga/cadastrar', 'VagaController@store')->name('vaga.cadastro');
Route::post('/operadora', 'OperadoraController@store')->name('operadora');
Route::post('/operadora/alterar/{id}', 'OperadoraController@storeAlterar')->name('operadora.alterar');
Route::get('/operadora/alterar/{id}', 'OperadoraController@alterar')->name('operadora.alterar');
Route::get('/cidade/buscar', 'CidadeController@buscar')->name('cidade.buscar');
Route::get('/cidade/criar', 'CidadeController@criar')->name('cidade.criar');
Route::get('/estado/buscar', 'EstadoController@buscar')->name('estado.buscar');
Route::get('/bairro/criar', 'BairroController@criar')->name('bairro.criar');
Route::get('/bairro/buscar', 'BairroController@buscar')->name('bairro.buscar');

Route::get('/sala/buscar/{id?}', 'SalaController@buscarPorUnidade')->name('sala.buscar.buscar-por-unidade');
Route::get('/tabela/buscar/{id?}', 'OperadoraController@buscarTabelaPorUnidade')->name('tabela.buscar.buscar-por-unidade');

Route::get('/bairro/buscar/{id?}', 'BairroController@buscarPorCidade')->name('bairro.buscar.buscar-por-cidade');
Route::get('/estado/buscar-por-pais/{id?}', 'EstadoController@buscarPorPais')->name('estado.buscar.buscar-por-pais');
Route::get('/cidade/buscar-por-estado/{id?}', 'CidadeController@buscarPorEstado')->name('cidade.buscar.buscar-por-estado');


Route::get('/operador', 'OperadorController@index')->name('operador');
Route::match(['get', 'post'],'/operador/listar', 'OperadorController@listar')->name('operador.listar');
// Route::match(['get', 'post'],'/vaga/listar', 'VagaController@listar')->name('vaga.listar');
Route::post('/operador', 'OperadorController@store')->name('operador');
Route::post('/operador/alterar/{id}', 'OperadorController@storeAlterar')->name('operador.alterar');
Route::get('/operador/alterar/{id}', 'OperadorController@alterar')->name('operador.alterar');
Route::get('/vaga/acompanhamento/{idvaga}', 'VagaController@acompanhamento')->name('vaga.acompanhamento');


//foto
Route::post('/upload', 'OperadorController@upload')->name('upload');



Route::post('/unidade', 'UnidadeController@store')->name('unidade');
Route::get('/unidade', 'UnidadeController@index')->name('unidade');
Route::match(['get', 'post'],'/unidade/listar', 'UnidadeController@listar')->name('unidade.listar');
Route::post('/unidade/alterar/{id}', 'UnidadeController@storeAlterar')->name('unidade.alterar');
Route::get('/unidade/alterar/{id}', 'UnidadeController@alterar')->name('unidade.alterar');

Route::post('/imagem/adicionar', 'UnidadeController@adicionarImagem')->name('imagem.adicionar');

Route::get('/tabela-valor', 'TabelaValorController@index')->name('tabela-valor');
Route::match(['get', 'post'],'/tabela/listar', 'TabelaValorController@listar')->name('tabela-valor.listar');
Route::post('/tabela-valor', 'TabelaValorController@store')->name('tabela-valor');
Route::post('/tabela-valor/alterar/{id}', 'TabelaValorController@storeAlterar')->name('tabela-valor.alterar');
Route::get('/tabela-valor/alterar/{id}', 'TabelaValorController@alterar')->name('tabela-valor.alterar');


Route::group(['prefix' => '/banco'], function(){
    Route::get('/', 'BancoController@index')->name('banco');
    Route::match(['get', 'post'], '/listar', 'BancoController@listar')->name('banco.listar');    
    Route::post('/cadastrar', 'BancoController@cadastrar')->name('banco.cadastrar');
    Route::get('/editar/{id}', 'BancoController@editar')->name('banco.editar');
    Route::put('/atualizar/{id}', 'BancoController@atualizar')->name('banco.atualizar');
});

Route::group(['prefix' => '/convenio'], function(){
    Route::get('/', 'ConvenioController@index')->name('convenio');
    Route::match(['get', 'post'], '/listar', 'ConvenioController@listar')->name('convenio.listar');
    Route::post('/cadastrar', 'ConvenioController@cadastrar')->name('convenio.cadastrar');
    Route::get('/editar/{id}', 'ConvenioController@editar')->name('convenio.editar');
    Route::put('/atualizar/{id}', 'ConvenioController@atualizar')->name('convenio.atualizar');
});

Route::group(['prefix' => '/especialidade'], function(){
    Route::get('/', 'EspecialidadeController@index')->name('especialidade');
    Route::match(['get', 'post'], '/listar', 'EspecialidadeController@listar')->name('especialidade.listar');
    Route::post('/cadastrar', 'EspecialidadeController@cadastrar')->name('especialidade.cadastrar');
    Route::get('/editar/{id}', 'EspecialidadeController@editar')->name('especialidade.editar');
    Route::put('/atualizar/{id}', 'EspecialidadeController@atualizar')->name('especialidade.atualizar');
});

Route::group(['prefix' => '/instituicao'], function(){
    Route::get('/', 'InstituicaoController@index')->name('instituicao');
    Route::get('/cidade/{id}', 'InstituicaoController@getCidade');
    Route::match(['get', 'post'], '/listar', 'InstituicaoController@listar')->name('instituicao.listar');
    Route::post('/cadastrar', 'InstituicaoController@cadastrar')->name('instituicao.cadastrar');
    Route::get('/editar/{id}', 'InstituicaoController@editar')->name('instituicao.editar');
    Route::put('/atualizar/{id}', 'InstituicaoController@atualizar')->name('instituicao.atualizar');
});


Route::group(['prefix' => '/feriado'], function(){
    Route::get('/', 'FeriadoController@index')->name('feriado');
    Route::match(['get', 'post'], '/listar', 'FeriadoController@listar')->name('feriado.listar');
    Route::post('/cadastrar', 'FeriadoController@cadastrar')->name('feriado.cadastrar');
    Route::get('/editar/{id}', 'FeriadoController@editar')->name('feriado.editar');
    Route::put('/atualizar/{id}', 'FeriadoController@atualizar')->name('feriado.atualizar');
});

Route::group(['prefix' => '/aviso'], function(){
    Route::get('/', 'AvisoController@index')->name('aviso');
    Route::match(['get', 'post'], '/listar', 'AvisoController@listar')->name('aviso.listar');
    Route::get('/operadoras/unidades/{id}', 'AvisoController@getUnidades');
    Route::get('/operadoras/{id}/grupo_medico', 'AvisoController@getGrupoMedico');
    
    Route::get('/modulos', 
        'AvisoController@getModulos')
            ->name('aviso.modulos');

    Route::get('/operadoras/buscar', 
        'AvisoController@getOperadoras')
            ->name('aviso.operadoras');

    Route::get('/operadoras/unidades', 
        'AvisoController@getTodasUnidadesAjax')
            ->name('aviso.unidades');
    Route::get('/operadoras/grupos', 
        'AvisoController@getTodosGruposMedicosAjax')
            ->name('aviso.grupos');
    
    Route::post('/cadastrar', 
        'AvisoController@cadastrar')
            ->name('aviso.cadastrar');

    Route::get('/editar/{id}', 
        'AvisoController@editar')
            ->name('aviso.editar');

    Route::get('/editar/operadoras/unidades/{id}', 
        'AvisoController@getUnidades');

    Route::get('/editar/operadoras/{id}/grupo_medico', 
        'AvisoController@getGrupoMedico');

    Route::put('/atualizar/{id}', 
        'AvisoController@atualizar')
            ->name('aviso.atualizar');
});

Route::group(['prefix' => '/prospect'], function(){
    Route::get('/', 'ProspectController@index')
        ->name('prospect');

    Route::match(['get', 'post'], '/listar', 
        'ProspectController@listar')
            ->name('prospect.listar');

    Route::get('/status_prospect', 
        'ProspectController@buscarStatusAjax')
            ->name('buscarStatusAjax');

    Route::get('/{id}', 'ProspectController@cadastroCriado');

    Route::post('/cadastrar', 
        'ProspectController@cadastrar')
            ->name('prospect.cadastrar');

    Route::get('/editar/{id}', 
        'ProspectController@editar')
            ->name('prospect.editar');

    Route::put('/atualizar/{id}', 
        'ProspectController@atualizar')
            ->name('prospect.atualizar');
});

Route::get('/comunicacao/cadastro', 
    'ComunicacaoController@cadastro')
        ->name('comunicacao.cadastro');

Route::post('/comunicacao/cadastrar', 
    'ComunicacaoController@cadastrar')
        ->name('comunicacao.cadastrar');

Route::get('/comunicacao_tipo/buscar', 
    'ComunicacaoTipoController@buscar')
        ->name('comunicacao_tipo.buscar');

Route::get('/perfil', 
    'PerfilController@index')
        ->name('perfil');

Route::match(['get', 'post'], '/perfil/listar', 
    'PerfilController@listar')
        ->name('perfil.listar');

Route::get('/perfil/modulo/{id}', 
    'PerfilController@buscarPorModulo');

Route::post('/perfil/acessos', 
    'PerfilController@cadastrar');

Route::post('/perfil', 
    'PerfilController@cadastrar')
        ->name('perfil');

Route::get('/perfil/editar/{id}', 
    'PerfilController@editar')
        ->name('perfil.editar');

Route::get('/perfil/acessos/{id}', 
    'PerfilController@getPerfilAcesso');

Route::post('/perfil/atualizar/{id}', 
    'PerfilController@atualizar')
        ->name('perfil.atualizar');

Route::get('/usuario', 
    'UsuarioController@index')
        ->name('usuario');

Route::match(['get', 'post'], '/usuario/listar', 
    'UsuarioController@listar')
        ->name('usuario.listar');

Route::get('/usuario/perfil/{id}', 
    'UsuarioController@buscarPerfis');

Route::get('/usuario/perfil', 
    'UsuarioController@getPerfis');

Route::get('/usuario/nome', 
    'UsuarioController@buscarUsuarioPeloNome')
        ->name('usuario.nome');

Route::post('/usuario/cadastrar', 
    'UsuarioController@cadastrar')
        ->name('usuario.cadastrar');

Route::get('/usuario/editar/{id}', 
    'UsuarioController@editar')
        ->name('usuario.editar');

Route::put('/usuario/atualizar/{id}', 
    'UsuarioController@atualizar')
        ->name('usuario.atualizar');

Route::get('/oportunidades/importacao', 
    'ImportacaoController@index')
        ->name('importacao');
Route::post('/oportunidades/importar', 
    'ImportacaoController@importar')
        ->name('importarxls');

Route::post('/oportunidades/importarModal', 
    'ImportacaoController@importarModal')
        ->name('importarModal');

Route::get('/oportunidades/consulta', 
    'ConsultaOportunidadesController@index')
        ->name('oportunidades.consulta');

Route::post('/oportunidades/consultar', 
    'ConsultaOportunidadesController@consultar')
        ->name('oportunidades.consultar');

Route::get('/oportunidades/autocomplete_cliente', 
    'ConsultaOportunidadesController@autocomplete_cliente')
        ->name('oportunidades.autocomplete_cliente');

Route::get('/oportunidades/acompanhamento/{id}', 
    'AcompanhamentoOportunidadesController@index')
        ->name('oportunidades.acompanhamento');

Route::get('/oportunidades/selecionar', 
    'AcompanhamentoOportunidadesController@selecionar')
        ->name('oportunidades.selecionar');

Route::get('/oportunidades/cancelar', 
    'AcompanhamentoOportunidadesController@cancelar')
        ->name('oportunidades.cancelar');

Route::get('/oportunidades/getAnteriorProximo', 
    'AcompanhamentoOportunidadesController@proximoAnterior')
        ->name('oportunidades.proximoAnterior');
    
//Pesquisa Disponibilidade Médicos
Route::get('/disponibilidade/consultaDisponibilidadeMedicos', 
    'MedicoDisponibilidadeController@index')
        ->name('disponibilidade.pesquisa');

Route::post('/disponibilidade/consultaDisponibilidadeMedicos', 
    'MedicoDisponibilidadeController@consultar')
        ->name('disponibilidade.consultar');

Route::get('/disponibilidade/crm', 
    'MedicoDisponibilidadeController@autocompleteCRM')
        ->name('disponibilidade.crm');

Route::get('/disponibilidade/medico', 
    'MedicoDisponibilidadeController@autocompleteMedico')
        ->name('disponibilidade.medico');
 
Route::get('/medicosClientes/pesquisa', 
    'ClienteMedicoController@index')
        ->name('medicosClientes.pesquisa');

Route::post('/medicosClientes/consultar', 
    'ClienteMedicoController@consultar')
        ->name('medicosClientes.consultar');

Route::get('/medicosClientes/editar/{id}', 
    'ClienteMedicoController@editar')
        ->name('medicosClientes.editar');

Route::get('/medicosClientes/inserir', 
    'ClienteMedicoController@inserir')
        ->name('medicosClientes.inserir');

Route::get('/especialidades/autocomplete_cliente', 
    'EspecialidadeController@autocomplete_especialidade')
        ->name('especialidade.autocomplete_cliente');
    

