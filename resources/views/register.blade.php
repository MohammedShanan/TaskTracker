@extends('layouts.authlayout')
@section('title', "register")
@section('name', "Sign up")
@section('question', 'All ready have an account')
@section('link', 'login')
@section('link name', 'Login')
@section('content')
        <input type="text" name="name" placeholder="User name" class="mb-2">
        <input type="email" name="email" placeholder="Email" class="mb-2">
        <input type="password" name="password" placeholder="Password" class="mb-2">
        <input type="password" name="password_confirmation" placeholder="Confirm password">
@endsection