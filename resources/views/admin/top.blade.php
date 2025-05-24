@extends('admin.layout')

@section('contents')
        <a href="{{ route('admin.top') }}">管理画面Top</a><br>
        <a href="{{ route('admin.user.list') }}">ユーザ一覧</a><br>
        <a href="/admin/logout">ログアウト</a><br>
        
        <h1>管理画面</h1>
@endsection