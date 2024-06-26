<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sugestao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDO;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dados = [];
        

        // Contagem de sugestões por categoria
        $sugestoesPorCategoria = Sugestao::selectRaw('category as Categoria, count(*) as total')
            ->groupBy('category')
            ->get();

        // Contar registros das últimas 24 horas e o total de registros
        $totalUltimas24Horas = Sugestao::where('created_at', '>=', now()->subDay())
            ->count();

        $totalRegistros = Sugestao::count();

        // Calcular a porcentagem
        if ($totalRegistros > 0) {
            $porcentagem = ($totalUltimas24Horas / $totalRegistros) * 100;
            $porcentagemTexto = sprintf("%.2f%%", $porcentagem);
        } else {
            $porcentagemTexto = "Não há registros no total.";
        }

        // Preparar dados para o gráfico
        $labels = $sugestoesPorCategoria->pluck('Categoria')->toArray();
        $counts = $sugestoesPorCategoria->pluck('total')->toArray();

        // Dados para passar para a view
        $dados = [
            'labels' => $labels,
            'counts' => $counts,
            'registrosHoje' => Sugestao::whereDate('created_at', today())->count(),
            'porcentagemTexto' => $porcentagemTexto,
            'totalRegistros' => $totalRegistros,
        ];

        return view('dashboard', compact('dados'));
    }

    public function performBackup(Request $request)
    {
        $dbname = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');

        try {
            // Conexão com o banco de dados
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Receber as tabelas exportadas
            $tabelas_exportadas = "";

            // QUERY para recuperar as tabelas do banco de dados
            $query_listar_tabelas = "SHOW TABLES";

            // Preparar a QUERY
            $result_listar_tabelas = $conn->prepare($query_listar_tabelas);

            // Executar a QUERY
            $result_listar_tabelas->execute();

            // Criar o nome do arquivo de backup
            $backupDir = storage_path('backup');
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            $nome_arquivo = $backupDir . '/db_backup_' . date('Y-m-d-H-i-s') . '.sql';

            // Abrir o arquivo somente para escrita
            $arquivo = fopen($nome_arquivo, 'a');

            // Verificar se encontrou alguma tabela no banco de dados
            if ($result_listar_tabelas->rowCount() != 0) {
                // Criar o laço de repetição para ler as tabelas
                while ($row_tabela = $result_listar_tabelas->fetch(PDO::FETCH_NUM)) {
                    // Criar a QUERY excluir tabela
                    // $instrucao_sql = "DROP TABLE IF EXISTS `{$row_tabela[0]}`;\n";
                    // fwrite($arquivo, $instrucao_sql);

                    // Recuperar o nome das colunas da tabela
                    $query_nome_colunas = "SHOW COLUMNS FROM {$row_tabela[0]}";
                    $result_nome_colunas = $conn->prepare($query_nome_colunas);
                    $result_nome_colunas->execute();

                    // Verificar se encontrou alguma coluna para a tabela
                    if ($result_nome_colunas->rowCount() != 0) {
                        // Criar a QUERY criar tabela
                        $instrucao_sql = "CREATE TABLE IF NOT EXISTS `{$row_tabela[0]}` (\n";
                        $chave_primaria = "";

                        // Ler as colunas da tabela
                        while ($row_nome_coluna = $result_nome_colunas->fetch(PDO::FETCH_ASSOC)) {
                            extract($row_nome_coluna);
                            $instrucao_sql .= "`$Field` $Type ";
                            $instrucao_sql .= $Default != null ? "DEFAULT $Default " : ($Null == "YES" ? "DEFAULT NULL " : "NOT NULL ");
                            $instrucao_sql .= $Extra == "auto_increment" ? "AUTO_INCREMENT,\n" : ",\n";
                            $chave_primaria = $Key == "PRI" ? "PRIMARY KEY (`$Field`)" : $chave_primaria;
                        }
                        $instrucao_sql .= $chave_primaria;

                        // QUERY para recuperar as configurações da tabela
                        $query_conf_tabela = "SHOW TABLE STATUS WHERE Name = '{$row_tabela[0]}'";
                        $result_conf_tabela = $conn->prepare($query_conf_tabela);
                        $result_conf_tabela->execute();
                        $row_conf_tabela = $result_conf_tabela->fetch(PDO::FETCH_ASSOC);
                        extract($row_conf_tabela);

                        $instrucao_sql .= "\n) ENGINE=$Engine AUTO_INCREMENT=$Auto_increment DEFAULT CHARSET=utf8mb4 COLLATE=$Collation; \n\n";
                        fwrite($arquivo, $instrucao_sql);
                        $tabelas_exportadas .= "{$row_tabela[0]}, ";

                        // Recuperar os registros da tabela
                        $query_registros = "SELECT * FROM {$row_tabela[0]}";
                        $result_registros = $conn->prepare($query_registros);
                        $result_registros->execute();

                        if ($result_registros->rowCount() != 0) {
                            $instrucao_sql = "INSERT INTO `$row_tabela[0]` VALUES \n";
                            fwrite($arquivo, $instrucao_sql);

                            $qtd_registros = $result_registros->rowCount();
                            $qtd_registros_impressos = 1;

                            while ($row_registro = $result_registros->fetch(PDO::FETCH_ASSOC)) {
                                $instrucao_sql = "(";
                                $qtd_colunas = count($row_registro);
                                $qtd_colunas_impressas = 1;

                                foreach ($row_registro as $chave => $valor) {
                                    $valor = addslashes($valor);
                                    $valor = str_replace("\n", "\\n", $valor);
                                    $instrucao_sql .= !empty($valor) ? '"' . $valor . '"' . ($qtd_colunas_impressas >= $qtd_colunas ? "" : ",") : 'NULL' . ($qtd_colunas_impressas >= $qtd_colunas ? "" : ",");
                                    $qtd_colunas_impressas++;
                                }
                                $instrucao_sql .= ")" . ($qtd_registros_impressos >= $qtd_registros ? ";\n\n" : ",\n");
                                $qtd_registros_impressos++;
                                fwrite($arquivo, $instrucao_sql);
                            }
                        } else {
                            //fwrite($arquivo, "<p style='color: #f00;'>Erro: Nenhum registro encontrado na tabela {$row_tabela[0]}!</p>\n");
                        }
                    } else {
                        //fwrite($arquivo, "<p style='color: #f00;'>Erro: Nenhuma coluna para a tabela {$row_tabela[0]} encontrada!</p>\n");
                    }
                }

                $tabelas_exportadas = rtrim($tabelas_exportadas, ", ");
                //fwrite($arquivo, "<p style='color: green;'>Exportado as tabelas $tabelas_exportadas!</p>\n");
            } else {
                //fwrite($arquivo, "<p style='color: #f00;'>Erro: Nenhuma tabela encontrada!</p>\n");
            }

            fclose($arquivo);

            // Retornar o arquivo de backup para download
            return response()->download($nome_arquivo)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao realizar o backup: ' . $e->getMessage()], 500);
        }
    }

    public function gerarCsv(Request $request)
    {
        // Recuperar e pesquisar os registros do banco de dados
        $sugestoes = Sugestao::when($request->has('nome'), function ($query) use ($request) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        })
            ->when($request->filled('data_inicio'), function ($query) use ($request) {
                $query->where('created_at', '>=', Carbon::parse($request->data_inicio)->format('Y-m-d'));
            })
            ->when($request->filled('data_fim'), function ($query) use ($request) {
                $query->where('created_at', '<=', Carbon::parse($request->data_fim)->format('Y-m-d'));
            })
            ->orderBy('created_at')
            ->get();

        // Criar o arquivo temporário
        $csvNomeArquivo = tempnam(sys_get_temp_dir(), 'csv_' . Str::ulid());

        // Abrir o arquivo na forma de escrita
        $arquivoAberto = fopen($csvNomeArquivo, 'w');

        // Criar o cabeçalho do CSV - Usar a função mb_convert_encoding para converter caracteres especiais
        $cabecalho = [
            'Nome',
            'Telefone',
            'Email',
            'Categoria',
            'Sugestão',
            'Data de Cadastro',
            'Hora de Cadastro'
        ];

        // Escrever o cabeçalho no arquivo
        fputcsv($arquivoAberto, $cabecalho, ';');

        // Ler os registros recuperados do banco de dados
        foreach ($sugestoes as $sugestao) {
            // Criar o array com os dados da linha do CSV
            $sugestaoArray = [
                mb_convert_encoding($sugestao->name, 'ISO-8859-1', 'UTF-8'),
                $sugestao->telefone,
                $sugestao->email,
                mb_convert_encoding($sugestao->category, 'ISO-8859-1', 'UTF-8'),
                mb_convert_encoding($sugestao->message, 'ISO-8859-1', 'UTF-8'),
                $sugestao->created_at->format('Y-m-d'),
                $sugestao->created_at->format('H:i:s')
            ];

            // Escrever o conteúdo no arquivo
            fputcsv($arquivoAberto, $sugestaoArray, ';');
        }

        // Fechar o arquivo após a escrita
        fclose($arquivoAberto);

        // Realizar o download do arquivo
        return response()->download($csvNomeArquivo, 'relatorio_sugestoes_' . Str::ulid() . '.csv');
    }

}
