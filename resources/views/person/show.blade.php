@extends('layouts.app')

@section('content')
    <div class="w-100 d-flex justify-content-end gap-2">
        <a href="#" role="button" class="btn btn-warning">Editar</a>

        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDelete">
            Excluir
        </button>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h4>Dados Pessoais:</h4>

                <p class="my-1">ID: {{ $person->id }}</p>
                <p class="my-1">Nome: {{ $person->first_name }}</p>
                <p class="my-1">Sobrenome: {{ $person->last_name }}</p>
                <p class="my-1">Data de Nascimento: {{ $person->birth_date->format('d/m/Y') }}</p>
                <p class="my-1">Número do Documento: {{ $person->document }}</p>
                <p class="my-1">Data da Criação: {{ $person->created_at }}</p>
                <p class="my-1">Última Modificação:
                    {{ $person->created_at === $person->updated_at ? '-' : $person->updated_at }}
                </p>

                <p class="my-1">Profissão:
                    @foreach ($person->professions as $profession)
                        {{ $profession->name }}
                    @endforeach
                </p>
            </div>

            <div class="col-6">
                <h4>Contatos:</h4>

                @foreach ($person->contacts as $contact)
                    <p class="my-1">{{ $contact->description }}: {{ $contact->contact }}</p>
                @endforeach

                <h4 class="pt-5">Dados de Acesso:</h4>

                <p class="my-1">Usuário:
                    @foreach ($person->users as $user)
                        {{ $user->username }}
                    @endforeach
                </p>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div class="modal fade" id="confirmDelete" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Confirma a exclusão?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Após a exclusão, os registros de {{ $person->first_name . ' ' . $person->last_name }} ficarão
                    indisponíveis no sistema.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                    <button type="button" class="btn btn-primary">
                        <a class="text-decoration-none text-white"
                            href="{{ route('personDelete', $person->id) }}">Confirmar</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
