@extends('layouts.admin')

@section('title', 'Clientes del tenant')

@section('content')
<h1>Clientes de {{ $tenant->nombre }}</h1>

@include('clients.table', ['clients' => $clients])
@endsection