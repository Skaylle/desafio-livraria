<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .autor-table {
            page-break-inside: avoid; /* evita quebrar o autor entre páginas */
        }

        h3 {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        h3:not(:first-child) {
            page-break-before: always; /* nova página para autores 2+ */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            display: table-header-group; /* repete cabeçalho se tabela quebrar */
        }

        th, td {
            padding: 8px 12px;
            border: 1px solid #000;
        }

        th {
            background-color: #343a40;
            color: #fff;
            text-align: left;
        }

        tr {
            page-break-inside: avoid; /* evita quebrar linha no meio */
            min-height: 25px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Relatório de Livros por Autor</h1>

        @foreach($dados as $autor => $livros)
            <div class="autor-table">
                <h3>{{ $autor }}</h3>
                <table class="table table-bordered table-striped mb-4">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Assunto(s)</th>
                            <th>Editora</th>
                            <th>Ano</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($livros as $index => $livro)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $livro->titulo }}</td>
                            <td>{{ $livro->assuntos }}</td>
                            <td>{{ $livro->editora }}</td>
                            <td>{{ $livro->ano_publicacao }}</td>
                            <td>R$ {{ number_format($livro->valor, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</body>
</html>