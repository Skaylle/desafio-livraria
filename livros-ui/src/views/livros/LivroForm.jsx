import React from 'react';
import Label from '../../components/Label';
import { NumericFormat } from 'react-number-format';
import AccordionSelect from '../../components/AccordionSelect.jsx';
import DataTable from '../../components/DataTable.jsx';

const columnsAutores = [{ field: 'nome', label: 'Nome' }];
const columnsAssuntos = [{ field: 'descricao', label: 'Descrição' }];

const LivroForm = ({
  formValues,
  formErrors,
  onChangeInput,
  setFormValues,
  onSubmit,
  onBack,
  data = [],
  pagination,
  onPageChange,
  onSelectionChange,
  defaultSelected = [],
  defaultPageSize,
  assuntos = [],
  assuntosPagination,
  onAssuntosPageChange,
  onAssuntosSelectionChange,
  defaultAssuntosSelected = [],
  defaultAssuntosPageSize,
  labelForm = 'Cadastrar Livro',
}) => {
  const [showCollapseAutores, setShowCollapseAutores] = React.useState(false);
  const [showCollapseAssuntos, setShowCollapseAssuntos] = React.useState(false);
  return (
    <div className="w-75 bg-white p-4 rounded shadow">
      <div className="d-flex justify-content-between align-items-center mb-3">
        <h4 className="mb-0">{labelForm}</h4>
      </div>
      <div className="row mb-4 align-items-center">
        <div className="col-md-2 col-12 text-end">
          <Label className="form-label" required htmlFor="titulo">
            Título
          </Label>
        </div>
        <div className="col-md-10 col-12 mb-2 mb-md-0">
          <input
            type="text"
            name="titulo"
            className={`form-control${formErrors.titulo ? ' is-invalid' : ''}`}
            onChange={onChangeInput}
            value={formValues.titulo}
            maxLength={40}
          />
        </div>
      </div>
      <div className="row mb-4 align-items-center">
        <div className="col-md-2 col-12 text-end">
          <Label className="form-label" required htmlFor="editora">
            Editora
          </Label>
        </div>
        <div className="col-md-4 col-12">
          <input
            type="text"
            name="editora"
            className={`form-control${formErrors.editora ? ' is-invalid' : ''}`}
            onChange={onChangeInput}
            value={formValues.editora}
            maxLength={40}
          />
        </div>
        <div className="col-md-2 col-12 text-end">
          <Label className="form-label" required htmlFor="edicao">
            Edição
          </Label>
        </div>
        <div className="col-md-4 col-12 mb-2 mb-md-0">
          <input
            type="number"
            name="edicao"
            className={`form-control${formErrors.edicao ? ' is-invalid' : ''}`}
            onChange={onChangeInput}
            value={formValues.edicao}
          />
        </div>
      </div>
      <div className="row mb-4">
        <div className="col-md-2 col-12 text-end">
          <Label className="form-label" required htmlFor="ano_publicacao">
            Ano de publicação
          </Label>
        </div>
        <div className="col-md-4 col-12">
          <input
            type="text"
            name="ano_publicacao"
            className={`form-control${formErrors.ano_publicacao ? ' is-invalid' : ''}`}
            maxLength={4}
            pattern="\d{4}"
            placeholder="AAAA"
            onChange={onChangeInput}
            value={formValues.ano_publicacao}
          />
        </div>
        <div className="col-md-2 col-12 text-end">
          <Label className="form-label" required htmlFor="valor">
            Valor
          </Label>
        </div>
        <div className="col-md-4 col-12">
          <NumericFormat
            className={`form-control${formErrors.valor ? ' is-invalid' : ''}`}
            allowNegative={false}
            decimalScale={2}
            thousandSeparator="."
            decimalSeparator=","
            prefix="R$ "
            fixedDecimalScale
            placeholder="R$"
            value={formValues.valor}
            onValueChange={(values) => {
              setFormValues((prev) => ({
                ...prev,
                valor: values.value,
              }));
            }}
          />
        </div>
      </div>
      <AccordionSelect
        id="accordionAutores"
        title="Vincular autor ao livro"
        showCollapse={showCollapseAutores}
        setShowCollapse={setShowCollapseAutores}
      >
        <DataTable
          columns={columnsAutores}
          data={data}
          pagination={pagination}
          onPageChange={onPageChange}
          selectable={true}
          rowKey="cod_autor"
          onSelectionChange={onSelectionChange}
          defaultSelected={defaultSelected}
          defaultPageSize={defaultPageSize}
        />
      </AccordionSelect>

      <AccordionSelect
        id="accordionAssuntos"
        title="Vincular assunto ao livro"
        showCollapse={showCollapseAssuntos}
        setShowCollapse={setShowCollapseAssuntos}
      >
        <DataTable
          columns={columnsAssuntos}
          data={assuntos}
          pagination={assuntosPagination}
          onPageChange={onAssuntosPageChange}
          selectable={true}
          rowKey="cod_assunto"
          onSelectionChange={onAssuntosSelectionChange}
          defaultSelected={defaultAssuntosSelected}
          defaultPageSize={defaultAssuntosPageSize}
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

export default LivroForm;
