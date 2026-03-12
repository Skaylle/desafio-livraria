import React, { useState, useEffect } from 'react';

const DataTable = ({
  columns,
  data,
  pagination,
  onPageChange,
  renderActions,
  rowKey = 'id',
  selectable = false,
  onSelectionChange,
  defaultPageSize = 10,
  pageSizeOptions = [5, 10, 20, 50],
  defaultSelected = [],
}) => {
  const [selectedRows, setSelectedRows] = useState(defaultSelected);
  const [pageSize, setPageSize] = useState(defaultPageSize);

  useEffect(() => {
    setSelectedRows(defaultSelected);
  }, [defaultSelected]);

  const updateSelection = (newSelection) => {
    setSelectedRows(newSelection);
    if (onSelectionChange) onSelectionChange(newSelection);
  };

  const toggleRow = (id) => {
    const newSelection = selectedRows.includes(id)
      ? selectedRows.filter((r) => r !== id)
      : [...selectedRows, id];
    updateSelection(newSelection);
  };

  const toggleAll = () => {
    const newSelection = selectedRows.length === data.length ? [] : data.map((row) => row[rowKey]);
    updateSelection(newSelection);
  };

  // Quando muda o select de quantidade por página
  const handlePageSizeChange = (e) => {
    const newSize = Number(e.target.value);
    setPageSize(newSize);
    // Sempre chama a primeira página quando muda o tamanho da página
    if (onPageChange) onPageChange(1, newSize);
  };

  // Função para navegar entre páginas
  const handlePageChange = (page) => {
    if (onPageChange) onPageChange(page, pageSize); // envia page e limit
  };

  const paginatedData = data || [];

  return (
    <>
      <div className="d-flex justify-content-end mb-2">
        <label>
          Registros por página:&nbsp;
          <select value={pageSize} onChange={handlePageSizeChange}>
            {pageSizeOptions.map((size) => (
              <option key={size} value={size}>
                {size}
              </option>
            ))}
          </select>
        </label>
      </div>

      <table className="table table-striped">
        <thead>
          <tr>
            {selectable && (
              <th>
                <input
                  type="checkbox"
                  checked={selectedRows.length === paginatedData.length && paginatedData.length > 0}
                  onChange={toggleAll}
                />
              </th>
            )}
            {columns.map((col) => (
              <th key={col.field}>{col.label}</th>
            ))}
            {renderActions && <th>Ações</th>}
          </tr>
        </thead>

        <tbody>
          {paginatedData.length === 0 && (
            <tr>
              <td
                colSpan={columns.length + (renderActions ? 1 : 0) + (selectable ? 1 : 0)}
                className="text-center"
              >
                Nenhum registro encontrado
              </td>
            </tr>
          )}

          {paginatedData.map((row) => (
            <tr key={row[rowKey]}>
              {selectable && (
                <td>
                  <input
                    type="checkbox"
                    checked={selectedRows.includes(row[rowKey])}
                    onChange={() => toggleRow(row[rowKey])}
                  />
                </td>
              )}

              {columns.map((col) => (
                <td key={col.field}>
                  {col.format ? col.format(row[col.field], row) : row[col.field]}
                </td>
              ))}

              {renderActions && <td>{renderActions(row)}</td>}
            </tr>
          ))}
        </tbody>
      </table>

      {paginatedData.length > 0 && pagination && (
        <>
          <div className="d-flex justify-content-between align-items-center mb-2">
            <div>
              Página {pagination?.current_page || 1} de {pagination?.last_page || 1}
            </div>
            <div>Total de registros: {pagination?.total || data.length}</div>
          </div>
          <nav>
            <ul className="pagination">
              {pagination?.links?.map((link, index) => (
                <li
                  key={index}
                  className={`page-item ${link.active ? 'active' : ''} ${
                    !link.url ? 'disabled' : ''
                  }`}
                >
                  <button
                    type="button"
                    className="page-link"
                    onClick={() => {
                      if (link.url) {
                        const match = link.url.match(/[?&]page=(\d+)/);
                        const page = match ? Number(match[1]) : 1;
                        handlePageChange(page);
                      }
                    }}
                    dangerouslySetInnerHTML={{ __html: link.label }}
                  />
                </li>
              ))}
            </ul>
          </nav>
        </>
      )}
    </>
  );
};

export default DataTable;
