@extends('admin.layout')

@section('title')
@endsection

@section('contents')
    <h1>管理画面ログイン</h1>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form action="/admin/login" method="post">
        @csrf
        ログインID:<input type="text" name="login_id" value="{{ old('login_id') }}"><br> {{-- ★ここを修正 --}}
        パスワード:<input type="password" name="password"><br>
        <button>ログインする</button>
    </form>
@endsection