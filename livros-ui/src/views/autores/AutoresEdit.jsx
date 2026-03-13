import React, { useState, useEffect } from 'react';
import { fetchAutor, updateAutor } from '../../services/autoresService.js';
import { fetchLivros } from '../../services/livrosService.js';
import { validateForm } from '../../helpers/Util.js';
import AutorForm from './AutorForm.jsx';
import { useNavigate, useParams } from 'react-router-dom';

const requiredFields = ['nome'];

const AutoresEdit = () => {
  const { id } = useParams();
  const [formValues, setFormValues] = useState({ nome: '', selectedLivros: [] });
  const [formErrors, setFormErrors] = useState({});
  const [livros, setLivros] = useState([]);
  const [pagination, setPagination] = useState({});
  const [selectedIds, setSelectedIds] = useState([]);
  const [defaultPageSize, setDefaultPageSize] = useState(5);
  const navigate = useNavigate();

  useEffect(() => {
    if (id) {
      getAutor(id);
      loadLivros();
    }
  }, [id]);

  const loadLivros = async (page = 1, limit = defaultPageSize) => {
    const result = await fetchLivros({ page, limit });
    if (result.success) {
      setLivros(result.data);
      setPagination(result.pagination);
      setDefaultPageSize(limit);
    }
  };

  const getAutor = async (autorId) => {
    const result = await fetchAutor(autorId);
    if (result.success) {
      setFormValues(result.data);
     
      if (result.data && result.data.livros) {
        setSelectedIds(result.data.livros.map((l) => l.cod_livro));
      }
    } else {
      alert('Erro ao buscar os dados, tente novamente!');
      navigate('/autores');
    }
  };

  const resetForm = () => {
    setFormValues({ nome: '', selectedLivros: [] });
    setFormErrors({});
    setSelectedIds([]);
  };

  const onChangeInput = (e) => {
    const { name, value } = e.target;
    setFormValues((prev) => ({ ...prev, [name]: value }));
  };

  const onSelectionChange = (values) => {
    setSelectedIds(values);
    setFormValues((prev) => ({ ...prev, selectedLivros: values }));
  };

  const handleEdit = async () => {
    const { isValid, errors } = validateForm(formValues, requiredFields);
    setFormErrors(errors);
    if (!isValid) {
      alert('Preencha todos os campos obrigatórios!');
      return;
    }

    const dataToSend = {
      ...formValues,
      livros: selectedIds,
    };

    try {
      const response = await updateAutor(id, dataToSend);
      if (response.success) {
        alert(response.message);
        setTimeout(() => {
          resetForm();
          onBack();
        }, 500);
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
        onSubmit={handleEdit}
        onBack={onBack}
        data={livros}
        pagination={pagination}
        onPageChange={loadLivros}
        onSelectionChange={onSelectionChange}
        defaultSelected={selectedIds}
        defaultPageSize={defaultPageSize}
        labelForm="Editar Autor"
      />
    </div>
  );
};

export default AutoresEdit;
