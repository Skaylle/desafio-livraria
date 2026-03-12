import React, { useEffect, useState } from 'react';
import DataTable from '../components/DataTable.jsx';
import { fetchLivros, deleteLivro } from '../services/livrosService.js';
import { useNavigate } from 'react-router-dom';
import { formatMoney } from '../helpers/Util.js';
import { abrirPDF } from '../services/pdfService.js';

const columns = [
  { field: 'titulo', label: 'Título' },
  { field: 'editora', label: 'Editora' },
  { field: 'edicao', label: 'Edição' },
  { field: 'ano_publicacao', label: 'Ano' },
  { field: 'valor', label: 'Valor', format: formatMoney },
];

const Livros = () => {
  const [livros, setLivros] = useState([]);
  const [pagination, setPagination] = useState({});
  const [currentPage, setCurrentPage] = useState(1);
  const [pageSize, setPageSize] = useState(10);

  const navigate = useNavigate();

  useEffect(() => {
    loadLivros();
  }, []);

  const loadLivros = async (page = currentPage, limit = pageSize) => {
    const result = await fetchLivros({ page, limit });

    if (result.success) {
      const { data, pagination, current_page, per_page } = result;
      setLivros(data);
      setPagination(pagination);
      setCurrentPage(current_page || 1);
      setPageSize(per_page || 10);
    }
  };

  const excluirLivro = async (id) => {
    const confirm = window.confirm('Tem certeza que deseja excluir o registro?');
    if (!confirm) return;

    const result = await deleteLivro(id);

    if (result.success) {
      loadLivros(pagination?.current_page || 1, pagination?.per_page || 10);
    } else {
      alert(result.message);
    }
  };

  const renderActions = (row) => (
    <div className="d-flex gap-2 justify-content-end">
      <i
        className="bi bi-pencil text-primary"
        title="Editar"
        style={{ cursor: 'pointer' }}
        onClick={() => navigate(`/livros/editar/${row.cod_livro}`)}
      />

      <i
        className="bi bi-trash text-danger"
        title="Excluir"
        style={{ cursor: 'pointer' }}
        onClick={() => excluirLivro(row.cod_livro)}
      />
    </div>
  );

  const openPage = () => {
    navigate('/livros/novo');
  };

  return (
    <div className="container mt-5">
      <div className="bg-white p-4 rounded shadow">
        <div className="d-flex justify-content-between align-items-center mb-3">
          <h4 className="mb-0">Livros</h4>
        </div>

        <DataTable
          columns={columns}
          data={livros}
          pagination={pagination}
          onPageChange={loadLivros}
          defaultPageSize={pageSize}
          renderActions={renderActions}
          rowKey="cod_livro"
          selectable={false}
          defaultSelected={[]}
        />

        <div className="d-flex justify-content-end gap-2">
          <button type="button" className="btn btn-primary" onClick={openPage}>
            Inserir livro
          </button>
          <button
            type="button"
            className="btn btn-success"
            onClick={() => loadLivros(pagination?.current_page || 1, pagination?.per_page || 10)}
          >
            Pesquisar
          </button>
          <button type="button" className="btn btn-danger" onClick={() => abrirPDF()}>
            Gerar Relatório
          </button>
        </div>
      </div>
    </div>
  );
};

export default Livros;
