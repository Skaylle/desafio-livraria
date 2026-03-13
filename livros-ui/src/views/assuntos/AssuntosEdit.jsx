import React, { useState, useEffect } from 'react';
import { fetchAssunto, updateAssunto } from '../../services/assuntosService.js';
import { fetchLivros } from '../../services/livrosService.js';
import { validateForm } from '../../helpers/Util.js';
import { useNavigate, useParams } from 'react-router-dom';
import AssuntoForm from './AssuntoForm.jsx';

const requiredFields = ['descricao'];

const AssuntosEdit = () => {
  const { id } = useParams();
  const [formValues, setFormValues] = useState({ descricao: '' });
  const [formErrors, setFormErrors] = useState({});
  const [livros, setLivros] = useState([]);
  const [pagination, setPagination] = useState({});
  const [currentPage, setCurrentPage] = useState(1);
  const [pageSize, setPageSize] = useState(5);
  const [selectedLivros, setSelectedLivros] = useState([]);

  const navigate = useNavigate();

  useEffect(() => {
    if (id) {
      getAssunto();
      fetchLivrosList();
    }
  }, [id]);

  const fetchLivrosList = async (page = currentPage, limit = pageSize) => {
    const result = await fetchLivros({ page, limit });
    if (result.success) {
      const { data, pagination, current_page, per_page } = result;

      setLivros(data);
      setPagination(pagination);
      setCurrentPage(current_page || 1);
      setPageSize(per_page || 5);
    }
  };

  const getAssunto = async () => {
    const result = await fetchAssunto(id);
    if (result.success) {
      setFormValues({ ...result.data });

      if (result.data && result.data.livros) {
        setSelectedLivros(result.data.livros.map((l) => l.cod_livro));
      }
    } else {
      alert('Erro ao buscar os dados, tente novamente!');
      navigate('/assuntos');
    }
  };

  const resetForm = () => {
    setFormValues({ descricao: '' });
    setFormErrors({});
    setSelectedLivros([]);
  };

  const onChangeInput = (e) => {
    const { name, value } = e.target;
    setFormValues((prev) => ({ ...prev, [name]: value }));
  };

  const handleLivrosPageChange = (page, pageSize) => {
    setCurrentPage(page);
    setPageSize(pageSize);
    fetchLivrosList(page, pageSize);
  };

  const handleLivrosSelectionChange = (selectedRows) => {
    setSelectedLivros(selectedRows);
    setFormValues((prev) => ({ ...prev, selectedLivros: selectedRows }));
  };

  const handleEdit = async () => {
    const { isValid, errors } = validateForm(formValues, requiredFields);
    setFormErrors(errors);
    if (!isValid) {
      alert('Preencha todos os campos obrigatórios!');
      return;
    }
    try {
      const payload = { ...formValues, livros: selectedLivros };
      const response = await updateAssunto(id, payload);
      if (response.success) {
        alert(response.message);
        setTimeout(() => {
          resetForm();
          onBack();
        }, 500);
      } else {
        alert(response.message);
      }
    } catch (error) {
      alert(error.message);
    }
  };

  const onBack = () => {
    navigate('/assuntos');
  };

  return (
    <div
      className="container mt-5 d-flex justify-content-center align-items-center"
      style={{ minHeight: '30vh' }}
    >
      <AssuntoForm
        formValues={formValues}
        setFormValues={setFormValues}
        formErrors={formErrors}
        onChangeInput={onChangeInput}
        onSubmit={handleEdit}
        onBack={() => onBack()}
        livros={livros}
        livrosPagination={pagination}
        onLivrosPageChange={handleLivrosPageChange}
        onLivrosSelectionChange={handleLivrosSelectionChange}
        defaultLivrosSelected={selectedLivros}
        defaultLivrosPageSize={pageSize}
        labelForm="Editar Assunto"
      />
    </div>
  );
};

export default AssuntosEdit;
