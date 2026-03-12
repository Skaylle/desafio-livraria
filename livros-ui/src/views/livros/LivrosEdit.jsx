import React, { useState, useEffect } from 'react';
import { fetchLivro, updateLivro } from '../../services/livrosService.js';
import { keepOnlyNumbers, parseMoneyValue, validateForm } from '../../helpers/Util.js';
import { useNavigate } from 'react-router-dom';
import { useParams } from 'react-router-dom';
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

const LivrosEdit = () => {
  const { id } = useParams();
  const [formValues, setFormValues] = useState(initialFormValues);
  const [formErrors, setFormErrors] = useState({});
  const [autores, setAutores] = useState([]);
  const [pagination, setPagination] = useState({});
  const [selectedIds, setSelectedIds] = useState([]);
  const [defaultPageSize, setDefaultPageSize] = useState(5);
  // Assuntos
  const [assuntos, setAssuntos] = useState([]);
  const [assuntosPagination, setAssuntosPagination] = useState({});
  const [selectedAssuntos, setSelectedAssuntos] = useState([]);
  const [defaultAssuntosPageSize, setDefaultAssuntosPageSize] = useState(5);

  useEffect(() => {
    if (id) {
      getLivro(id);
      loadAutores();
      loadAssuntos();
    }
  }, [id]);

  const getLivro = async (livroId) => {
    const result = await fetchLivro(livroId);
    if (result.success) {
      setFormValues(result.data);
      // Marca autores relacionados
      if (result.data && result.data.autores) {
        setSelectedIds(result.data.autores.map(a => a.cod_autor));
      }
      // Marca assuntos relacionados
      if (result.data && result.data.assuntos) {
        setSelectedAssuntos(result.data.assuntos.map(a => a.cod_assunto));
      }
    } else {
      alert('Erro ao buscar os dados, tente novamente!');
      navigate('/livros');
    }
  };

  const loadAutores = async (page = 1, limit = defaultPageSize) => {
    const result = await fetchAutores({ page, limit });
    if (result.success) {
      setAutores(result.data);
      setPagination(result.pagination);
      setDefaultPageSize(limit);
    }
  };

  const loadAssuntos = async (page = 1, limit = defaultAssuntosPageSize) => {
    const result = await fetchAssuntos({ page, limit });
    if (result.success) {
      setAssuntos(result.data);
      setAssuntosPagination(result.pagination);
      setDefaultAssuntosPageSize(limit);
    }
  };

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

  const handleSaveForm = async () => {
    const { isValid, errors } = validateForm(formValues, requiredFields);

    // Validação específica de ano
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
      const response = await updateLivro(Number(id), dataToSend);

      if (response.success) {
        alert(response.message);

        setTimeout(() => {
          resetForm();
          onBack('/livros');
        }, 500);
      }else{
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
    setSelectedIds(values);
    setFormValues({...formValues, selectedAuthors: values});
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
        defaultSelected={selectedIds}
        defaultPageSize={defaultPageSize}
        assuntos={assuntos}
        assuntosPagination={assuntosPagination}
        onAssuntosPageChange={loadAssuntos}
        onAssuntosSelectionChange={onAssuntosSelectionChange}
        defaultAssuntosSelected={selectedAssuntos}
        defaultAssuntosPageSize={defaultAssuntosPageSize}
        labelForm="Editar Livro"
      />
    </div>
  );
};

export default LivrosEdit;
