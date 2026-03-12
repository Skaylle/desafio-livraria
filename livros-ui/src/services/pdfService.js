// src/services/PdfService.js
import axios from 'axios';

const API_URL = 'http://localhost:8000/api';
const CONTROLLER = 'relatorio/pdf'; // endpoint Laravel que gera o PDF

const abrirPDF = async () => {
  try {
    // Abre o PDF em nova aba
    window.open(`${API_URL}/${CONTROLLER}`, '_blank');

    return {
      success: true,
      message: '',
    };
  } catch (error) {
    console.error(error.message);

    return {
      success: false,
      message: 'Erro ao abrir o PDF.',
    };
  }
};

export { abrirPDF };