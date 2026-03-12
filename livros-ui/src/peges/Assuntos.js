import React, { useEffect, useState } from 'react';
import DataTable from '../components/DataTable.jsx';
import { fetchAssuntos, deleteAssunto } from '../services/assuntosService.js';
import { useNavigate } from 'react-router-dom';

const columns = [{ field: 'descricao', label: 'Descrição' }];

const Assuntos = () => {
  const [assuntos, setAssuntos] = useState([]);
  const [pagination, setPagination] = useState({});
  const [currentPage, setCurrentPage] = useState(1);
  const [pageSize, setPageSize] = useState(10);

  const navigate = useNavigate();

  const loadAssuntos = async (page = 1, limit = pageSize) => {
    const result = await fetchAssuntos({ page, limit });
    if (result.success) {
      const { data, pagination, current_page, per_page } = result;
      setAssuntos(data);
      setPagination(pagination);
      setCurrentPage(current_page || 1);
      setPageSize(per_page || 10);
    }
  };

  useEffect(() => {
    loadAssuntos();
  }, []);

  const excluirAssunto = async (id) => {
    const confirm = window.confirm('Tem certeza que deseja excluir o registro?');
    if (!confirm) return;
    const result = await deleteAssunto(id);
    if (result.success) {
      loadAssuntos(pagination?.current_page || 1, pagination?.per_page || 10);
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
        onClick={() => navigate(`/assuntos/editar/${row.cod_assunto}`)}
      />
      <i
        className="bi bi-trash text-danger"
        title="Excluir"
        style={{ cursor: 'pointer' }}
        onClick={() => excluirAssunto(row.cod_assunto)}
      />
    </div>
  );

  return (
    <div className="container mt-5">
      <div className="bg-white p-4 rounded shadow">
        <div className="d-flex justify-content-between align-items-center mb-3">
          <h4 className="mb-0">Assuntos</h4>
        </div>
        <DataTable
          columns={columns}
          data={assuntos}
          pagination={pagination}
          onPageChange={loadAssuntos}
          defaultPageSize={pageSize}
          renderActions={renderActions}
          rowKey="cod_assunto"
          selectable={false}
          defaultSelected={[]}
        />
        <div className="d-flex justify-content-end gap-2">
          <button
            type="button"
            className="btn btn-primary"
            onClick={() => navigate('/assuntos/novo')}
          >
            Inserir Assunto
          </button>
          <button
            type="button"
            className="btn btn-success"
            onClick={() => loadAssuntos(pagination?.current_page || 1, pagination?.per_page || 10)}
          >
            Pesquisar
          </button>
        </div>
      </div>
    </div>
  );
};

export default Assuntos;
