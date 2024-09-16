@extends('layouts.authlayout')
@section("title", "login")
@section('name', "Login")
@section('question', "Don't have an account")
@section('link', 'register')
@section('link name', 'Sign up')
@section('content')
        <input type="text" name="name" placeholder="User name" class="mb-2">
        <input type="password" name="password" placeholder="Password" class="mb-2">
@endsection