@extends('layouts.admin.layout')
@section('content')
    <div>
        {{ json_encode(AppHelper::breadcrumbs()) }}
    </div>
@endsection
