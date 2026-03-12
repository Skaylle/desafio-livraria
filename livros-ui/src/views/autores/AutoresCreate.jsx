
import React, { useState, useEffect } from 'react';
import { createAutor } from '../../services/autoresService.js';
import { fetchLivros } from '../../services/livrosService.js';
import { validateForm } from '../../helpers/Util.js';
import AutorForm from './AutorForm.jsx';
import { useNavigate } from 'react-router-dom';

const initialFormValues = { nome: '', selectedLivros: [] };
const requiredFields = ['nome'];

const AutoresNovo = () => {
  const [formValues, setFormValues] = useState(initialFormValues);
  const [formErrors, setFormErrors] = useState({});
  const [livros, setLivros] = useState([]);
  const [pagination, setPagination] = useState({});
  const [currentPage, setCurrentPage] = useState(1);
  const [pageSize, setPageSize] = useState(5);
  const [selectedIds, setSelectedIds] = useState([]);
  const navigate = useNavigate();

  const resetForm = () => {
    setFormValues(initialFormValues);
    setFormErrors({});
    setSelectedIds([]);
  };

  const onChangeInput = (e) => {
    const { name, value } = e.target;
    setFormValues((prev) => ({ ...prev, [name]: value }));
  };

  const loadLivros = async (page = currentPage, limit = pageSize) => {
    const result = await fetchLivros({ page, limit });
    if (result.success) {
      setLivros(result.data);
      setPagination(result.pagination);
      setCurrentPage(page);
      setPageSize(limit);
    }
  };

  useEffect(() => {
    loadLivros();
  }, []);

  const onSelectionChange = (values) => {
    setSelectedIds(values);
    setFormValues((prev) => ({ ...prev, selectedLivros: values }));
  };

  const handleCreate = async () => {
    const { isValid, errors } = validateForm(formValues, requiredFields);
    setFormErrors(errors);
    if (!isValid) {
      alert('Preencha todos os campos obrigatórios!');
      return;
    }

    // Envia os livros selecionados junto
    const dataToSend = {
      ...formValues,
      livros: selectedIds,
    };

    try {
      const response = await createAutor(dataToSend);
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
    navigate('/autores');
  };

  return (
    <div
      className="container mt-5 d-flex justify-content-center align-items-center"
      style={{ minHeight: '30vh' }}
    >
      <AutorForm
        formValues={formValues}
        setFormValues={setFormValues}
        formErrors={formErrors}
        onChangeInput={onChangeInput}
        onSubmit={handleCreate}
        onBack={onBack}
        data={livros}
        pagination={pagination}
        onPageChange={loadLivros}
        onSelectionChange={onSelectionChange}
        defaultSelected={selectedIds}
        defaultPageSize={pageSize}
        labelForm="Cadastrar Autor"
      />
    </div>
  );
};

export default AutoresNovo;
