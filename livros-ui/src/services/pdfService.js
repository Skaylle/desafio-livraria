const API_URL = 'http://localhost:8000/api';
const CONTROLLER = 'relatorio/pdf';
const abrirPDF = async () => {
  try {
 
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