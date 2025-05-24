@extends('admin.layout')

@section('title')
(ユーザ一覧画面)
@endsection

@section('contents')

    <a href="{{ route('admin.top') }}">管理画面Top</a><br>
    <a href="{{ route('admin.user.list') }}">ユーザ一覧</a><br>
    <a href="/admin/logout">ログアウト</a><br>

    <h1>ユーザ一覧</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ユーザID</th>
                <th>ユーザ名</th>
                <th>購入した「買うもの」の数</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user) 
            <tr>
                <td>{{ $user->id }}</td> 
                <td>{{ $user->name }}</td>
                <td>{{ $user->shopping_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection