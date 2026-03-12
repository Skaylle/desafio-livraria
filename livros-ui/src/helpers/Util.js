export const keepOnlyNumbers = (value) => {
    if (!value) {
        return '';
    }

    return value.replace(/\D/g, '');
}

export const parseMoneyValue = (value) => {
    value = value.replace(/\D/g, '');

    if (!value){
        return '';
    }

    value = value.replace(/\./g, '');

    let numericValue = parseFloat(value) / 100;

    return numericValue.toFixed(2);
}

export const formatMoney = (value) => {
    if (!value) return '';
    const num = typeof value === 'string' ? Number(value) : value;
    return num.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
};

export const validateForm = (formValues, requiredFields) => {
  const errors = {};
  requiredFields.forEach((field) => {
    if (!formValues[field]) errors[field] = true;
    if (field === 'ano_publicacao' && formValues[field]) {
      if (!isValidYear(formValues[field])) errors.ano_publicacao = true;
    }
  });
  return {
    isValid: Object.keys(errors).length === 0,
    errors,
  };
};

export const isValidYear = (year) => {
 if (!year) return true;

  const currentYear = new Date().getFullYear();
  const numericYear = Number(year);

  return (
    /^\d{4}$/.test(year) &&
    numericYear >= 1000 &&
    numericYear <= currentYear
  );
};