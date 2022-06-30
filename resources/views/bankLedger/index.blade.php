@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header bg-defult">
                    <div class="card-title">
                        <h2 class="card-title">
                            <a href="{{  asset('bankLedger/create') }}" class="btn bg-navy text-capitalize mr-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Create Booking">
                                <i class="fa-solid fa-circle-plus mr-2"></i>
                                Add
                            </a>
                            Bank Ledger
                        </h2>
                    </div>
                    <a class="btn btn-sm bg-navy float-right text-capitalize" href="/balance/trash"><i class="fa-solid fa-recycle mr-2"></i>View Trash</a>
                    <a class="btn btn-sm bg-maroon float-right text-capitalize mr-3" href="/balance/delete"><i class="fa-solid fa-trash-can mr-2"></i>Delete All</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>BankID</th>
                                <th>Deposit</th>
                                <th>Withdraw</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($BankLedgers as $BankLedger)
                            <tr>
                                <td>{{$BankLedger->BankID}}</td>
                                <td>{{$BankLedger->Deposit}}</td>
                                <td>{{$BankLedger->Withdraw}}</td>
                                <td>{{$BankLedger->Date}}</td>
                                <td>{{$BankLedger->Description}}</td>
                                <td class="d-flex">
                                    <a href="/bankLedger/{{$BankLedger->id}}" class="mr-3 text-purple" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View">
                                        <svg data-v-9a6e255c="" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="invoice-row-5036-preview-icon" class="mx-1 feather feather-eye">
                                            <path data-v-9a6e255c="" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle data-v-9a6e255c="" cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                    <a class=" btn btn-info btn-sm mx-2" href="/bankLedger/{{$BankLedger->id}}/edit" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                                        Update
                                        <i class="fa-regular fa-pen-to-square mr-3 text-black"></i></i>
                                    </a>
                                    {{ Form::open(['url' => '/bankLedger/'.$BankLedger->id,'method' => 'DELETE'])}}

                                    <button class=" btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                                        Delete
                                        <i class="fa-regular fa-trash-can mr-3 text-black"></i>
                                    </button>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection