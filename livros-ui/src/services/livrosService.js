import axios from 'axios';

const API_URL = 'http://localhost:8000/api';
const CONTROLLER = "livros";

const fetchLivros = async (params = {}) => {
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
      message: backendMsg || 'Erro ao buscar livros.',
    };
  }
};

const fetchLivro = async (id) => {
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
      message: backendMsg || 'Erro ao buscar o livro.',
    };
  }
};

const createLivro = async (form) => {
  try {
    const response = await axios.post(`${API_URL}/${CONTROLLER}`, form);
    return {
      data: response?.data?.data || null,
      success: true,
      message: 'Livro cadastrado com sucesso.',
    };
  } catch (error) {
    const backendMsg = error.response?.data?.message;
    return {
      data: null,
      success: false,
      message: backendMsg || 'Erro ao cadastrar o livro.',
    };
  }
};

const updateLivro = async (id, form) => {
  try {
    const response = await axios.put(`${API_URL}/${CONTROLLER}/${id}`, form);
    return {
      data: response?.data?.data || null,
      success: true,
      message: 'Livro atualizado com sucesso.',
    };
  } catch (error) {
    const backendMsg = error.response?.data?.message;
    return {
      data: null,
      success: false,
      message: backendMsg || 'Erro ao atualizar o livro.',
    };
  }
};

const deleteLivro = async (id) => {
  try {
    await axios.delete(`${API_URL}/${CONTROLLER}/${id}`);
    return {
      success: true,
      message: 'Livro excluído com sucesso.',
    };
  } catch (error) {
    const backendMsg = error.response?.data?.message;
    return {
      success: false,
      message: backendMsg || 'Erro ao excluir o livro.',
    };
  }
};

export { fetchLivros, fetchLivro, createLivro, updateLivro, deleteLivro };