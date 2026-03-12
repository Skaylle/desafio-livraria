import React, { useEffect, useState } from 'react';
import DataTable from '../components/DataTable.jsx';
import { fetchAutores, deleteAutor } from '../services/autoresService.js';
import { useNavigate } from 'react-router-dom';

const columns = [{ field: 'nome', label: 'Nome' }];

const Autores = () => {
  const [autores, setAutores] = useState([]);
  const [pagination, setPagination] = useState({});
  const [currentPage, setCurrentPage] = useState(1);
  const [pageSize, setPageSize] = useState(10);

  const navigate = useNavigate();

  const loadAutores = async (page = currentPage, limit = pageSize) => {
    const result = await fetchAutores({ page, limit });
    if (result.success) {
      const { data, pagination, current_page, per_page } = result;
      setAutores(data);
      setPagination(pagination);
      setCurrentPage(current_page || 1);
      setPageSize(per_page || 10);
    }
  };

  useEffect(() => {
    loadAutores();
  }, []);

  const handleRemover = async (id) => {
    if (window.confirm('Deseja realmente remover este autor?')) {
      const result = await deleteAutor(id);
      if (result.success) {
        alert(result.message);
        loadAutores(pagination?.current_page || 1, pagination?.per_page || 10);
      }
    }
  };

  const renderActions = (row) => (
    <div className="d-flex gap-2">
      <button
        type="button"
        className="btn btn-link p-0"
        onClick={() => navigate(`/autores/editar/${row.cod_autor}`)}
      >
        <i className="bi bi-pencil text-primary" />
      </button>
      <button
        type="button"
        className="btn btn-link p-0"
        onClick={() => handleRemover(row.cod_autor)}
      >
        <i className="bi bi-trash text-danger" />
      </button>
    </div>
  );

  return (
    <div className="container mt-5">
      <div className="bg-white p-4 rounded shadow">
        <div className="d-flex justify-content-between align-items-center mb-3">
          <h4 className="mb-0">Autores</h4>
        </div>
        <DataTable
          columns={columns}
          data={autores}
          pagination={pagination}
          onPageChange={loadAutores}
          defaultPageSize={pageSize}
          renderActions={renderActions}
          rowKey="cod_autor"
          selectable={false}
          defaultSelected={[]}
        />
        <div className="d-flex justify-content-end gap-2">
          <button
            type="button"
            className="btn btn-primary"
            onClick={() => navigate('/autores/novo')}
          >
            Inserir autor
          </button>
          <button
            type="button"
            className="btn btn-success"
            onClick={() => loadAutores(pagination?.current_page || 1, pagination?.per_page || 10)}
          >
            Pesquisar
          </button>
        </div>
      </div>
    </div>
  );
};

export default Autores;
