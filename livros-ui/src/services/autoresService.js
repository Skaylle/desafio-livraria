import axios from 'axios';

const API_URL = 'http://localhost:8000/api';
const CONTROLLER = "autors";

const fetchAutores = async (params = {}) => {
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
      message: backendMsg || 'Erro ao buscar autores.',
    };
  }
};

const fetchAutor = async (id) => {
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
      message: backendMsg || 'Erro ao buscar o autor.',
    };
  }
};

const createAutor = async (form) => {
  try {
    const response = await axios.post(`${API_URL}/${CONTROLLER}`, form);
    return {
      data: response?.data?.data || null,
      success: response?.data?.success !== undefined ? response.data.success : true,
      message: 'Autor cadastrado com sucesso.',
    };
  } catch (error) {
    const data = error.response?.data;
    return {
      data: data?.data || null,
      success: false,
      message: data?.message || 'Erro ao cadastrar o autor.',
    };
  }
};

const updateAutor = async (id, form) => {
  try {
    const response = await axios.put(`${API_URL}/${CONTROLLER}/${id}`, form);
    return {
      data: response?.data?.data || null,
      success: response?.data?.success !== undefined ? response.data.success : true,
      message: 'Autor atualizado com sucesso.',
    };
  } catch (error) {
    const data = error.response?.data;
    return {
      data: data?.data || null,
      success: false,
      message: data?.message || 'Erro ao atualizar o autor.',
    };
  }
};

const deleteAutor = async (id) => {
  try {
    await axios.delete(`${API_URL}/${CONTROLLER}/${id}`);
    return {
      success: true,
      message: 'Autor excluído com sucesso.',
    };
  } catch (error) {
    const backendMsg = error.response?.data?.message;
    return {
      success: false,
      message: backendMsg || 'Erro ao excluir o autor.',
    };
  }
};

export { fetchAutores, fetchAutor, createAutor, updateAutor, deleteAutor };
