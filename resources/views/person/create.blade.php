@extends('layouts.app')

@section('content')
    <form
        id="create-form"
        class="needs-validation"
        action="{{ route('personStore') }}"
        method="POST"
        novalidate
    >
        @csrf

        <div class="container py-3">
            <div class="row">
                <h4>Dados Pessoais:</h4>

                <div class="col-6">
                    <label for="first_name" class="form-label">Nome:</label>
                    <input
                        id="first_name"
                        name="first_name"
                        type="text"
                        required
                        placeholder="Insira o nome"
                        class="form-control @error('first_name') is-invalid @enderror"
                    >

                    @error('first_name')
                        <small class="is-invalid pb-3">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-6">
                    <label for="last_name" class="form-label">Sobrenome:</label>
                    <input
                        id="last_name"
                        name="last_name"
                        type="text"
                        required
                        placeholder="Insira o sobrenome"
                        class="form-control @error('last_name') is-invalid @enderror"
                    >

                    @error('last_name')
                        <small class="is-invalid pb-3">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-sm-12 col-md-4 col-lg">
                    <label for="document" class="form-label">Documento:</label>
                    <input
                        id="document"
                        name="document"
                        type="text"
                        required
                        maxlength="14"
                        placeholder="Insira o documento"
                        class="form-control @error('document') is-invalid @enderror"
                    >

                    @error('document')
                        <small class="is-invalid pb-3">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-sm-12 col-md">
                    <label for="birth_date" class="form-label">Data de Nascimento:</label>
                    <input
                        id="birth_date"
                        name="birth_date"
                        type="date"
                        class="form-control"
                        placeholder="Selecione a data de nascimento"
                    >
                </div>

                <div class="col-sm-12 col-md">
                    <label for="profession" class="form-label">Profissão:</label>
                    <select
                        id="profession"
                        name="profession"
                        class="form-select"
                    >
                        <option value="" disabled selected hidden>Selecione a profissão</option>
                        @foreach ($professions as $profession)
                            <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row pt-4">
                <h4>Dados de Acesso:</h4>

                <div class="col-sm-12 col-md">
                    <label for="username">Nome de Usuário:</label>
                    <input
                        class="form-control @error('username') is-invalid @enderror"
                        id="username"
                        name="username"
                        placeholder="Insira o nome de usuário"
                        required
                    >

                    @error('username')
                        <small class="is-invalid pb-3">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-sm-12 col-md">
                    <label for="password">Senha:</label>
                    <input
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Insira uma senha segura"
                        required
                    >

                    @error('password')
                        <small class="is-invalid pb-3">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row pt-4">
                <h4>Dados de Contato:</h4>

                <div class="col-sm-12 col-md">
                    <label for="phone_1">Telefone:</label>
                    <input
                        class="form-control @error('phone_1') is-invalid @enderror"
                        id="phone_1"
                        name="phone_1"
                        placeholder="Insira o telefone"
                    >

                    @error('phone_1')
                        <small class="is-invalid pb-3">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-sm-12 col-md">
                    <label for="phone_2">Celular:</label>
                    <input
                        class="form-control @error('phone_2') is-invalid @enderror"
                        id="phone_2"
                        name="phone_2"
                        placeholder="Insira o celular"
                    >

                    @error('phone_2')
                        <small class="is-invalid pb-3">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-sm-12 col-md">
                    <label for="email">E-mail:</label>
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        placeholder="Insira o e-mail"
                    >

                    @error('email')
                        <small class="is-invalid pb-3">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <div class="d-flex justify-content-end p-2 border-top border-primary border-3">
        <button type="submit" form="create-form" class="btn btn-primary w-25">Cadastrar</button>
    </div>
@endsection
