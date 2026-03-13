import React from 'react';
import Label from '../../components/Label';
import AccordionSelect from '../../components/AccordionSelect.jsx';
import DataTable from '../../components/DataTable.jsx';

const columnsLivros = [{ field: 'titulo', label: 'Título' }];

const AssuntoForm = ({
  formValues,
  formErrors,
  onChangeInput,
  onSubmit,
  onBack,
  livros = [],
  livrosPagination,
  onLivrosPageChange,
  onLivrosSelectionChange,
  defaultLivrosSelected = [],
  defaultLivrosPageSize,
  labelForm = 'Assunto',
}) => {
  const [showCollapseLivros, setShowCollapseLivros] = React.useState(false);
  return (
    <div className="w-75 bg-white p-4 rounded shadow">
      <div className="d-flex justify-content-between align-items-center mb-3">
        <h4 className="mb-0">{labelForm}</h4>
      </div>
      <div className="row mb-4 align-items-center">
        <div className="col-md-2 col-12 text-end">
          <Label className="form-label" required htmlFor="descricao">
            Descrição
          </Label>
        </div>
        <div className="col-md-10 col-12 mb-2 mb-md-0">
          <textarea
            name="descricao"
            className={`form-control${formErrors.descricao ? ' is-invalid' : ''}`}
            onChange={onChangeInput}
            value={formValues.descricao}
            rows={4}
            maxLength={20}
          />
        </div>
      </div>

      <AccordionSelect
        id="accordionLivros"
        title="Vincular livros ao assunto"
        showCollapse={showCollapseLivros}
        setShowCollapse={setShowCollapseLivros}
      >
        <DataTable
          columns={columnsLivros}
          data={livros}
          pagination={livrosPagination}
          onPageChange={onLivrosPageChange}
          selectable={true}
          rowKey="cod_livro"
          onSelectionChange={onLivrosSelectionChange}
          defaultSelected={defaultLivrosSelected}
          defaultPageSize={defaultLivrosPageSize}
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

export default AssuntoForm;
