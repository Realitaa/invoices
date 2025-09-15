@extends('layouts.paper')

@section('title', 'Print Invoice')

@section('content')
This is print blade for {{ $invoice->id }}
@endsection