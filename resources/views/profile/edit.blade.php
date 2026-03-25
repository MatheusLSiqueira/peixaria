@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="font-display text-3xl text-blue-950 mb-8">👤 Meu Perfil</h1>

    <div class="space-y-6">

        {{-- Profile Information --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Password Update --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            @include('profile.partials.update-password-form')
        </div>

        {{-- Account Deletion --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</div>
@endsection
