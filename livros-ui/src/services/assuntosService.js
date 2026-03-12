import axios from 'axios';

const API_URL = 'http://localhost:8000/api';
const CONTROLLER = 'assuntos';

const fetchAssuntos = async (params = {}) => {
  try {
    const response = await axios.get(`${API_URL}/${CONTROLLER}`, { params });
    return {
      data: response?.data?.data || [],
      pagination: response?.data?.meta || {},
      success: true,
      message: '',
    };
  } catch (error) {
    const backendMsg = error.response?.data?.message;
    return {
      data: [],
      pagination: {},
      success: false,
      message: backendMsg || 'Erro ao buscar assuntos.',
    };
  }
};

const fetchAssunto = async (id) => {
  try {
    const response = await axios.get(`${API_URL}/${CONTROLLER}/${id}`);
    return {
      data: response?.data?.data || null,
      success: true,
      message: '',
    };
  } catch (error) {
    const backendMsg = error.response?.data?.message;
    return {
      data: null,
      success: false,
      message: backendMsg || 'Erro ao buscar o assunto.',
    };
  }
};

const createAssunto = async (form) => {
  try {
    const response = await axios.post(`${API_URL}/${CONTROLLER}`, form);
    return {
      data: response?.data?.data || null,
      success: response?.data?.success !== undefined ? response.data.success : true,
      message: 'Assunto cadastrado com sucesso.',
    };
  } catch (error) {
    const data = error.response?.data;
    return {
      data: data?.data || null,
      success: false,
      message: data?.message || 'Erro ao cadastrar o assunto.',
    };
  }
};

const updateAssunto = async (id, form) => {
  try {
    const response = await axios.put(`${API_URL}/${CONTROLLER}/${id}`, form);
    return {
      data: response?.data?.data || null,
      success: response?.data?.success !== undefined ? response.data.success : true,
      message: 'Assunto atualizado com sucesso.',
    };
  } catch (error) {
    const data = error.response?.data;
    return {
      data: data?.data || null,
      success: false,
      message: data?.message || 'Erro ao atualizar o assunto.',
    };
  }
};

const deleteAssunto = async (id) => {
  try {
    await axios.delete(`${API_URL}/${CONTROLLER}/${id}`);
    return {
      success: true,
      message: 'Assunto excluído com sucesso.',
    };
  } catch (error) {
    const backendMsg = error.response?.data?.message;
    return {
      success: false,
      message: backendMsg || 'Erro ao excluir o assunto.',
    };
  }
};

export { fetchAssuntos, fetchAssunto, createAssunto, updateAssunto, deleteAssunto };
