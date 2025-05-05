<?php
$titulo_pagina = "Empresas";
require("settings.php");
include("head.php");
include("menu.php");
include("topo.php");
    ?>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <a href="javascript:void(0);" class="btn btn-sm btn-light shadow-sm busca_bt">
                <i class="fas fa-search fa-sm text-black-50"></i> Busca
                <i class="fas fa-circle busca_realizada" title="Existe uma ou mais filtragens ativas" style="display: inline;"></i>
            </a>
            <a href="<?=$url?>/usuarios_form" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Adicionar
            </a>
        </div>
        <div class="row busca_box" style="display:none;">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body table-responsive">
                        <form name="form_busca" method="GET" action="<?=$url?>/empresas">
                            <div class="form-row">
                                <div class="col-md-6 col-lg-5 d-flex">
                                    <label class="form-label">Filtrar:</label>
                                    <input type="text" name="busca" class="form-control" value="">
                                </div>
                                <div class="col-md-6 col-lg-2 d-flex">
                                    <label class="form-label">Status:</label>
                                    <select name="ativo" class="form-control">
                                        <option value="">Todos</option>
                                        <option value="1">Ativos</option>
                                        <option value="2">Inativos</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-sm text-white-50"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Nivel</th>
                                    <th>Celular</th>
                                    <th>E-mail</th>
                                    <th style="width:100px;">Status</th>
                                    <th style="width:70px;">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>NOME DO USUÁRIO</td>
                                    <td>Administrador</td>
                                    <td>(11) 99999-9999</td>
                                    <td>usuario@jwb.com.br</td>
                                    <td><small class="bg-success text-white d-inline-flex px-2 py-1 rounded">Ativo</small></td>
                                    <td>
                                        <a href="<?=$url?>/usuarios_form" class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-id="65" class="btn btn-danger btn-circle btn-sm btnDelete" id="btnDelete" data-toggle="modal" data-target="#confirmationModal_65">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <div class="modal" id="confirmationModal_65" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Exclusão de registro</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Tem certeza que deseja excluir esse registro?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form id="formDelete" action="#" name="deletar" method="post">
                                                        <button type="buttom" id="deleteConfirm" class="btn btn-primary">Confirmar</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                            <input type="hidden" name="companyId" id="idToDelete" value="65">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>NOME DO USUÁRIO</td>
                                    <td>Cliente (ADM)</td>
                                    <td>(11) 99999-9999</td>
                                    <td>usuario@jwb.com.br</td>
                                    <td><small class="bg-success text-white d-inline-flex px-2 py-1 rounded">Ativo</small></td>
                                    <td>
                                        <a href="<?=$url?>/usuarios_form" class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-id="65" class="btn btn-danger btn-circle btn-sm btnDelete" id="btnDelete" data-toggle="modal" data-target="#confirmationModal_65">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <div class="modal" id="confirmationModal_65" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Exclusão de registro</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Tem certeza que deseja excluir esse registro?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form id="formDelete" action="#" name="deletar" method="post">
                                                        <button type="buttom" id="deleteConfirm" class="btn btn-primary">Confirmar</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                            <input type="hidden" name="companyId" id="idToDelete" value="65">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>NOME DO USUÁRIO</td>
                                    <td>Cliente (Usuário)</td>
                                    <td>(11) 99999-9999</td>
                                    <td>usuario@jwb.com.br</td>
                                    <td><small class="bg-success text-white d-inline-flex px-2 py-1 rounded">Ativo</small></td>
                                    <td>
                                        <a href="<?=$url?>/usuarios_form" class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-id="65" class="btn btn-danger btn-circle btn-sm btnDelete" id="btnDelete" data-toggle="modal" data-target="#confirmationModal_65">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <div class="modal" id="confirmationModal_65" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Exclusão de registro</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Tem certeza que deseja excluir esse registro?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form id="formDelete" action="#" name="deletar" method="post">
                                                        <button type="buttom" id="deleteConfirm" class="btn btn-primary">Confirmar</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                            <input type="hidden" name="companyId" id="idToDelete" value="65">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>NOME DO USUÁRIO</td>
                                    <td>Cliente (Usuário)</td>
                                    <td>(11) 99999-9999</td>
                                    <td>usuario@jwb.com.br</td>
                                    <td><small class="bg-success text-white d-inline-flex px-2 py-1 rounded">Ativo</small></td>
                                    <td>
                                        <a href="<?=$url?>/usuarios_form" class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-id="65" class="btn btn-danger btn-circle btn-sm btnDelete" id="btnDelete" data-toggle="modal" data-target="#confirmationModal_65">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <div class="modal" id="confirmationModal_65" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Exclusão de registro</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Tem certeza que deseja excluir esse registro?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form id="formDelete" action="#" name="deletar" method="post">
                                                        <button type="buttom" id="deleteConfirm" class="btn btn-primary">Confirmar</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                            <input type="hidden" name="companyId" id="idToDelete" value="65">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>NOME DO USUÁRIO</td>
                                    <td>Cliente (Usuário)</td>
                                    <td>(11) 99999-9999</td>
                                    <td>usuario@jwb.com.br</td>
                                    <td><small class="bg-danger text-white d-inline-flex px-2 py-1 rounded">Inativo</small></td>
                                    <td>
                                        <a href="<?=$url?>/usuarios_form" class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-id="65" class="btn btn-danger btn-circle btn-sm btnDelete" id="btnDelete" data-toggle="modal" data-target="#confirmationModal_65">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <div class="modal" id="confirmationModal_65" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Exclusão de registro</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Tem certeza que deseja excluir esse registro?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form id="formDelete" action="#" name="deletar" method="post">
                                                        v
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                            <input type="hidden" name="companyId" id="idToDelete" value="65">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="container text-center paginacao_espacamento">
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">

                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700 leading-5">
                                            Total
                                            <span class="font-medium">150</span>
                                            resultados
                                        </p>
                                    </div>

                                    <div>
                                        <span class="relative z-0 inline-flex">

                                            <span aria-disabled="true" aria-label="&amp;laquo; Previous">
                                                <span aria-hidden="true" class="paginacao_bt paginacao_bt_disabled">
                                                    <svg 0="" 10="" 25="" style="max-height:25px;" fill="currentColor" viewBox="5 0 10 22">
                                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                            </span>

                                            <span aria-current="page" class="paginacao_bt paginacao_bt_active">
                                                <span class="">1</span>
                                            </span>
                                            <a href="#" aria-label="Go to page 2" class="paginacao_bt">
                                                2
                                            </a>
                                            <a href="#" aria-label="Go to page 3" class="paginacao_bt">
                                                3
                                            </a>
                                            <a href="#" aria-label="Go to page 4" class="paginacao_bt">
                                                4
                                            </a>
                                            <a href="#" aria-label="Go to page 5" class="paginacao_bt">
                                                5
                                            </a>

                                            <a href="#" rel="next" aria-label="Next &amp;raquo;" class="paginacao_bt">
                                                <svg 0="" 10="" 25="" style="max-height:25px;" fill="currentColor" viewBox="5 0 10 22">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("footer.php");
?>