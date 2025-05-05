@extends('layouts.default')

@section('content-auth')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Quantidade de crédito</th>
                                    <th>Nome</th>
                                    <th>Valor</th>
                                    <th>Data Pedido</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedidos as $pedido)
                                    <tr>
                                        <td>{{ json_decode($pedido->json_pedidos)->items[0]->quantity }}</td>
                                        <td><?= json_decode($pedido->json_pedidos)->customer->name ?></td>
                                        <td>{{ "R$ " .  number_format(json_decode($pedido->json_pedidos)->items[0]->unit_amount / 100, 2,",",".") }}</td>
                                        <td>{{ date("d/m/Y H:i", strtotime($pedido->created_at)) }}</td>
                                        <td>
                                            @if (json_decode($pedido->json_pedidos)->charges[0]->status == 'PAID' || json_decode($pedido->json_pedidos)->charges[0]->status == 'AUTHORIZED')
                                                <small class="bg-success text-white d-inline-flex px-2 py-1 rounded">
                                                    <span style="width: 79px;text-align: center;font-weight:500">Aprovado</span>
                                                </small>
                                            @else
                                                <small class="bg-danger text-white d-inline-flex px-2 py-1 rounded">
                                                    <span style="width: 79px;text-align: center;font-weight:500">Não aprovado</span>
                                                </small>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Paginação --}}
                        <div class="container text-center paginacao_espacamento">
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700 leading-5">
                                            Total
                                            <span class="font-medium">{{ $pedidos->total() }}</span>
                                            resultados
                                        </p>
                                    </div>
                                    @if ($pedidos->hasPages())
                                        <div>
                                            <span class="relative z-0 inline-flex">
                                                @if ($pedidos->lastPage() > 1)
                                                    <span aria-disabled="true" aria-label="&amp;laquo; Previous">
                                                        <a href="{{ $pedidos->url($pedidos->currentPage() - 1) }}" aria-hidden="true" class="paginacao_bt {{ ($pedidos->currentPage() == 1) ? ' paginacao_bt_disabled' : '' }}">
                                                            <svg 0="" 10="" 25="" style="max-height:25px;" fill="currentColor" viewBox="5 0 10 22">
                                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </a>
                                                    </span>
                                                    @for ($i = 1; $i <= $pedidos->lastPage(); $i++)
                                                        @if ($pedidos->currentPage() == $i)
                                                            <span aria-current="page" class="paginacao_bt paginacao_bt_active">
                                                                <span class="">{{ $i }}</span>
                                                            </span>
                                                        @else
                                                            <a href="{{ $pedidos->url($i) }}" aria-label="Go to page {{ $i }}" class="paginacao_bt">
                                                                {{ $i }}
                                                            </a>
                                                        @endif
                                                    @endfor
                                                    <a href="{{ ($pedidos->currentPage() == $pedidos->lastPage()) ? '' : $pedidos->url($pedidos->currentPage() + 1) }}"  rel="next" aria-label="Next &amp;raquo;" class="paginacao_bt {{ ($pedidos->currentPage() == $pedidos->lastPage()) ? ' paginacao_bt_disabled' : '' }}">
                                                        <svg 0="" 10="" 25="" style="max-height:25px;" fill="currentColor" viewBox="5 0 10 22">
                                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                @endif                                       
                                            </span>
                                        </div>
                                    @endif    
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection