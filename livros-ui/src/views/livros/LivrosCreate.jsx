import React, { useEffect, useState } from 'react';
import { createLivro } from '../../services/livrosService.js';
import { keepOnlyNumbers, parseMoneyValue, validateForm } from '../../helpers/Util.js';
import { useNavigate } from 'react-router-dom';
import LivroForm from './LivroForm.jsx';
import { isValidYear } from '../../helpers/Util.js';
import { fetchAutores } from '../../services/autoresService.js';
import { fetchAssuntos } from '../../services/assuntosService.js';

const initialFormValues = {
  titulo: '',
  editora: '',
  edicao: '',
  ano_publicacao: '',
  valor: '',
};

const requiredFields = ['titulo', 'editora', 'edicao', 'ano_publicacao', 'valor'];

const LivrosCreate = () => {
  const [formValues, setFormValues] = useState(initialFormValues);
  const [formErrors, setFormErrors] = useState({});
  const [autores, setAutores] = useState([]);
  const [pagination, setPagination] = useState({});
  const [currentPage, setCurrentPage] = useState(1);
  const [pageSize, setPageSize] = useState(5);

  const [assuntos, setAssuntos] = useState([]);
  const [assuntosPagination, setAssuntosPagination] = useState({});
  const [assuntosCurrentPage, setAssuntosCurrentPage] = useState(1);
  const [assuntosPageSize, setAssuntosPageSize] = useState(5);
  const [selectedAssuntos, setSelectedAssuntos] = useState([]);

  const navigate = useNavigate();

  const resetForm = () => {
    setFormValues(initialFormValues);
    setFormErrors({});
  };

  const onChangeInput = (e) => {
    const { name, value } = e.target;
    const newValue = name === 'ano_publicacao' ? keepOnlyNumbers(value) : value;

    setFormValues((prev) => ({
      ...prev,
      [name]: newValue,
    }));
  };

  const loadAutores = async (page = currentPage, limit = pageSize) => {
    const result = await fetchAutores({ page, limit });
    if (result.success) {
      setAutores(result.data);
      setPagination(result.pagination);
      setCurrentPage(page);
      setPageSize(limit);
    }
  };

  const loadAssuntos = async (page = assuntosCurrentPage, limit = assuntosPageSize) => {
    const result = await fetchAssuntos({ page, limit });
    if (result.success) {
      setAssuntos(result.data);
      setAssuntosPagination(result.pagination);
      setAssuntosCurrentPage(page);
      setAssuntosPageSize(limit);
    }
  };

  useEffect(() => {
    loadAutores();
    loadAssuntos();
  }, []);

  const handleSaveForm = async () => {
    const { isValid, errors } = validateForm(formValues, requiredFields);

    if (formValues.ano_publicacao && !isValidYear(formValues.ano_publicacao)) {
      errors.ano_publicacao = true;
      setFormErrors(errors);
      alert('Informe um ano de publicação válido!');
      return;
    }

    setFormErrors(errors);

    if (!isValid) {
      alert('Preencha todos os campos obrigatórios!');
      return;
    }

    const dataToSend = {
      ...formValues,
      valor: parseMoneyValue(formValues.valor),
      assuntos: selectedAssuntos,
    };

    try {
      const response = await createLivro(dataToSend);

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
    navigate('/livros');
  };

  const onSelectionChange = (values) => {
    setFormValues({ ...formValues, selectedAuthors: values });
  };

  const onAssuntosSelectionChange = (values) => {
    setSelectedAssuntos(values);
    setFormValues((prev) => ({ ...prev, selectedAssuntos: values }));
  };

  return (
    <div
      className="container mt-5 d-flex justify-content-center align-items-center"
      style={{ minHeight: '30vh' }}
    >
      <LivroForm
        formValues={formValues}
        setFormValues={setFormValues}
        formErrors={formErrors}
        onChangeInput={onChangeInput}
        onSubmit={handleSaveForm}
        onBack={onBack}
        data={autores}
        pagination={pagination}
        onPageChange={loadAutores}
        onSelectionChange={onSelectionChange}
        defaultPageSize={pageSize}
        assuntos={assuntos}
        assuntosPagination={assuntosPagination}
        onAssuntosPageChange={loadAssuntos}
        onAssuntosSelectionChange={onAssuntosSelectionChange}
        defaultAssuntosSelected={selectedAssuntos}
        defaultAssuntosPageSize={assuntosPageSize}
        labelForm="Cadastrar Livro"
      />
    </div>
  );
};

export default LivrosCreate;