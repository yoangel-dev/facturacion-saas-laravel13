@extends('layouts.admin')

@section('title', 'Facturas del tenant')

@section('content')
<h1>Facturas de {{ $tenant->nombre }}</h1>

@include('invoices.table', ['invoices' => $invoices])
@endsection