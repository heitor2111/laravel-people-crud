@extends('layouts.app')

@section('content')
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Número do Documento</th>
                <th scope="col">Data de Nascimento</th>
                <th scope="col">Data de Criação</th>
                <th scope="col" class="text-center">Contatos</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($people as $person)
                <tr style="cursor: pointer;" onclick="location.href = '{{ url($person->id) }}'">
                    <td>{{ $person->first_name . ' ' . $person->last_name }}</td>
                    <td>{{ $person->document }}</td>
                    <td>{{ $person->birth_date->format('d/m/Y') }}</td>
                    <td>{{ $person->created_at->format('d/m/Y H:m:s') }}</td>
                    <td class="text-center">{{ $person->contacts()->count() }}</td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="5">Nenhuma pessoa cadastrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

@section('footer')
    <div class="d-flex align-items-center justify-content-center pt-3 border-top border-primary border-3">
        <div class="w-75">
            {{ $people }}
        </div>
    </div>
@endsection
