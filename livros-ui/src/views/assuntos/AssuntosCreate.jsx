import React, { useState, useEffect } from 'react';
import { createAssunto } from '../../services/assuntosService.js';
import { fetchLivros } from '../../services/livrosService.js';
import { validateForm } from '../../helpers/Util.js';
import { useNavigate } from 'react-router-dom';
import AssuntoForm from './AssuntoForm.jsx';

const initialFormValues = { descricao: '' };
const requiredFields = ['descricao'];

const AssuntosCreate = () => {
  const [formValues, setFormValues] = useState(initialFormValues);
  const [formErrors, setFormErrors] = useState({});
  const [livros, setLivros] = useState([]);
  const [pagination, setPagination] = useState({});
  const [currentPage, setCurrentPage] = useState(1);
  const [pageSize, setPageSize] = useState(5);

  const [selectedLivros, setSelectedLivros] = useState([]);

  const navigate = useNavigate();
  useEffect(() => {
    fetchLivrosList();
  }, []);

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
  const handleLivrosPageChange = (page, pageSize) => {
    setCurrentPage(page);
    setPageSize(pageSize);
    fetchLivrosList(page, pageSize);
  };

  const handleLivrosSelectionChange = (selectedRows) => {
    setSelectedLivros(selectedRows);
  };

  const resetForm = () => {
    setFormValues(initialFormValues);
    setFormErrors({});
  };

  const onChangeInput = (e) => {
    const { name, value } = e.target;
    setFormValues((prev) => ({ ...prev, [name]: value }));
  };

  const handleSaveForm = async () => {
    const { isValid, errors } = validateForm(formValues, requiredFields);
    setFormErrors(errors);
    if (!isValid) {
      alert('Preencha todos os campos obrigatórios!');
      return;
    }
    try {
      const payload = { ...formValues, selectedLivros: selectedLivros };
      const response = await createAssunto(payload);
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
        onSubmit={handleSaveForm}
        onBack={() => navigate('/assuntos')}
        livros={livros}
        livrosPagination={pagination}
        onLivrosPageChange={handleLivrosPageChange}
        onLivrosSelectionChange={handleLivrosSelectionChange}
        defaultLivrosSelected={selectedLivros}
        defaultLivrosPageSize={pageSize}
        labelForm="Cadastrar Assunto"
      />
    </div>
  );
};

export default AssuntosCreate;
