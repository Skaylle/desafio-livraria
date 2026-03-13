import React from 'react';
import Label from '../../components/Label';
import AccordionSelect from '../../components/AccordionSelect.jsx';
import DataTable from '../../components/DataTable.jsx';
const columns = [{ field: 'titulo', label: 'Título' }];

const AutorForm = ({
  formValues,
  formErrors,
  onChangeInput,
  onSubmit,
  onBack,
  data = [],
  pagination,
  onPageChange,
  onSelectionChange,
  defaultSelected = [],
  defaultPageSize,
  labelForm = 'Cadastrar Autor',
}) => {
  const [showCollapse, setShowCollapse] = React.useState(false);
  return (
    <div className="w-75 bg-white p-4 rounded shadow">
      <div className="d-flex justify-content-between align-items-center mb-3">
        <h4 className="mb-0">{labelForm}</h4>
      </div>
      <div className="row mb-4 align-items-center">
        <div className="col-md-2 col-12 text-end">
          <Label className="form-label" required htmlFor="nome">
            Nome
          </Label>
        </div>
        <div className="col-md-10 col-12 mb-2 mb-md-0">
          <input
            type="text"
            name="nome"
            className={`form-control${formErrors.nome ? ' is-invalid' : ''}`}
            onChange={onChangeInput}
            value={formValues.nome}
            maxLength={40}
          />
        </div>
      </div>

      <AccordionSelect
        id="accordionLivros"
        title="Vincular livro ao autor"
        showCollapse={showCollapse}
        setShowCollapse={setShowCollapse}
      >
        <DataTable
          columns={columns}
          data={data}
          pagination={pagination}
          onPageChange={onPageChange}
          selectable={true}
          rowKey="cod_livro"
          onSelectionChange={onSelectionChange}
          defaultSelected={defaultSelected}
          defaultPageSize={defaultPageSize}
        />
      </AccordionSelect>

      <div className="d-flex justify-content-end gap-2">
        <button type="button" className="btn btn-success" onClick={onSubmit}>
          Salvar
        </button>
        <button type="button" className="btn btn-danger" onClick={onBack}>
          Cancelar
        </button>
      </div>
    </div>
  );
};

export default AutorForm;
